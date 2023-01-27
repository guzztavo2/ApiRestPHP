<?php
?>
<?php if (model\CRON::getEmExecucaoFromDatabase() === true) : ?>
    <div class="alert alert-danger alert-dismissible fade show container text-center position-absolute top-50 start-50 translate-middle p-4" role="alert">
        <strong>No momento, não será possível visualizar os produtos registrados, pois o servidor está em execução. Volte aqui depois de alguns minutos, e poderá visualiza-los novamente.</strong><br>
        A execução estará finalizada, quando essa mensagem estiver desaparecido (quando recarregar a página).
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php else : ?>

    <div class="row mx-auto">
        <div class="buscar row col-6 mx-auto">
            <form method="get">
                <input type="text" class="form-control col-12 p-3 mt-2 shadow" name="buscar" placeholder="buscar por nome" id="">
            </form>

        </div>

        <div class="table-responsive col-12 shadow mt-4">
            <table class="table table-striped table-dark ">
                <thead class="thead-dark rounded">

                    <tr>
                        <?php // var_export($Produtos->todosProdutos); // var_export($Produtos->totalPaginas);


                        $produtos = new model\produto();
                        foreach ($produtos->getListProperties() as $key => $value) : ?>
                            <th scope="col">
                                <?php echo $key ?>
                            </th>
                        <?php endforeach; ?>

                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($Produtos->todosProdutos as $produto) : ?>
                        <tr>
                            <?php foreach ($Produtos->todosProdutos[0]->getListProperties() as $key => $value) : ?>

                                <td>
                                    <?php
                                    if ($key === 'imported_t' || $key === 'created_t' || $key === 'last_modified_t') {
                                        if ($produto->$key !== '0000-00-00 00:00:00') {
                                            $dataTime = new DateTime($produto->$key);
                                            echo $dataTime->format(classe\database::BrDateTimeFormat);
                                        } else
                                            echo '<b class="text-bg-light d-block text-center p-2">' . ucfirst($key) . ' não existe.</b>';
                                    } else {
                                        if ($produto->$key === null || $produto->$key === '')
                                            echo '<b class="text-bg-light d-block text-center p-2">' . ucfirst($key) . ' não existe.</b>';
                                        else {
                                            if ($key === 'image_url') {
                                                echo '<img src="' . $produto->$key . '" width="100%" height="auto"> </img>';
                                            } else {
                                                if ($key === 'url') {
                                                    echo '<a class="text-bg-light d-block text-center p-2" style="text-decoration:none" href="' . $produto->$key . '"">Link de referência do produto</a>';
                                                } else {
                                                    if ($produto->$key == 0) {
                                                        echo '<b class="text-bg-light d-block text-center p-2">' . ucfirst($key) . ' não existe.</b>';
                                                    } else {
                                                        if ($key === 'code') {
                                                            echo '<a class="text-bg-light d-block text-center p-2" style="text-decoration:none" href="' . classe\routes::HOME_URL . 'produtos/id/' . $produto->$key . '"">' . $produto->$key . '</a>';
                                                        } else
                                                            echo $produto->$key;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>


                                </td>

                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>



                </tbody>

            </table>
        </div>
        <div class="paginacao">

            <nav aria-label="Page navigation">
                <ul class="pagination pagination-lg justify-content-center w-100" style="overflow: auto;">

                    <?php
              
                    if($Produtos->totalPaginas !== 0):
                    $paginaAtual = controller\ProdutoController::getPaginaAtual();

                    if ($paginaAtual === 1) :

                    ?>
                        <li class="page-item">
                            <a class="page-link text-bg-secondary" disabled aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="page-item">

                            <a class="page-link text-bg-dark" href="<?php echo controller\ProdutoController::gerarPaginaURL($paginaAtual - 1) ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php
                    endif;
                    //$paginaAtual = ProdutoController::getPaginaAtual();
                    if($Produtos->totalPaginas > 10){
                    if ($paginaAtual === 1) {
                        $paginaInicio =  $paginaAtual;
                        $paginaFinal =  $paginaAtual + 9;
                    } else if($paginaAtual > 1 && $paginaAtual < 4){
                        $paginaInicio =  $paginaAtual - 1;
                        $paginaFinal =  $paginaAtual + 4;
                    }                    
                    else if ($paginaAtual >= 4 && $paginaAtual + 5 < $Produtos->totalPaginas) {
                        $paginaInicio =  $paginaAtual - 3;
                        $paginaFinal =  $paginaAtual + 5;
                    } else {
                        $paginaInicio =  $paginaAtual - 9;
                        $paginaFinal =  $Produtos->totalPaginas;
                    }
                }else if($Produtos->totalPaginas <= 10){
                    $paginaInicio =  1;
                    $paginaFinal =  $Produtos->totalPaginas;
                }
                    for ($pagina = $paginaInicio; $pagina <= $paginaFinal; $pagina++) :

                    ?>
                        <?php if ($pagina == $paginaAtual) : ?>
                            <li class="page-item"><a class="page-link text-bg-primary" disabled href="<?php echo controller\ProdutoController::gerarPaginaURL($pagina) ?>"><?php echo $pagina ?></a></li>
                        <?php else : ?>
                            <li class="page-item"><a class="page-link text-bg-dark" href="<?php echo controller\ProdutoController::gerarPaginaURL($pagina) ?>"><?php echo $pagina ?></a></li>
                    <?php endif;
                    endfor; ?>

                    <?php
                    if ($paginaAtual === $Produtos->totalPaginas) :

                    ?>
                        <li class="page-item">
                            <a class="page-link text-bg-secondary" disabled aria-label="Previous">
                            <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="page-item">

                            <a class="page-link text-bg-dark" href="<?php echo controller\ProdutoController::gerarPaginaURL($paginaAtual + 1) ?>" aria-label="Previous">
                            <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php
                    endif; ?>

                </ul>
            </nav>

        </div>
    </div>

<?php endif; endif; ?>