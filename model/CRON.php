<?php

namespace model;

use classe\database;
use classe\files;
use classe\routes;
use Exception;

class CRON
{


    public static $tableName = 'TB_CRON';

    public \DateTime $ultimaExecucao;
    private const cronDir = 'sistemaCRON-Windows\\';
    public string $UsoMemoria;
    public string $tempoExecucao;
    public bool $emExecucao;
    public function executarCron()
    {

        if(self::getEmExecucaoFromDatabase() === true){
            $_SESSION['emExecucao'] = 'Não é possível executar essa tarefa, pois ela já está sendo executada. Terá de esperar finalizar para começa-la novamente.';
            routes::redirect(routes::HOME_URL);
            exit;
        }
        $this->setEmExecucao(true);

        $time_start = microtime(true); 
        if (database::verificarErros() !== false){
            routes::redirect(routes::HOME_URL);

        }
        try{
        $a = new files();
        $a->execute();

        }catch(Exception $e){

            echo $e->getMessage();
            exit;
        }
        $this->setMemoryUsage();
        $time_end = microtime(true);
        $this->tempoExecucao = number_format($time_end - $time_start, 2);
        $this->tempoExecucao .= ' segundos';
        $this->salvar();
    }
    public function setMemoryUsage(){
        $this->UsoMemoria = round(memory_get_usage()/1048576,2).''.' MB';
        $this->ultimaExecucao = new \DateTime('now');  
     }
    public function salvar()
    {
        
        $pdo = database::conectar()->prepare('UPDATE `' . self::$tableName . '` SET `ultimaExecucao` = ?,`UsoMemoria` = ?, `tempoExecucao` = ?, `emExecucao` = ?');
        $pdo->execute([$this->ultimaExecucao->format(database::MYSQLDateFormat), $this->UsoMemoria, $this->tempoExecucao, false]);
    }
    public static function getEmExecucaoFromDatabase(){
        $pdo = database::conectar()->prepare('SELECT `emExecucao` from `'.self::$tableName.'`');
        $pdo->execute();
        return (bool)$pdo->fetch()['emExecucao'];
    }
    public function setEmExecucao(bool $emExecucao){
        if(self::verificarTabelaVazia() === false){
            $pdo = database::conectar()->prepare('INSERT INTO `' . self::$tableName . '` (`emExecucao`) VALUES (?)');            
        }else{
            $pdo = database::conectar()->prepare('UPDATE `' . self::$tableName . '` SET `emExecucao` = ?');
        }
        $pdo->execute([$emExecucao]);
    } 
    public static function verificarTabelaVazia(){
        $pdo = database::conectar()->prepare('SELECT * from `'.self::$tableName.'`');
        $pdo->execute();
        if($pdo->fetch() === false){
            return false;        
        } else{
            return true;

        }
    }
    public static function selecione():CRON | null{
        $cron = database::selectAll(CRON::$tableName);
       
    
        if(count($cron) > 0)
            return self::arrayToClass($cron);
        return null;
    }
    public static function arrayToClass(array $listItems){
        $app = new CRON();
        $app->ultimaExecucao = new \DateTime($listItems[0]['ultimaExecucao']);    
        $app->UsoMemoria = $listItems[0]['UsoMemoria'];
        $app->tempoExecucao = $listItems[0]['tempoExecucao'];
        return $app;      
    }
    public static function criarAgendaCRON()
    {
        $xml = '<Task xmlns="http://schemas.microsoft.com/windows/2004/02/mit/task" version="1.2">
        <RegistrationInfo>
        <Date>2023-01-23T11:59:17.3801063</Date>
        <Author>Laptop-user256</Author>
        <Description>Tarefa criada para atualizar o banco de dados, no melhor horario, do servidor de Produtos.</Description>
        <URI>\sincronizarServidorPHP</URI>
        </RegistrationInfo>
        <Triggers>
        <CalendarTrigger>
        <StartBoundary>2023-01-23T04:00:00-03:00</StartBoundary>
        <Enabled>true</Enabled>
        <ScheduleByDay>
        <DaysInterval>1</DaysInterval>
        </ScheduleByDay>
        </CalendarTrigger>
        </Triggers>
        <Principals>
        <Principal id="Author">
        <UserId>S-1-5-21-91566599-1036412710-562258968-1001</UserId>
        <LogonType>InteractiveToken</LogonType>
        <RunLevel>LeastPrivilege</RunLevel>
        </Principal>
        </Principals>
        <Settings>
        <MultipleInstancesPolicy>IgnoreNew</MultipleInstancesPolicy>
        <DisallowStartIfOnBatteries>true</DisallowStartIfOnBatteries>
        <StopIfGoingOnBatteries>true</StopIfGoingOnBatteries>
        <AllowHardTerminate>false</AllowHardTerminate>
        <StartWhenAvailable>false</StartWhenAvailable>
        <RunOnlyIfNetworkAvailable>false</RunOnlyIfNetworkAvailable>
        <IdleSettings>
        <StopOnIdleEnd>true</StopOnIdleEnd>
        <RestartOnIdle>false</RestartOnIdle>
        </IdleSettings>
        <AllowStartOnDemand>true</AllowStartOnDemand>
        <Enabled>true</Enabled>
        <Hidden>false</Hidden>
        <RunOnlyIfIdle>false</RunOnlyIfIdle>
        <WakeToRun>false</WakeToRun>
        <ExecutionTimeLimit>PT0S</ExecutionTimeLimit>
        <Priority>7</Priority>
        </Settings>
        <Actions Context="Author">
        <Exec>
        <Command>"C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe"</Command>
        <Arguments>https://' . routes::HOME_URL . '/CronUpdateWindowsTask</Arguments>
        </Exec>
        </Actions>
        </Task>';
        $document = new \DOMDocument('1.2');
        $document->loadXML($xml);
        if (!file_exists(self::cronDir))
            mkdir(self::cronDir);
        $document->save(self::cronDir . 'agendador.xml');

    }
}


?>