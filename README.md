# API REST APP em PHP

### Ideia central do desenvolvimento:
Uma empresa de tecnologia lançou um desafio de 5 dias para o desenvolvimento de uma API Rest em PHP puro.

A aplicação funcionará da seguinte forma: 
### Foi passado dois links de dois arquivos: 
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

### Roteamento funcionará da seguinte forma:
- GET [/] - Mostra o status da API, desde a conexão com o banco, até a ultima vez que foi sincronizados com o site. 
- PUT [/Produto]{id} - Atualizar o determinado produto identificado pelo ID;
- DELETE [/Produto]{id} - Não excluirá o produto, mas mudará seu status no banco.
- GET [/Produto] - Mostrará todos os produtos instalados no banco de dados.


## O que é necessário para rodar o projeto?
- ### Editar o arquivo na raiz: 'config.php', e alterar apenas o nome do banco de dados, diretórios e etc.
Pronto, já poderá rodar o projeto 😉



## O que foi feito até agora?
- ### ✅ Modelo feita encima de um modelo JSON (de forma automática);
- ### ✅ Tabela do banco de dados foi desenvolvida encima da Model;
- ### ✅ Determinei uma classe chamada 'Files', para baixar os arquivos do link1 e do link2, e extrai-los, acoplar no Modelo determinado (com as propriedades determinadas), salva no banco de dados e já deleta todos os arquivos inutilizados. 
- ### ✅ Roteamento (GET, PUT E DELETE). 
- ### ❎ Ainda não foi desenvolvido as views para o projeto.
