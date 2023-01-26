<?php
namespace classe;
use model\app;
use model\CRON;
use model\produto as Produto;
use model\status as Status;
use PDOException;


class database
{
    static $pdo;
    private const HOST = DATABASE['HOST'], USERNAME = DATABASE['USERNAME'], PASSWORD = DATABASE['PASSWORD'], DATABASE = DATABASE['DATABASE'];
    public const MYSQLDateFormat = 'Y-m-d H:i:s';
    public const BrDateTimeFormat = 'H:i:s d-m-Y';

    public static function conectar()
    {


        try {
            if (!isset(self::$pdo))
                self::$pdo = new \PDO('mysql:host=' . self::HOST . ';dbname=' . self::DATABASE, self::USERNAME, self::PASSWORD);
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível se conectar ao banco de dados no momento, um problema que logo será resolvido.');
        }


        return self::$pdo;


    }
    public static function insertProduto(Produto $produto)
    {
       
        $keys = array_keys($produto->getListProperties());
     
        $bind = array_map(function () {
            return '?';
        }, $keys);

        $bind = implode(',', $bind);
        $keys = implode(',', $keys);

      
        
        $produto->setStatus(Status::PUBLISHED);
        $produto->code = str_replace('"', '', $produto->code);
        $produto->{'imported_t'} = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO `' . Produto::TABLE . '` (' . $keys . ') VALUES (' . $bind . ')';
       
        
        $pdo = self::conectar()->prepare($sql);

        $count = 1;
        foreach ($produto->getListProperties() as $key => $value) {
            $pdo->bindValue($count, $value, \PDO::PARAM_STR);
            $count++;
        }
        $pdo->execute();
 
    }

    public static function selectAll(string $tableName): array
    {
        $pdo = database::conectar()->prepare('SELECT * FROM `' . $tableName . '`');
        $pdo->execute();
        $pdo->setFetchMode(\PDO::FETCH_ASSOC);
     
        return $pdo->fetchAll();
    }
    public static function find($tableName, array $options)
    {
    
        $pdo = database::conectar()->prepare('SELECT * FROM `' . $tableName . '` ' . $options[0]);

       
        if(!isset($options[1]))
            $pdo->execute();
        else
            $pdo->execute($options[1]);


        $pdo->setFetchMode(\PDO::FETCH_ASSOC);
        return $pdo->fetchAll();

    }
    public static function salvar($tablename, array $keys_values, array $where)
    {

        $pdo = database::conectar()->prepare('UPDATE `' . $tablename . '` SET ' . $keys_values[0] . ' WHERE ' . $where[0]);
        $pdo->execute(array_merge($keys_values[1], [$where[1]]));
    }
    public static function truncateTabela($tablename)
    {
        $pdo = database::conectar()->prepare('TRUNCATE TABLE `' . $tablename . '`');
        $pdo->execute();
    }
    public static function verificarCriarTabelas()
    {
        self::verificarCriarProdutosTabela();
        self::verificarCriarCRONTabela();
       
    }
    public static function verificarCriarCRONTabela()
    {
        $query = 'CREATE TABLE IF NOT EXISTS `' . CRON::$tableName . '` (
            ultimaExecucao datetime,
            UsoMemoria varchar(100),
            tempoExecucao varchar(20),
            emExecucao boolean
        )';
        $pdo = self::conectar()->prepare($query);
        $pdo->execute();
    }
    public static function verificarCriarAPPTabela()
    {

        $query = 'CREATE TABLE IF NOT EXISTS `' . app::$tableName . '` (
            tempoOnline datetime not null
        )';
        try {
            $pdo = self::conectar()->prepare($query);
            $pdo->execute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }


    }
    private static function verificarCriarProdutosTabela()
    {
        $query = 'CREATE TABLE IF NOT EXISTS `' . Produto::TABLE . '` (';

        $produtoModel = new Produto();
        $produtoModel = $produtoModel->getListProperties();

        $queryItens = '';
        foreach ($produtoModel as $item => $value) {
            switch ($item) {
                case 'created_t':
                    $queryItens .= $item . ' datetime not null,';
                    break;
                case 'last_modified_t':
                    $queryItens .= $item . ' datetime not null,';
                    break;
                case 'serving_quantity':
                    $queryItens .= $item . ' float not null,';

                    break;
                case 'nutriscore_score':
                    $queryItens .= $item . ' int not null,';
                    break;
                default:
                    $queryItens .= $item . ' varchar(255) not null,';
                    break;
            }
        }
       
        $queryItens = substr($queryItens, 0, -1) . ')';
        $query .= $queryItens;
      

        $pdo = self::conectar()->prepare($query);
     
        $pdo->execute();
     
    }

    public static function verificarErros(): false|string
    {
        if (isset($_SESSION['error'][0]['bancoDadosError'])) {
            return $_SESSION['error'][0]['bancoDadosError'];
        }
        return false;
    }

}