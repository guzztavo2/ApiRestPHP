<div class="row shadow justify-content-center align-items-center bg-warning mx-auto" style="height: 82%; background-color:#cccc">
    <div class="col-4 h-100 justify-content-center p-4">
        <div id="list-example" class="list-group">
            <a class="list-group-item list-group-item-action" href="#list-item-1">Bem-vindo</a>
            <a class="list-group-item list-group-item-action" href="#list-item-2">Automatizar o servidor</a>
            <a class="list-group-item list-group-item-action" href="#list-item-3">Executação da API</a>
            <a class="list-group-item list-group-item-action" href="#list-item-4">Visualizando produtos</a>
            <a class="list-group-item list-group-item-action" href="#list-item-5">Buscando produtos</a>
            <a class="list-group-item list-group-item-action" href="#list-item-6">Editando produtos</a>
            <a class="list-group-item list-group-item-action" href="#list-item-7">Deletando produtos</a>
        </div>
    </div>
    <div class="col-8 p-4 h-100">
        <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-example h-50" style="overflow: auto;" tabindex="0">
            <div id="list-item-1" class="text-bg-danger m-3 p-3 rounded shadow">
                <h4>Bem vindo</h4>
                <p>
                    Seja bem-vindo a API REST de produtos alimenticios, o modelo segue a seguinte base:
                    <?php
                    $produto = new model\produto();
                    foreach (array_keys($produto->getListProperties()) as $propriedade) {
                        echo '<hr><b class="d-block text-center">' . $propriedade . '</b>';
                    }
                    ?> </p>
            </div>
            <div id="list-item-2" class="text-bg-danger m-3 p-3 rounded shadow">
                <h4>Automatizar o servidor</h4>
                <p>
                    Para você iniciar o Servidor, é importante automatizar os serviços. Utilizando o automatizador de serviços do Windows, e na pasta raiz, em um diretório chamado: 'SistemaCRON-Windows' (pois só funciona para o windows). Você poderá adicionar esse arquivos 'XML', no apliativo já mencionado do Windows (Agendador de Tarefas).
                    <br><br>"O que essa tarefa faz?"<br>
                    Nada mais que acessar um link desse mesmo servidor (Esse link é montado e acessado, através das informações passadas no arquivo 'config.php', também na raiz do projeto.), de forma (GET), às 4:00h AM. Além disso, esse link é bloqueado para qualquer outro horário, apenas para esse ele é disponível.<br><br>

                    Entretanto, essa é apenas uma forma de automatizar o serviço. Já que é possível executar essa tarefa pelo painel de configurações.
                </p>
            </div>
            <div id="list-item-3" class="text-bg-danger m-3 p-3 rounded shadow">
                <h4>Executação da API</h4>
                <p>
                    Na raiz do site: <?php echo classe\routes::HOME_URL; ?>, você poderá encontrar o botão "Execução da API", esse botão é um processo automatizado do servidor.
                    Ele acessa a url desejada, essa URL é um arquivo "txt" (arquivo de texto), nele você encontrará outros arquivos descritos como compactados "Exemplo.json.zip", por exemplo, existindo inumeros arquivos. O segredo é copiar os arquivos, adicionar numa função de baixar através da url e logo após reorganiza-los e adiciona-los no modelo de produtos com as colunas que desejamos.
                    E ai sim poderá ser salvo no banco de dados dos arquivos.
                <div class="card" style="width: 100%">
                    <img src="ImagensFuncionamento\ArquivosSendoBaixados.PNG" class="card-img-top" alt="Imagem das pastas e dos arquivos salvos.">
                    <div class="card-body text-bg-dark">
                        <p class="card-text">Aqui você pode ter uma noção do funcionamento, da esquerda para a direita:<br>
                            Temos a raiz do servidor, com o diretório descrito como "arquivos", logo depois tempos dentro desse arquivo: um diretório e os arquivos compactados. Dentro do diretório fica os arquivos não compactados.
                        </p>
                    </div>
                </div>

                </p>
            </div>
            <div id="list-item-4" class="text-bg-danger m-3 p-3 rounded shadow">
                <h4>Visualizando os produtos:</h4>
                <p>
                    Para visualizar os Produtos, você pode acessar a seguinte url: <?php echo classe\routes::HOME_URL . 'produtos'; ?><br>
                    Mas para acessar um produto unico, é necessário que você acesse através da coluna 'code', dele cada um dos produtos, essa coluna pode ser vista no link acima.
                    <br><br>
                    Como funciona o link de acesso: <br><b>produtos/id/{code} <br> Não é necessário deixar entre colchetes. </b>
                    <br><br>


                    Detalhe: para acessar ambas urls, não é necessário alterar ou enviar um método diferente já descrito, você pode acessar através do navegador mesmo, de forma 'GET'.<br>
                    Diferentemente de quando você vai alterar e deletar os arquivos, que é necessário também alterar o tipo de 'Request method'.
                </p>
            </div>
            <div id="list-item-5" class="text-bg-danger m-3 p-3 rounded shadow">
                <h4>Buscando os produtos:</h4>
                <p>
                    Para visualizar os Produtos, você pode acessar a seguinte url: <?php echo classe\routes::HOME_URL . 'produtos'; ?><br>

                    Logo nessa url, terá a barra de pesquisa, nela você pode acessar para pesquisar qualquer termo em qualquer coluna do banco de dados. (Não é necessário filtrar ou adicionar mais termos.)<br>
                    Vamos ao exemplo: Você quer encontrar o produto que foi importado no ano de 2020. É só você colocar '2020' na barra de pesquisa, que se existir, encontrará todos os produtos referentes a esse ano.
                </p>
            </div>
            <div id="list-item-6" class="text-bg-danger m-3 p-3 rounded shadow">
                <h4>Editando os produtos:</h4>
                <p>
                    Para visualizar os Produtos, você pode acessar a seguinte url: <?php echo classe\routes::HOME_URL . 'produtos'; ?><br>
                    E utilizaremos a URL acima para chegar na edição dos produtos. <br>
                    Sabendo disso, é interessante notar, que os produtos podem facilmente serem editados da mesma forma que visualizados:
                    <br><br>
                    Como funciona o link de edição: <br><b>produtos/id/{code} <br> Não é necessário deixar entre colchetes. </b>
                    <br><br>
                    Com essa url em mãos, será necessário acessar através do método 'PUT', e também enviar um arquivo JSON com os valores descritos que deverão ser alterados. <br>
                    O arquivo json será considerado apenas os valores (as chaves não são necessários serem com os nome dos modelo), e valores vazios serão desconsiderados.<br>
                    Vamos ao exemplo, se você quiser alterar o 'code' do arquivo, você enviará a requisição da seguinte forma:<br><br>
                    <code class="text-light">
                        {<br>
                        1:{novo código}<br>
                        }<br><br>
                    </code>
                    Agora digamos que queira atualizar o elemento 'product_name', considerando que esse sejá o 8º elemento, será necessario enviar assim:<br><br>
                    <code class="text-light">                  
                    {<br>
                    "1": "",<br>
                    "2": "",<br>
                    "3": "",<br>
                    "4": "",<br>
                    "5": "",<br>
                    "6": "",<br>
                    "qualquerNome": "",<br>
                    "colunaDesejada": "NovoNome"<br>
                    }<br><br>
                    </code>

                    A coluna 'product_name', foi alterada para NovoNome. Assim, você poderá alterar QUALQUER produto, por QUALQUER item, entratanto, o arquivo ficará marcado como modificado (essa informação,pode ser alterado também, apenas escolhendo a coluna desejada).
                </p>
            </div>
            <div id="list-item-7" class="text-bg-danger m-3 p-3 rounded shadow">
                <h4>Deletando os produtos:</h4>
                <p>
                    Para visualizar os Produtos, você pode acessar a seguinte url: <?php echo classe\routes::HOME_URL . 'produtos'; ?><br>
                    E utilizaremos a URL acima para chegar na edição dos produtos. <br>
                    Sabendo disso, é interessante notar, que os produtos podem facilmente serem deletados da mesma forma que editados:
                    <br><br>
                    Como funciona o link de edição: <br><b>produtos/id/{code} <br> Não é necessário deixar entre colchetes. </b>
                    <br><br>
                    Com essa url em mãos, será necessário acessar através do método 'DELETE', mas o arquivo não será deletado, ele será marcado como 'TRASH'.
                </p>
            </div>
        </div>
    </div>
</div>