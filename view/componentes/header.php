<!DOCTYPE html>
<html lang="br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="API REST gratuita e atualizada para conseguir uma grande variedade de: quantidade, receitas. Das mais variadas comidas.">
  <title>API REST DE TIPOS DE COMIDA E SUAS RECEITAS E IMAGENS</title>
  <link rel="stylesheet" href="<?php

use classe\routes;

 echo classe\routes::HOME_URL; ?>css/style">
  <link rel="stylesheet" href="<?php echo classe\routes::HOME_URL; ?>css/bootstrap">
  <script src="<?php echo classe\routes::HOME_URL; ?>js/bootstrap"></script>
  <script src="<?php echo classe\routes::HOME_URL; ?>js/code"></script>
</head>

<body class="">
  <script>
    const HOME_PATH = "<?php echo classe\routes::HOME_URL; ?>"
  </script>



  <header class="row p-3 col-12 mx-auto justify-content-center text-bg-dark ">

    <div class="col-4 text-bg-primary">
      <h1 class="display-6 fs-4 text-center d-flex align-items-center justify-content-center p-3" style="text-transform:lowercase">Bem vindo ao painel de configurações da API Rest</h1>
    </div>
    <div class="col-5"></div>
    <ul class="nav nav-pills col-3 row">
      <?php if(classe\routes::getLocation()[0] === 'home'): ?>
        <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>" class="nav-link active" aria-current="page">Home</a></li>
        <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>produtos" class="nav-link">Produtos</a></li>
        <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>sobre" class="nav-link">Sobre</a></li>

        <?php elseif(classe\routes::getLocation()[0] === 'produtos'): ?>
          <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>" class="nav-link " aria-current="page">Home</a></li>
        <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>produtos" class="nav-link active">Produtos</a></li>
        <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>sobre" class="nav-link">Sobre</a></li>

          <?php elseif(classe\routes::getLocation()[0] === 'sobre'): ?>
            <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>" class="nav-link " aria-current="page">Home</a></li>
        <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>produtos" class="nav-link ">Produtos</a></li>
        <li class="nav-item p-2 col-lg-4 col-md-7 col-sm-12 text-center"><a href="<?php echo classe\routes::HOME_URL ?>sobre" class="nav-link active">Sobre</a></li>

          <?php endif; ?>
    </ul>
  </header>