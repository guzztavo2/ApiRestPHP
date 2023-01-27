<?php

use classe\database;


?>

<?php if(model\CRON::getEmExecucaoFromDatabase() === true): ?>
    <div class="alert alert-danger alert-dismissible fade show container text-center" role="alert">
  <strong>No momento, não será possível executar a API, pois ela já está em execução. Volte aqui depois de alguns minutos, e poderá executa-la novamente.</strong><br>
  A execução estará finalizada, quando essa mensagem estiver desaparecido (quando recarregar a página). 
  <div class="spinner-border" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<div class="row container mx-auto">
    <div class="row col-12 m-2 p-2 shadow" style="border: 1px solid #cccc">
        <h1 class="fw-light fs-4 text-bg-primary col-auto p-3 shadow rounded" style="text-transform:uppercase;">Status
            da base
            de dados
        </h1>
        <?php if (isset($bancoErro)) : ?>
            <div class="col-12 mt-2 p-2 row justify-content-center">
                <span class="text-bg-danger col-auto fw-light col-auto text-center shadow">
                    ❌Não é possivel acessar o banco de dados no momento, pois possui um erro: <br>
                    <?php echo $bancoErro ?>
                </span>
            </div>
        <?php else : ?>
            <div class="col-12 row mx-auto m-1 p-2" style="border: 1px solid #cccc">

                <div class="text-bg-success col-3 shadow p-2">
                    <span class="fs-5 col-12 text-center">STATUS:</span>

                </div>
                <button type="button" class="btn btn-primary col-5 shadow mx-auto">Tudo funcionando perfeitamente!</button>

            </div>
        <?php endif; ?>
    </div>

    <div class="row col-12 m-2 p-2 shadow" style="border: 1px solid #cccc">
        <h1 class="fw-light fs-4 text-bg-danger d-inline-block p-3 shadow rounded" style="text-transform:uppercase;">
            Status do
            Sistema
            CRON</h1>

        <?php if (isset($bancoErro)) : ?>
            <div class="col-12 mt-2 p-2 row justify-content-center">
                <span class="text-bg-danger col-auto fw-light col-auto text-center shadow">
                    ❌Não é possivel acessar o banco de dados no momento, pois possui um erro: <br>
                    <?php echo $bancoErro ?>
                </span>
            </div>
        <?php elseif (isset($baixarArquivoErro)) : ?>
            <div class="col-12 mt-2 p-2 row justify-content-center">
                <span class="text-bg-danger col-auto fw-light col-auto text-center shadow">
                    ❌Não é possivel acessar o Sistema CRON no momento, pois possui um erro: <br>
                    <?php echo $bancoErro ?>
                </span>
            </div>
        <?php else : ?>
            <div class="col-6 row mx-auto m-1 p-2 align-items-center text-center" style="border: 1px solid #cccc">
                <div class="text-bg-success col-5 shadow p-2">
                    <span class="fs-5">Ultima vez executado:</span>
                </div>
                <button type="button" id="ultimaVezExecutado" class="btn btn-outline-primary shadow col-6 mx-auto">
                    <?php
                    if ($cron === null)
                        echo 'Ainda não foi executado';
                    else {
                        if($cron->ultimaExecucao !== null) :
                        $datetime = new DateTime('now');
                        $interval = date_diff($cron->ultimaExecucao, $datetime);
                        echo $interval->format('%h/%i/%s');
                        else:
                        echo 'Ainda não foi executado';
                        endif;
                    }
                    ?></button>

            </div>
            <div class="col-6 row mx-auto m-1 p-2 align-items-center text-center" style="border: 1px solid #cccc">
                <div class="text-bg-success col-5 shadow p-2 rounded">
                    <span class="fs-5">Tempo online:</span>
                </div>
                <button type="button" id="tempoOnline" class="btn btn-outline-dark shadow col-6 mx-auto rounded"
                    
                >
                    <?php
                    $datetime = new DateTime('now');
                    $interval = date_diff($app->tempoOnline, $datetime);
                    echo $interval->format('%h/%i/%s');

                    ?></button>
            </div>
            <div class="col-6 row mx-auto m-1 p-2 align-items-center text-center " style="border: 1px solid #cccc">

                <div class="text-bg-success text-center col-5 shadow p-2 rounded">
                    <span class="fs-5">Uso da Memória:</span>
                </div>
                <button type="button" class="btn btn-outline-danger shadow col-6 mx-auto rounded">
                    <?php
                    if ($cron !== null)
                        echo $cron->UsoMemoria !== null ? $cron->UsoMemoria : 'Ainda não foi executado.';
                    else
                        echo 'Ainda não foi executado';
                    ?>
                </button>

            </div>
            <div class="col-6 row mx-auto m-1 p-2 align-items-center text-center " style="border: 1px solid #cccc">

                <div class="text-bg-success col-5 shadow p-2 rounded">
                    <span class="fs-5">Próxima execução (automática):</span>

                </div>
                <button type="button" id="proximaExecucao" class="btn btn-outline-success col-6 mx-auto rounded ">
                    <?php
                    $datetime = new DateTime('now');
                    //H:i:s d-m-Y
                    $datetime2 = date(database::BrDateTimeFormat, strtotime($datetime->format(database::BrDateTimeFormat) . '+ 1 day'));
                    $datetime2 = new DateTime($datetime2);
                    $datetime2->setTime(4, 0, 0);
                    $interval = date_diff($datetime, $datetime2);
                    echo $interval->format('%h/%i/%s');

                    ?>
                </button>

            </div>
            <?php if(model\CRON::getEmExecucaoFromDatabase() === false): ?>
            <div class="col-6 row mx-auto m-1 p-2 align-items-center text-center" style="border: 1px solid #cccc">

                <div class="text-bg-danger col-3 shadow p-2 rounded">
                    <span class="fs-5">Executar agora:</span>

                </div>
                <button type="button" id="btnExecute" class="btn btn-outline-primary col-8 shadow mx-auto rounded">Clique aqui e execute agora</button>

            </div>
            <?php endif; ?>
            <div class="col-6 row mx-auto m-1 p-2 align-items-center text-center" style="border: 1px solid #cccc">

                <div class="text-bg-success col-5 shadow p-2 rounded">
                    <span class="fs-5">Duração da execução:</span>

                </div>
                <button type="button" class="btn btn-outline-danger shadow col-6 mx-auto rounded">
                    <?php
                    if ($cron !== null)
                        echo $cron->tempoExecucao !== null ? $cron->tempoExecucao : 'Ainda não foi executado.';
                    else
                        echo 'Ainda não foi executado';
                    ?>
                </button>

            </div>
        <?php endif; ?>

    </div>

</div>