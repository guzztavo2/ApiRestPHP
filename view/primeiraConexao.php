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
if((int)date('H') >= 0 && (int)date('H') < 12){
    $greetingMessage = 'Bom dia!';
}else if((int)date('H') >= 12 && (int)date('H') < 18){
    $greetingMessage = 'Boa tarde!';
} else if((int)date('H') >= 18 && (int)date('H') <= 23){
    $greetingMessage = 'Boa noite!';
}
?>
<body class="row mx-auto justify-content-center">
    <div class="container col-6 row text-bg-success shadow-lg mx-auto p-4 mt-2">
        <h1 class="display-6 fs-4 fw-bolder"><?php echo $greetingMessage ?></h1>
        <span class="p-2 mt-2 text-center">
            <b class="text-bg-danger shadow text-center col-12 p-2 d-block">Foi verificado, e possivelmente é a sua primeira conexão no servidor, se não for isso, possivelmente há um erro no banco de dados.</b>
            
            <br><br>
            
            Como por exemplo:
            Se você estiver utilizando Windows, é importante setar uma tarefa para poder executar e manter a sincronia do servidor.
            <br><br>
            Essa tarefa é importante, pois assim você sempre manterá o API-REST sincronizada corretamente com o banco de dados primário.
            Como essa sincronia é uma tarefa que leva alguns segundos, e detém uma instabilidade no 
            servidor, ela foi automaticamente definida para ser feita as 4:00 horas (AM), todos os dias.

            Mas antes disso, você precisará acessar a pasta raiz do servidor, e ir até:<br>
            <br>
            <b class="text-bg-primary col-4 p-2 rounded shadow">pasta_raiz / sistemaCRON-Windows / agendador.xml</b><br><br>

            Se tudo correu bem na hora da instalação, essa pasta possui um arquivo XML.
            <br><br>
            <b class="row p-2 text-bg-danger col-6 mx-auto rounded shadow" style="text-align: left;">
            Siga as seguintes instruções:<br><br>
            1 - Abra o PROMPT de Comandos<br><br>
            2 - Digite o seguinte código:<br><br>
            taskschd.msc<br><br>
            3 - Com a aplicação aberta, no canto direito há a informação: <br>
            "Importar Tarefa"
            <br><br>
            4 - Logo depois, é só passar o caminho do arquivo XML e confirmar.<br><br>
            5 - Pronto, tudo certo.    </b>
         
            <br><br>
            Com tudo isso feito, todos os dias, as 4 horas da manhã, o banco de dados atual será completamente deletado, e substituido por informações atualizadas
            do banco de dados do <a href="https://br.openfoodfacts.org/data" style="text-decoration: none;" class=" d-inline-block col-2 text-center text-bg-danger fw-bolder" target="_blank" rel="noopener noreferrer">Open Food Facts</a>
            <br><br>
            
            <b class="mt-2 text-bg-dark p-2 rounded shadow">Se você quiser, poderá deletar essa pasta após o arquivo ser setado no servidor</b> <br><br>
            Tudo isso, através de um link que será checado se realmmente é 4:00AM horas.<br><br>
            <b class="mt-2 text-bg-primary p-2 rounded shadow">Após finalizar, é só recarregar a página que está tudo certo.</b> <br><br>

        </span>
    </div>
</body>
</html>