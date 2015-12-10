<?php

class Robo_config_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get() {
        $this->db->where("id", 1); 
        return $this->db->get("robo_config")->row_array();
    }

    function set($data) {
        $this->db->where("id", 1);
        $this->db->update("robo_config", $data);
    }

    function getServerHost(){
        $data = $this->get();
        return "http://" . $data["host"] . ":" . $data["port"];
    }
    
}
