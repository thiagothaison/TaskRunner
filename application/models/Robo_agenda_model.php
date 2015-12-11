<?php

class Robo_agenda_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAll() {
        
        $this->load->model("robo_grupos_model", "grupos");
        $this->load->helper("html_utils_helper");
        
        $agendamentos = $this->db->get("robo_agenda")->result_array();
        
        foreach($agendamentos as &$agenda){
            $agenda["grupo"]   = $this->grupos->getByHash( md5( $agenda["id_grupo"] ) );
        }
        
        return $agendamentos;
    }
    
    function getAllActive(){
                
        $this->db->select('robo_agenda.*');
        $this->db->from('robo_agenda');
        $this->db->join('robo_grupos', 'robo_grupos.id = robo_agenda.id_grupo', 'left');
        $this->db->where('robo_agenda.ativo', 1);
        $this->db->where('( robo_grupos.ativo = 1 OR robo_grupos.ativo is null )');
        
        return $this->db->get()->result_array();       
        
    }
    
    function save($data){
        if (array_key_exists("id", $data)){
            $this->db->where("id", $data["id"]);
            $this->db->update("robo_agenda", $data);
        }else{
            $this->db->insert("robo_agenda", $data);
        }
    }
    
    function getByHash($hash){
        $this->db->where("md5(id)", $hash); 
        return $this->db->get("robo_agenda")->row_array();        
    }

    function inativarAgendamentosServidor($id_servidor){
        $this->db->where("id_servidor_execucao", $id_servidor)
                 ->update("robo_agenda", array(
                         "ativo" => 0
                     )
                 );
    }
    
    function ativar($hash){
        
        $data = $this->getByHash($hash);
        
        $this->db->where("MD5(id)", $hash);
        $this->db->update(
            "robo_agenda", array(
                "ativo" => 1
            )
        );
        
    }
    
    function inativar($hash){
        
        $data = $this->getByHash($hash);
        
        $this->db->where("MD5(id)", $hash);
        $this->db->update(
            "robo_agenda", array(
                "ativo" => 0
            )
        );
        
    }
    
    function excluir($hash){
        
        $data = $this->getByHash($hash);
        
        $this->db->where("md5(id)", $hash);
        $this->db->delete("robo_agenda");
        
    }
    
    function setUltimaExecucao($hash){
        
        $agora = date("Y-m-d H:i:s");
        
        $this->db->where("md5(id)", $hash)->update(
            "robo_agenda", array(
                "ultima_execucao" => $agora
            )
        );
        
        return $agora;
        
    }
    
}
