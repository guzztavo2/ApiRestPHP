<?php

namespace model;

use classe\database;
use classe\files;
use classe\routes;

class CRON
{


    public static $tableName = 'TB_CRON';

    public \DateTime $ultimaExecucao;
    private const cronDir = 'sistemaCRON-Windows\\';
    public string $UsoMemoria;

    public function executarCron()
    {
        if (database::verificarErros() !== false)
            routes::redirect(routes::HOME_URL);
        $a = new files();
        $a->execute();
        $this->setMemoryUsage();
    }
    public function setMemoryUsage(){
        $this->UsoMemoria = round(memory_get_usage()/1048576,2).''.' MB';
        $this->ultimaExecucao = new \DateTime('now');
        $this->salvar();
     }
    public function salvar()
    {
        database::truncateTabela(self::$tableName);
        $pdo = database::conectar()->prepare('INSERT INTO `' . self::$tableName . '` (`ultimaExecucao`,`UsoMemoria`) VALUES (?,?)');
        $pdo->execute([$this->ultimaExecucao->format(database::MYSQLDateFormat), $this->UsoMemoria]);
    }
    public static function selecione():CRON{
        $cron = database::selectAll(CRON::$tableName);
        return self::arrayToClass($cron)[0];
    }
 public static function arrayToClass(array $listItems){
        $produtoKeys = array_keys((array) new CRON);
        $resultado = [];
        foreach($listItems as $item){
            $produto = new CRON();
           
            foreach($produtoKeys as $key){
                $produto->{$key} = $item[$key];
            }
            $resultado[] = $produto;
        }
        return $resultado;
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