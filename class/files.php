<?php
use model\produto;

class files
{
    const filesTxt = 'https://challenges.coode.sh/food/data/json/index.txt';
    const urlToDownloadFiles = 'https://challenges.coode.sh/food/data/json/';

    const dirDownloads = './arquivos/';
    const dirProdutos = self::dirDownloads . 'produtos/';
    private $arquivos = [];


    private array $resultFiles;

    public function __construct()
    {
        $this->setArquivosFromUrl();

    }
    public function execute(int $archive)
    {
        $this->verificarDiretorio();
        $this->downloadArquivos($archive);
        $this->extractFileGz();
        $this->setResultadoArquivos();
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
            file_put_contents(self::dirDownloads . $this->arquivos, file_get_contents(self::urlToDownloadFiles . $this->arquivos));

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
            while (!gzeof($arquivo)) {
                fwrite($arquivoSaida, gzread($arquivo, $buffer_size));
            }
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
    private function setArquivosFromUrl()
    {
        $this->arquivos = explode("\n", file_get_contents(self::filesTxt));
        array_pop($this->arquivos);
    }

    public function getResultFiles(): array
    {
        $keys = array_keys((array) $this->resultFiles[0]);
        $listProdutos = [];


        foreach ($this->resultFiles as $result) {
            $produto = new Produto();
            foreach ($keys as $key) {
                if (property_exists($produto, $key))
                    $produto->{$key} = $result->{$key};

            }
            $listProdutos[] = $produto;
        }

        database::insertProduto($listProdutos[1]);
        //var_export($listProdutos[0]);
        exit;
        return $this->resultFiles;
    }
}