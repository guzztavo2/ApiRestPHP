<?php

namespace classe;

use FFI\Exception;
use model\produto;

class files
{
    const filesTxt = 'https://challenges.coode.sh/food/data/json/index.txt';
    const urlToDownloadFiles = 'https://challenges.coode.sh/food/data/json/';

    const dirDownloads = 'arquivos/';
    const dirProdutos = self::dirDownloads . 'produtos/';
    public array | string $arquivos = [];


    private array $resultFiles;

    public function __construct()
    {
        $this->setArquivosFromUrl();
    }
    private function setArquivosFromUrl()
    {

        $this->arquivos = explode("\n", @file_get_contents(self::filesTxt));

        $error = error_get_last();

        if (isset($error))
            throw new \Exception('Falha ao se conectar com o servidor "challenges.coode".');

        array_pop($this->arquivos);
    }
    public function execute()
    {

        $arquivosList = $this->arquivos;

        database::truncateTabela(produto::TABLE);
        for ($n = 0; $n < count($arquivosList); $n++) {
            $this->arquivos = $arquivosList;
            try {
                $this->verificarDiretorio();
                $this->downloadArquivos($n);
                $this->extractFileGz();
                $this->setResultadoArquivos();
                $this->getResultFiles();
            } catch (\Exception $e) {
                break;
            }
        }
        $this->limparArquivos(self::dirDownloads);
    }

    private function verificarDiretorio()
    {
        if (!file_exists(self::dirDownloads))
            mkdir(self::dirDownloads);
        if (!file_exists(self::dirProdutos))
            mkdir(self::dirProdutos);
    }
    public function limparArquivos($dirCaminho)
    {
        if (substr($dirCaminho, strlen($dirCaminho) - 1, 1) != '/') {
            $dirCaminho .= '/';
        }
        $files = glob($dirCaminho . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::limparArquivos($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirCaminho);
    }
    private function downloadArquivos(int $archive)
    {
        $this->arquivos = (string) $this->arquivos[$archive];
        //$file_name = self::dirDownloads.'/'.basename($this->arquivos);
        if (!file_exists(self::dirDownloads . $this->arquivos))
            @file_put_contents(self::dirDownloads . $this->arquivos, @file_get_contents(self::urlToDownloadFiles . $this->arquivos));

        $this->arquivos = self::dirDownloads . $this->arquivos;
    }
    private function extractFileGz()
    {
        $file_name = $this->arquivos;
        $buffer_size = 4096;
        $arquivoSaida_Nome = str_replace('.gz', '', $file_name);

        $this->arquivos = str_replace(self::dirDownloads, self::dirProdutos, $arquivoSaida_Nome);



        if (!file_exists($this->arquivos)) {
            $arquivo = gzopen($file_name, 'rb');
            $arquivoSaida = fopen($arquivoSaida_Nome, 'wb');
            while (!gzeof($arquivo))
                fwrite($arquivoSaida, gzread($arquivo, $buffer_size));

            fclose($arquivoSaida);
            gzclose($arquivo);
            rename($arquivoSaida_Nome, $this->arquivos);
        }
    }
    private function setResultadoArquivos()
    {
        $result = [];
        if ($file = fopen($this->arquivos, "r")) {
            $count = 0;
            while (!feof($file) && $count !== 100) {
                $result[] = json_decode(fgets($file));
                $count++;
            }
        }
        $this->resultFiles = $result;
    }


    public function getResultFiles()
    {

        $prod = new produto();
        $keys = array_keys((array) $prod->getListProperties());

        $listProdutos = [];

     

        foreach ($this->resultFiles as $result) {
            $produto = new Produto();
            foreach ($keys as $key) {
                if (property_exists($this->resultFiles[0], $key))
                    $produto->{$key} = $result->{$key};
            }
            $listProdutos[] = $produto;
        }
        
        foreach ($listProdutos as $produto)
            database::insertProduto($produto);


        //var_export($listProdutos[0]);
    }
}
