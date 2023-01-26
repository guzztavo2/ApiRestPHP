<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="API REST gratuita e atualizada para conseguir uma grande variedade de: quantidade, receitas. Das mais variadas comidas.">
  <title>API REST DE TIPOS DE COMIDA E SUAS RECEITAS E IMAGENS</title>
  <link rel="stylesheet" href="<?php echo classe\routes::HOME_URL; ?>css/style">
  <link rel="stylesheet" href="<?php echo classe\routes::HOME_URL; ?>css/bootstrap">
  <script src="<?php echo classe\routes::HOME_URL; ?>js/bootstrap"></script>
  <script src="<?php echo classe\routes::HOME_URL; ?>js/code"></script>
</head>

<body>
  <script>
    const HOME_PATH = "<?php echo classe\routes::HOME_URL; ?>"
  </script>



  <header class="row p-3 mx-auto justify-content-center text-bg-dark ">

    <div class="col-4 text-bg-primary p-2">
      <h1 class="display-6 fs-4 text-center" style="text-transform:lowercase">Bem vindo ao painel de configurações da API Rest</h1>
    </div>
    <div class="col-6"></div>
    <ul class="nav nav-pills col-2">
      <?php if (classe\routes::getLocation() !== 'produtos') : ?>
        <li class="nav-item col-4 text-center"><a href="<?php echo classe\routes::HOME_URL ?>" class="nav-link active" aria-current="page">Home</a></li>
      <?php else : ?>
        <li class="nav-item col-4 text-center"><a href="<?php echo classe\routes::HOME_URL ?>" class="nav-link" aria-current="page">Home</a></li>
      <?php endif; ?>
      <?php if (classe\routes::getLocation() === 'produtos') : ?>
        <li class="nav-item col-4 text-center"><a href="<?php echo classe\routes::HOME_URL ?>produtos" class="nav-link active">Produtos</a></li>
      <?php else : ?>
        <li class="nav-item col-4 text-center"><a href="<?php echo classe\routes::HOME_URL ?>produtos" class="nav-link">Produtos</a></li>
      <?php endif; ?>
    </ul>
  </header>