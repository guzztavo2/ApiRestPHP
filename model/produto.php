<?php

namespace model;
abstract class status {
    const DRAFT = 'draft'; const TRASH = 'trash'; const PUBLISHED = 'published';
 

 
}
class produto extends status {
  
    public const TABLE = 'tb_produtos';
    public function __construct(){

        $this->gerarModeloJSON();
      
    }

    public function setStatus(string $CONST_STATUS){
        $this->status = $CONST_STATUS;
      
    }

    
    private function gerarModeloJSON(){
        $file = \file_get_contents('modelo.json', true);
        $file = array_keys((array)\json_decode($file)[0]);
        foreach($file as $property)
            $this->{$property} = null;
    }

}

 