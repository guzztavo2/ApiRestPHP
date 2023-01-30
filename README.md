
# API REST APP em PHP


### Ideia central do desenvolvimento:
<p align="center">
Uma empresa de tecnologia lançou um desafio de 5 dias para o desenvolvimento de uma API Rest em PHP puro.
</p>
A aplicação funcionará da seguinte forma: 
### Foi passado dois links de dois arquivos:
<p align="center">

- Um deles é um arquivo txt com o nome dos arquivos que serão baixados pelo servidor;
- E o outro é o link onde você irá concatenar esses arquivos ao link, por exemplo:
link_1.com/arquivo.txt:
- arquivo1.json.zip
- arquivo2.json.zip

Com o primeiro link, poderá pegar esses arquivos, e juntar com o link2.
link_2.com/json/ + arquivo1.json.zip.

Depois de baixado o arquivo, é necessário extrair o arquivo JSON. 
São arquivos gigantes, mas foi deixado claro no desafio que será necessário apenas 100 itens de cada arquivo JSON.

Depois disso, foi proporcionado um JSON para ser utilizado como MODELO desses arquivos. Exemplo: os arquivos originalmente baixados do site, possuem 200 propriedades de modelo, mas foi dito que precisaríamos de apenas 10 e que acrescentaria mais 2 propriedades novas. (E que já foi separado nesse modelo JSON).
</p>
### Roteamento funcionará da seguinte forma:
<p align="center">
- GET [/] - Mostra o status da API, desde a conexão com o banco, até a ultima vez que foi sincronizados com o site;
- PUT [/Produtos]/{id} - Atualizar o determinado produto identificado pelo ID;
- DELETE [/Produtos]/{id} - Não excluirá o produto, mas mudará seu status no banco;
- GET [/Produtos]/{id} - Visualizar um unico arquivo através da coluna 'code';
- GET [/Produtos] - Mostrará todos os produtos instalados no banco de dados.
</p>
## O que é necessário para rodar o projeto?
<p align="center">
- ### Editar o arquivo na raiz: 'config.php', e alterar apenas o nome do banco de dados, diretórios e etc.
Pronto, já poderá rodar o projeto 😉
Também é necessário ter instalado um servidor local com PHP e o banco de dados MySQL. (Xampp por exemplo);
</p>
## Sistema CRON
<p align="center">
Para melhor funcionamento e sincronia do servidor, elaborei uma função que recria um XML, na pasta raiz chamada 'sistemaCRON-Windows' (Apenas Windows, por isso o nome).
Para melhor funcionamento tente assim:
- Acesse o Prompt de Comando do Windows
- Digite esse código: taskschd.msc
- Abrirá o agendador de tarefas do Windows, lá você importará esse arquivo XML da pasta 'sistemaCRON-Windows'.
</p>
### O que esse arquivo XML faz?
<p align="center">
Sempre que for 4:00 AM, ele acessará automaticamente uma URL disponível APENAS nesse horário (Não é possivel acessar em outro horário), onde ele apenas de ter acessado, começará a sincronia do servidor.
</p>
# NÃO é necessário fazer TODO esse PROCESSO.
<p align="center">
Como eu fiz esse projeto para estudos, não é necessário fazer todo essa ideia de sincronia, basta clicar em 'Executar agora' na Home Page, e nisso já bastará. 
(Cuidado, quando esse processo ta em execução, o site fica completamente limitado, teste por si mesmo).
</p>
## O que esse projeto possui?
<p align="center">
- ✅ Modelo feita encima de um modelo JSON (de forma automática);
- ✅ Tabela do banco de dados foi desenvolvida encima da Model;
- ✅ Determinei uma classe chamada 'Files', para baixar os arquivos do link1 e do link2, e extrai-los, acoplar no Modelo determinado (com as propriedades determinadas), salva no banco de dados e já deleta todos os arquivos inutilizados. 
- ✅ Roteamento (GET, PUT E DELETE). 
- ✅ Views (Home, Sobre, Produtos).
</p>
### Imagens do projeto em funcionamento:

<p align="center">
![](https://github.com/guzztavo2/ApiRestPHP/blob/master/ImagensFuncionamento/home.PNG)
![](https://github.com/guzztavo2/ApiRestPHP/blob/master/ImagensFuncionamento/produtos.PNG)
![](https://github.com/guzztavo2/ApiRestPHP/blob/master/ImagensFuncionamento/sobre.PNG)

</p>

