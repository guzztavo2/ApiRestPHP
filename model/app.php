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
        $cron = self::arrayToClass($cron);
        
        return $cron;
    }
 public static function arrayToClass(array $listItems){
        $app = new app();
        $app->tempoOnline = new \DateTime($listItems[0]['tempoOnline']);    
        return $app;      
    }

    public function salvar(){
        $pdo = database::conectar()->prepare('INSERT INTO `' . self::$tableName . '` (`tempoOnline`) VALUES (?)');
        $pdo->execute([date('Y-m-d H:i:s')]);
    }
}


?>