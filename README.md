
# API REST APP em PHP

<p>Este repositório contém o código-fonte de uma API REST simples criada usando PHP. A API permite realizar operações básicas de CRUD (Create, Read, Update, Delete) em um banco de dados MySQL.</p>

<h2>Dependências</h2>
<ul><li>PHP 7.x ou superior</li><li>MySQL 5.x ou superior</li><li>Servidor web (como Apache ou Nginx)</li></ul>

<h2>Instalação</h2>
<ol><li>Clone o repositório:</li></ol>
   <pre><div class="p-4 overflow-y-auto"><code class="!whitespace-pre hljs language-bash">git <span class="hljs-built_in">clone</span> https://github.com/guzztavo2/ApiRestPHP.git
</code></div></div></pre>
<ol start="2"><li><p>Crie um banco de dados MySQL.</p></li><li><p>Renomeie o arquivo <code>config.php.example</code> para <code>config.php</code> e atualize as informações de conexão do banco de dados.</p></li><li><p>Inicie o servidor web.</p></li><li><p>Acesse a API REST através do seu navegador ou ferramenta de teste de API.</p></li></ol>

<h2>Funcionamento das requisições</h2>
<table>
  <thead>
    <tr>
      <th>Rota</th>
      <th>Método HTTP</th>
      <th>Endpoint</th>
      <th>Resumo</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>/home</td>
      <td>GET</td>
      <td>home()</td>
      <td>Página inicial da aplicação.</td>
    </tr>
    <tr>
      <td>/sobre</td>
      <td>GET</td>
      <td>sobre()</td>
      <td>Página "Sobre nós" da aplicação.</td>
    </tr>
    <tr>
      <td>/CronUpdateWindowsTask</td>
      <td>GET</td>
      <td>CronUpdateWindowsTask()</td>
      <td>Endpoint para agendar a execução de uma tarefa no Windows.</td>
    </tr>
    <tr>
      <td>/CronUpdateWindowsTask</td>
      <td>PUT</td>
      <td>CronUpdateWindowsTask()</td>
      <td>Endpoint para atualizar uma tarefa agendada no Windows.</td>
    </tr>
    <tr>
      <td>/produtos</td>
      <td>GET</td>
      <td>produtos()</td>
      <td>Listar todos os produtos disponíveis na loja.</td>
    </tr>
    <tr>
      <td>/produtos/id/{id}</td>
      <td>GET</td>
      <td>produtos()</td>
      <td>Buscar um produto específico pelo seu código.</td>
    </tr>
    <tr>
      <td>/produtos/id/{id}</td>
      <td>PUT</td>
      <td>editarProduto($codigoProduto)</td>
      <td>Editar as informações de um produto específico.</td>
    </tr>
    <tr>
      <td>/produtos/id/{id}</td>
      <td>DELETE</td>
      <td>deletarProduto($codigoProduto)</td>
      <td>Deletar um produto específico da loja.</td>
    </tr>
  </tbody>
</table>
<p>Além desses endpoints, o código também lida com as rotas de arquivos estáticos na pasta <code>js</code> e <code>css</code>.</p>



## A aplicação funcionará da seguinte forma

<p> Para realizar o desafio, foi fornecido dois links: um com o nome dos arquivos a serem baixados e outro para concatenar com esses arquivos. Após baixar e extrair o arquivo JSON, que contém uma grande quantidade de itens, apenas 100 itens (de cada arquivo) são necessários. Para isso, foi fornecido um modelo JSON contendo apenas as 10 propriedades necessárias e acrescentando duas novas propriedades.</p>

