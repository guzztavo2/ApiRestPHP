<?php



?>
<div class="row container mx-auto">
    <div class="row col-12 m-2 p-2 shadow" style="border: 1px solid #cccc">
        <h1 class="fw-light fs-4 text-bg-primary col-auto p-3 shadow rounded" style="text-transform:uppercase;">Status
            da base
            de dados
        </h1>
        <?php if (isset($bancoErro)): ?>
            <div class="col-12 mt-2 p-2 row justify-content-center">
                <span class="text-bg-danger col-auto fw-light col-auto text-center shadow">
                    ❌Não é possivel acessar o banco de dados no momento, pois possui um erro: <br>
                    <?php echo $bancoErro ?>
                </span>
            </div>
        <?php else: ?>
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
       
        <?php if (isset($bancoErro)): ?>
            <div class="col-12 mt-2 p-2 row justify-content-center">
                <span class="text-bg-danger col-auto fw-light col-auto text-center shadow">
                    ❌Não é possivel acessar o banco de dados no momento, pois possui um erro: <br>
                    <?php echo $bancoErro ?>
                </span>
            </div>
        <?php elseif (isset($baixarArquivoErro)): ?>
            <div class="col-12 mt-2 p-2 row justify-content-center">
                <span class="text-bg-danger col-auto fw-light col-auto text-center shadow">
                    ❌Não é possivel acessar o Sistema CRON no momento, pois possui um erro: <br>
                    <?php echo $bancoErro ?>
                </span>
            </div>
        <?php else: ?>
            <div class="col-6 row mx-auto m-1 p-2" style="border: 1px solid #cccc">
            <div class="text-bg-success col-5 shadow p-2">
                <span class="fs-5">Ultima vez executado:</span>
            </div>
            <button type="button" class="btn btn-outline-primary shadow col-6 mx-auto">Primary</button>

        </div>
        <div class="col-6 row mx-auto m-1 p-2" style="border: 1px solid #cccc">
            <div class="text-bg-success col-5 shadow p-2">
                <span class="fs-5">Tempo online:</span>
            </div>
            <button type="button" class="btn btn-outline-dark shadow col-6 mx-auto">Primary</button>

        </div>

        <div class="col-6 row mx-auto m-1 p-2" style="border: 1px solid #cccc">

            <div class="text-bg-success col-5 shadow p-2">
                <span class="fs-5">Uso da Memória:</span>
            </div>
            <button type="button" class="btn btn-outline-danger shadow col-6 mx-auto">Primary</button>

        </div>
        <div class="col-6 row mx-auto m-1 p-2" style="border: 1px solid #cccc">

            <div class="text-bg-success col-5 shadow p-2">
                <span class="fs-5">Próxima execução:</span>

            </div>
            <button type="button" class="btn btn-outline-success col-6 mx-auto">Primary</button>

        </div>
        <div class="col-12 row mx-auto m-1 p-2" style="border: 1px solid #cccc">

            <div class="text-bg-danger col-3 shadow p-2">
                <span class="fs-5">Executar agora:</span>

            </div>
            <button type="button" class="btn btn-outline-primary col-8 shadow mx-auto">Primary</button>

        </div>

        <?php endif; ?>

    </div>

</div>