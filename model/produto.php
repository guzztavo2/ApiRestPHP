<?php

namespace model;
use classe\database;

abstract class status {
    const DRAFT = 'draft'; const TRASH = 'trash'; const PUBLISHED = 'published';
 

 
}
class produto extends status {
    private $listProperties = array();

    public const TABLE = 'tb_produtos';
    public function __construct(){

        $this->gerarModeloJSON();
      
    }
    public function getListProperties():array{
        return $this->listProperties;
    }
    public static function selecioneTodos():array{
        $listProdutos = database::selectAll(self::TABLE);
       
        $listProdutos = self::arrayToProdutoClass($listProdutos);
      
        return $listProdutos;
    }
    public static function find(array $parametros){

        return self::arrayToProdutoClass(database::find(self::TABLE, $parametros));
    }
    public static function buscarPorCodigo(string $codigo):produto{        
        $item = database::find(self::TABLE, ['WHERE `code` = ?', [$codigo]]);
        $item = self::arrayToProdutoClass($item);
        return $item[0];
    }
    public static function arrayToProdutoClass(array $listItems){
        $produtoKeys = new produto();
        $produtoKeys = array_keys($produtoKeys->getListProperties());
        $resultado = [];
        foreach($listItems as $item){
            $produto = new Produto();
           
            foreach($produtoKeys as $key){
                $produto->{$key} = $item[$key];
            }
            $resultado[] = $produto;
        }
        return $resultado;
    }
    public function setStatus(string $CONST_STATUS){
        $this->{'status'} = $CONST_STATUS;
    }
    public function atualizar(produto $novoProduto){
      
        $codigoAntigo = $this->code;
        foreach($this as $key => $value){
            if($novoProduto->$key !== null)
                $this->$key = $novoProduto->{$key};
        }
        $this->last_modified_t = (string)date('Y-m-d H:i:s');
    
        $this->salvar($codigoAntigo);
    }
    private function salvar(string $codeAntigoUpdate = null){

        $keys = array_keys((array) $this);

        $keys = array_map(function ($val) {
            return '`'.$val.'` = ?,';
        },$keys);
       
        $keys = implode(' ', $keys);
 
        $keys = substr($keys, 0, -1);
 
        $values = array_values((array) $this);

        $keyValues = array_merge([$keys], [$values]);
        
        if($codeAntigoUpdate !== null)
            database::salvar(self::TABLE,$keyValues, ['`code` = ?', $codeAntigoUpdate]);
       
     

    }
    public function __set(string $name, mixed $value): void {
        $this->listProperties[$name] = $value;
    
    }
    public function __get($name){
        return $this->listProperties[$name];
    }
    private function gerarModeloJSON(){
        $file = \file_get_contents('modelo.json', true);
        $file = array_keys((array)\json_decode($file)[0]);
   
        foreach($file as $property)
            $this->$property = null;
    }
    
}

 