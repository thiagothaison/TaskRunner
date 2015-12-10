<?php

class Robo_server_exec_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get() {
        return $this->db->get("robo_server_exec")->result_array();
    }

    function getByHash($hash) {
        return $this->db->where("md5(id)", $hash)->get("robo_server_exec")->row_array();
    }
    
    function save($data){
        if (array_key_exists("id", $data)){
            $this->db->where("id", $data["id"]);
            $this->db->update("robo_server_exec", $data);            
        }else{
            $this->db->insert("robo_server_exec", $data);
        }
    }
    
    function excluir($hash){
        
        $this->load->model("robo_agenda_model", "agenda");
        
        $data = $this->getByHash($hash);
        
        $this->agenda->inativarAgendamentosServidor($data["id"]);
        
        $this->db->where("md5(id)", $hash);
        $this->db->delete("robo_server_exec");
        
    }
    
}
