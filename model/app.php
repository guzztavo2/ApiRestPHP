<?php

namespace model;
use classe\database;
class app{


    public static $tableName = 'tb_app';

    public \DateTime $tempoOnline;


    public static function checkExist():bool{
        try{
            $pdo = database::conectar()->prepare('SELECT 1 FROM `' . self::$tableName . '`');
            $pdo->execute();
        }catch(\PDOException $e){
            return false;
        }
        return true;
     

    }
    public static function selecione():app{
        $cron = database::selectAll(app::$tableName);
        return self::arrayToClass($cron)[0];
    }
 public static function arrayToClass(array $listItems){
        $produtoKeys = array_keys((array) new app);
        $resultado = [];
        foreach($listItems as $item){
            $produto = new app();
           
            foreach($produtoKeys as $key){
                $produto->{$key} = $item[$key];
            }
            $resultado[] = $produto;
        }
        return $resultado;
    }

    public function salvar(){
        $pdo = database::conectar()->prepare('INSERT INTO `' . self::$tableName . '` (`tempoOnline`) VALUES (?)');
        $pdo->execute([date('Y-m-d H:i:s')]);
    }
}


?>