### Exemplo da Model, com as duas propriedades já acrescentadas, que são: 'Imported_t' que é o horário que foi importado para o banco, e o 'status' que é um Enum com 3 valores. 
<table><thead><tr><th>Propriedade</th><th>Valor</th></tr></thead><tbody><tr><td>code</td><td>20221126</td></tr><tr><td>status</td><td>published</td></tr><tr><td>imported_t</td><td>2020-02-07T16:00:00Z</td></tr><tr><td>url</td><td><a href="https://world.openfoodfacts.org/product/20221126" target="_new">https://world.openfoodfacts.org/product/20221126</a></td></tr><tr><td>creator</td><td>securita</td></tr><tr><td>created_t</td><td>1415302075</td></tr><tr><td>last_modified_t</td><td>1572265837</td></tr><tr><td>product_name</td><td>Madalenas quadradas</td></tr><tr><td>quantity</td><td>380 g (6 x 2 u.)</td></tr><tr><td>brands</td><td>La Cestera</td></tr><tr><td>categories</td><td>Lanches comida, Lanches doces, Biscoitos e Bolos, Bolos, Madalenas</td></tr><tr><td>labels</td><td>Contem gluten, Contém derivados de ovos, Contém ovos</td></tr><tr><td>cities</td><td></td></tr><tr><td>purchase_places</td><td>Braga,Portugal</td></tr><tr><td>stores</td><td>Lidl</td></tr><tr><td>ingredients_text</td><td>farinha de trigo, açúcar, óleo vegetal de girassol, clara de ovo, ovo, humidificante, levedantes químicos, xarope de glucose-frutose, sal, aroma</td></tr><tr><td>traces</td><td>Frutos de casca rija,Leite,Soja,Sementes de sésamo,Produtos à base de sementes de sésamo</td></tr><tr><td>serving_size</td><td>madalena 31.7 g</td></tr><tr><td>serving_quantity</td><td>31.7</td></tr><tr><td>nutriscore_score</td><td>17</td></tr><tr><td>nutriscore_grade</td><td>d</td></tr><tr><td>main_category</td><td>en:madeleines</td></tr><tr><td>image_url</td><td><a href="https://static.openfoodfacts.org/images/products/20221126/front_pt.5.400.jpg" target="_new">https://static.openfoodfacts.org/images/products/20221126/front_pt.5.400.jpg</a></td></tr></tbody></table>

<h2></h2>

<h2>Roteamento funcionará da seguinte forma:</h2>
<table><thead><tr><th>Rota</th><th>Método HTTP</th><th>Endpoint</th><th>Resumo</th></tr></thead><tbody><tr><td>/</td><td>GET</td><td>-</td><td>Mostra o status da API e informações sobre a sincronização com o site</td></tr><tr><td>/Produtos/{id}</td><td>GET</td><td>{id}</td><td>Visualizar um único produto identificado pelo ID</td></tr><tr><td>/Produtos</td><td>GET</td><td>-</td><td>Mostra todos os produtos instalados no banco de dados</td></tr><tr><td>/Produtos/{id}</td><td>PUT</td><td>{id}</td><td>Atualiza o determinado produto identificado pelo ID</td></tr><tr><td>/Produtos/{id}</td><td>DELETE</td><td>{id}</td><td>Muda o status do produto identificado pelo ID (não excluirá o produto do banco de dados)</td></tr></tbody></table>

<h2>Sistema CRON</h2>

<p>Com o objetivo de otimizar o funcionamento e a sincronia do servidor, foi desenvolvido o Sistema CRON. Essa funcionalidade recria um arquivo XML na pasta raiz, denominada 'sistemaCRON-Windows', exclusivamente para sistemas operacionais Windows.</p>

<p>Para utilizar o Sistema CRON, acesse o Prompt de Comando do Windows e digite o código 'taskschd.msc'. Isso abrirá o agendador de tarefas do Windows, onde o arquivo XML poderá ser importado a partir da pasta 'sistemaCRON-Windows'.</p>

<p>O arquivo XML configurado pelo Sistema CRON é programado para acessar uma URL específica, disponível SOMENTE às 4:00 AM, e, após o acesso, iniciar automaticamente a sincronização do servidor.</p>

<small>Vale ressaltar que a url e todas as outras configurações, são resultados do arquivo 'config.php'.</small>


<p>Porém, é importante ressaltar que a sincronização não é obrigatória. Este projeto foi desenvolvido para fins de estudo, portanto, basta clicar em 'Executar agora' na Home Page para sincronizar o servidor. No entanto, é importante ter em mente que, durante o processo de sincronização, o site ficará completamente limitado. Recomenda-se testar a funcionalidade por conta própria.</p>

### Imagens do projeto em funcionamento:

<p align="center">
  
![](https://github.com/guzztavo2/ApiRestPHP/blob/master/ImagensFuncionamento/home.PNG)
![](https://github.com/guzztavo2/ApiRestPHP/blob/master/ImagensFuncionamento/produtos.PNG)
![](https://github.com/guzztavo2/ApiRestPHP/blob/master/ImagensFuncionamento/sobre.PNG)
  
</p>

