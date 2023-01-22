<?php
namespace classe;

use DomainException;
use ErrorException;
use FFI\Exception;
use model\produto as Produto;
use model\status as Status;
use PDOException;


class database
{
    static $pdo;
    private const HOST = DATABASE['HOST'], USERNAME = DATABASE['USERNAME'], PASSWORD = DATABASE['PASSWORD'], DATABASE = DATABASE['DATABASE'];



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
        $keys = array_keys((array) $produto);
        $bind = array_map(function () {
            return '?';
        }, $keys);

        $bind = implode(',', $bind);
        $keys = implode(',', $keys);

        $produto->setStatus(Status::DRAFT);
        $produto->imported_t = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO `' . Produto::TABLE . '` (' . $keys . ') VALUES (' . $bind . ')';

        $pdo = self::conectar()->prepare($sql);

        $count = 1;
        foreach ($produto as $key => $value) {
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
        $pdo->execute($options[1]);
        $pdo->setFetchMode(\PDO::FETCH_ASSOC);
        return $pdo->fetchAll();

    }
    public static function salvar($tablename, array $keys_values, array $where)
    {

        $pdo = database::conectar()->prepare('UPDATE `' . $tablename . '` SET ' . $keys_values[0] . ' WHERE ' . $where[0]);
        $pdo->execute(array_merge($keys_values[1], [$where[1]]));
    }
    public static function verificarCriarTabelas()
    {

        $query = 'CREATE TABLE IF NOT EXISTS `' . Produto::TABLE . '` (';

        $produtoModel = new Produto();
        $produtoModel = array_keys((array) $produtoModel);
        $queryItens = '';
        foreach ($produtoModel as $item) {
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

}