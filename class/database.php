<?php
require_once('./model/produto.php');
use model\produto as Produto;
use model\status as Status;
class database
{
    static $pdo;
    private const HOST = DATABASE['HOST'], USERNAME = DATABASE['USERNAME'], PASSWORD = DATABASE['PASSWORD'], DATABASE = DATABASE['DATABASE'];



    public static function conectar()
    {
        if (!isset(self::$pdo))
            self::$pdo = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::DATABASE, self::USERNAME, self::PASSWORD);
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
        $produto->imported_t = date('now');
        $sql = 'INSERT INTO `' . Produto::TABLE . '` (' . $keys . ') VALUES (' . $bind . ')';
        
        $pdo = self::conectar()->prepare($sql);

        $count = 1;
        foreach ($produto as $key => $value) {
            $pdo->bindValue($count, $value, PDO::PARAM_STR);
            $count++;
        }
     
        $pdo->execute();
    }

    public static function verificarCriarTabelas()
    {

        $query = 'CREATE TABLE IF NOT EXISTS `' . Produto::TABLE . '` (';

        $produtoModel = new Produto();
        $produtoModel = array_keys((array) $produtoModel);
        $queryItens = '';
        foreach ($produtoModel as $item) {
            switch ($item) {
                case 'code':
                    $queryItens .= $item . ' bigint not null,';
                    break;
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