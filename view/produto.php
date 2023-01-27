
<div class="text-bg-danger col-12 row p-4 mx-auto justify-content-center">

    <div class="card col-4 shadow">
        <img src="<?php echo $produto->image_url ?>" width="auto" height="40%" class="card-img-top p-2 rounded" alt="...">
        <div class="card-body">
            <h5 class="card-title text-dark">Produto: <?php echo $produto->product_name; ?></h5>

            <p class="card-text text-dark">Código: <?php echo $produto->code;  ?></p>
            <p class="card-text text-dark">Status: <?php echo $produto->status; ?></p>
            <p class="card-text text-dark">Importado: <?php
                                                        $produtoTempo = new DateTime($produto->imported_t);
                                                        echo $produtoTempo->format(classe\database::BrDateTimeFormat); ?></p>


            <p class="card-text text-dark">Criado: <?php
                                                    if ($produto->created_t !== '0000-00-00 00:00:00') {
                                                        $produtoTempo = new DateTime($produto->created_t);
                                                        echo $produtoTempo->format(classe\database::BrDateTimeFormat);
                                                    } else
                                                        echo $produto->created_t;  ?></p>



            <p class="card-text text-dark">Ultima modificação: <?php
                                                                if ($produto->last_modified_t !== '0000-00-00 00:00:00') {
                                                                    $produtoTempo = new DateTime($produto->last_modified_t);
                                                                    echo $produtoTempo->format(classe\database::BrDateTimeFormat);
                                                                } else
                                                                    echo $produto->last_modified_t;

                                                                ?></p>


            <p class="card-text text-dark"><a href="<?Php echo $produto->url; ?>" target="_blank" style="text-decoration:none;" rel="noopener noreferrer"><b>Origem do produto</b></a></p>

            <?php
            foreach ($produto->getListProperties() as $key => $item) {
                switch ($key) {
                    case 'image_url':
                        break;
                    case 'product_name':
                        break;
                    case 'code':
                        break;
                    case 'status':
                        break;
                    case 'imported_t':
                        break;
                    case 'created_t':
                        break;
                    case 'last_modified_t':
                        break;
                    case 'url':
                        break;
                    default:
                    if($item !== null && strlen($item) > 0 && $item !== 0 && $item !== 0.0)
                    echo '<p class="card-text text-dark">'.$key.': '.$item.'</p>';
                    break;
                }
            }

            ?>


            <p class="card-text"><small class="text-muted">Ultima atualização: <?php 
             $datetime = new DateTime('now');
             $interval = date_diff($ultimaVezAtualizado, $datetime);
             echo $interval->format('%h horas e %i minutos ');
            ?></small></p>
        </div>
    </div>
</div>
<?php

?>