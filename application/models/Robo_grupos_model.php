<?php

class Robo_grupos_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAll() {
        return $this->db->get("robo_grupos")->result_array();
    }
    
    function getByHash($hash){
        $this->db->where("md5(id)", $hash); 
        return $this->db->get("robo_grupos")->row_array();        
    }
    
    function save($data){
        if (array_key_exists("id", $data)){
            $this->db->where("id", $data["id"]);
            $this->db->update("robo_grupos", $data);            
        }else{
            $this->db->insert("robo_grupos", $data);
        }
    }
    
    function ativar($hash){
        
        $data = $this->getByHash($hash);
        
        $this->db->where("MD5(id)", $hash);
        $this->db->update(
            "robo_grupos", array(
                "ativo" => 1
            )
        );
        
    }
    
    function inativar($hash){
        
        $data = $this->getByHash($hash);
        
        $this->db->where("MD5(id)", $hash);
        $this->db->update(
            "robo_grupos", array(
                "ativo" => 0
            )
        );
        
    }
    
    function excluir($hash){
        
        $data = $this->getByHash($hash);
        
        $this->db->where("md5(id)", $hash);
        $this->db->delete("robo_grupos");
        
    }
    
}
