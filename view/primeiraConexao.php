<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primeira conexão</title>
    <link rel="stylesheet" href="<?php echo classe\routes::HOME_URL; ?>css\bootstrap">
    <script src="<?php echo classe\routes::HOME_URL; ?>js\bootstrap"></script>
</head>
<?php
$greetingMessage = '';
if ((int)date('H') >= 0 && (int)date('H') < 12) {
    $greetingMessage = 'Bom dia!';
} else if ((int)date('H') >= 12 && (int)date('H') < 18) {
    $greetingMessage = 'Boa tarde!';
} else if ((int)date('H') >= 18 && (int)date('H') <= 23) {
    $greetingMessage = 'Boa noite!';
}
?>

<body class="row mx-auto justify-content-center">
    <div class="col-7 row shadow mx-auto mt-2 p-2 rounded" style="background-color: #ccc;">

        <h1 class="d-block fs-3 text-bg-primary fw-bolder rounded p-4">
            <hr><?php echo $greetingMessage ?>
            <hr>
        </h1>

        <span class="text-center">
            <b class="text-bg-danger shadow text-center col-12 p-2 d-block rounded">Foi verificado, e possivelmente é a sua primeira conexão no servidor, se não for isso, possivelmente há um erro no banco de dados.</b>
        </span>
        <br><br>
        <button class="btn btn-primary col-10 p-2 mx-auto m-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <b>Clique aqui, se for sua primeira vez.</b>
        </button>
        <div class="text-center collapse mt-4" id="collapseExample">
            <span class="card card-body">
            <b class="d-block text-bg-warning">Se você estiver utilizando Windows, é importante adicionar a "tarefa" no "Agendador de Tarefas" para atualizar, executar e manter a sincronia do servidor.</b>
                <b class="d-block text-bg-dark">Entretanto, isso NÃO É NECESSÁRIO PARA RODAR O PROJETO.</b>
                <br><br>
                Essa tarefa é importante, pois assim você sempre manterá o API-REST sincronizada corretamente com o banco de dados primário.
                Como essa sincronia é uma tarefa que leva alguns segundos, e detém uma instabilidade no
                servidor, ela foi automaticamente definida para ser feita as 4:00 horas (AM), todos os dias.

                Mas antes disso, você precisará acessar a pasta raiz do servidor, e ir até:<br>
                <br>
                <b class="text-bg-primary col-4 p-2 rounded shadow mx-auto">pasta_raiz / sistemaCRON-Windows / agendador.xml</b><br><br>

                Se tudo correu bem na hora da instalação, essa pasta possui um arquivo XML.
                <br><br>
                <b class="row p-2 text-bg-danger col-6 mx-auto rounded shadow fw-normal" style="text-align: left;">
                    <b class="text-center p-2">Siga as seguintes instruções:</b><br><hr>
                    1 - Abra o PROMPT de Comandos<br><hr>
                    2 - Digite o seguinte código:
                    <b class="text-center">taskschd.msc</b><br><hr>
                    3 - Com a aplicação aberta, no canto direito há a informação: <br>
                    <b class="text-center">"Importar Tarefa"</b><br><hr>
                    4 - Logo depois, é só passar o caminho do arquivo XML gerado automaticamente na raiz do servidor e confirmar.<br><hr>
                    <b class="text-center fw-light">PRONTO TUDO CERTO!</b><hr> </b>

                <br><br>
                Com tudo isso feito, todos os dias, as 4 horas da manhã, o banco de dados atual será completamente deletado, e substituido por informações atualizadas
                do banco de dados do <a href="https://br.openfoodfacts.org/data" style="text-decoration: none;" class=" mx-auto col-2 text-center text-bg-danger fw-bolder" target="_blank" rel="noopener noreferrer">Open Food Facts</a>
                <br><br>

                <b class="mt-2 text-bg-dark p-2 rounded shadow">Se você quiser, poderá deletar essa pasta a qualquer momento, entretanto, para conseguir recupera-la, precisará apagar as tabelas do banco de dados desse servidor
                    se precisar recuperar novamente.
                </b> <br><br>
                O que esse arquivo fará? Nada mais que: abrir um link. Às 4:00AM, o servidor disponibilizará o REQUEST GET para o link: /CronUpdateWindowsTask. Assim terá como manter atualizado sem afetar o desempenho do servidor.
                <br><br>
                <b class="mt-2 text-bg-primary p-2 rounded shadow">Após finalizar, é só recarregar a página que está tudo certo.</b> <br><br>
            </span>
        </div>
    </div>
</body>

</html>