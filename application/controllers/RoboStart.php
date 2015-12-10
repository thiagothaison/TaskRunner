<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class RoboStart extends CI_Controller{
    
    public static $psExecPath = '"C:\\\\Program Files (x86)\\\\PSTools\\\\psexec.exe"';

    public function __construct() {
        parent::__construct();
        $this->load->model("robo_config_model", "robo");
        $this->load->model("robo_grupos_model", "grupos");
        $this->load->model("robo_agenda_model", "agenda");
        $this->load->model("robo_server_exec_model", "execucao");

        $this->load->library('form_validation');
        $this->load->helper("html_utils_helper");
        
        $this->data['title'] = 'Task Runner';
        
    }
    
    public function index(){
        $this->data['subTitle'] = 'Início';
        $this->load->view("robo/index", $this->data);
    }
    
    /********************************************/
    
    public function servidor(){
        
        $this->data['subTitle'] = 'Task Runner :: Configuração';
        $this->data['robo']     = $this->robo->get();
        
        $this->load->view("robo/servidor", $this->data);
        
    }
    
    public function salvarServidor(){
        
        header('Content-Type: application/json');

        $data = $this->input->post();
        
        $this->form_validation->set_rules('host', 'Host', 'trim|required');
        $this->form_validation->set_rules('port', 'Porta', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('path', 'Instalação do servidor Node.js', 'trim|required');
        $this->form_validation->set_rules('file', 'Arquivo .js', 'trim|required');
        
        if ($this->form_validation->run() == false) {
            echo json_encode(array("error" => $this->form_validation->error_array()), JSON_UNESCAPED_UNICODE);
        } else {
            
            $statusServidor = $this->getStatusServidor();
            
            $this->db->trans_start();
            $this->robo->set($data);
            $this->db->trans_complete();
            
            if ($this->db->trans_status()) {
                echo json_encode(array("success" => "Operação realizada com sucesso", "data" => $data));
                
                $this->createServer($data);
                
                if ( $statusServidor ){
                    $this->pararServidor();
                    $this->iniciarServidor();
                }
                
                
            } else {
                echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
            }
        }
        
    }
    
    public function statusServidor(){
        echo json_encode( $this->getStatusServidor() );
    }

    public function iniciarServidor(){
        
        $robo = $this->robo->get();
        
        $this->createServer($robo);
        
        $content = "node " . $robo["path"] . DIRECTORY_SEPARATOR . $robo["file"];
        
        pclose(popen('start cmd /c ' . addslashes($content), 'r'));
        
    }
    
    public function pararServidor(){
        
        $robo = $this->robo->get();
        
        //$this->createServer($robo);
        
        //pclose(popen('start cmd /c taskkill /F /IM node.exe', 'r'));
        
        @file_get_contents("http://".$robo["host"].":".$robo["port"]."/shutdown");
        
        //pclose(popen('start cmd /c taskkill /F /IM PsExec.exe', 'r'));
        
    }
    
    public function reiniciarServidor(){
        $this->pararServidor();
        $this->iniciarServidor();
    }
    
    /********************************************/
    
    public function serverExec(){
        
        
        
        $this->data['subTitle']   = 'Task Runner :: Servidores de Execução';
        $this->data['servidores'] = $this->execucao->get();
        
        $this->load->view("robo/server_exec", $this->data);
        
    }
    
    public function formServerExec($hash=null){
        
        if ( $hash == null ){
            $this->data['subTitle'] = 'Task Runner :: Adicionar Servidor de Execução';
        }else{
            $this->data['subTitle'] = 'Task Runner :: Editar Servidor de Execução';
            $this->data["servidor"] = $this->execucao->getByHash($hash);
        }
        
        $this->load->view('robo/server_exec_form', $this->data);
        
    }
    
    public function salvarServerExec(){
        
        
        
        header('Content-Type: application/json');

        $data = $this->input->post();
        
        if ( (int) $data["id"] == 0 ){
            unset( $data["id"] );
        }
        
        $this->setRegrasServerExec();
        
        if ($this->form_validation->run() == false) {
            echo json_encode(array("error" => $this->form_validation->error_array()), JSON_UNESCAPED_UNICODE);
        } else {
            
            $this->db->trans_start();
            $this->execucao->save($data);
            $this->db->trans_complete();
            
            if ($this->db->trans_status()) {
                echo json_encode(array("success" => "Operação realizada com sucesso", "data" => $data));
            } else {
                echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
            }
        }
        
    }
    
    public function excluirServerExec(){

        
        
        header('Content-Type: application/json');
        
        $this->db->trans_start();
        $this->execucao->excluir( $this->input->post('hash') );
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            echo json_encode(array("success" => "Operação realizada com sucesso"));
        } else {
            echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
        }
        
    }
    
    private function setRegrasServerExec(){
        $this->form_validation->set_rules('nome', 'nome', 'trim|required');
        $this->form_validation->set_rules('host', 'Host', 'trim|required');
        $this->form_validation->set_rules('usuario', 'Usuário de rede', 'trim|required');
        $this->form_validation->set_rules('senha', 'Senha de rede', 'trim|required');
    }
    
    /********************************************/
    
    public function grupos(){
        
        
        
        $this->data['subTitle'] = 'Task Runner :: Grupos';
        $this->data['grupos']   = $this->grupos->getAll();
        
        $this->load->view("robo/grupos", $this->data);
    }
    
    public function formGrupos($hash=null){
        if ( $hash == null ){
            $this->data['subTitle'] = 'Task Runner :: Adicionar Grupo';
        }else{
            $this->data['subTitle'] = 'Task Runner :: Editar Grupo';
            $this->data["grupo"]    = $this->grupos->getByHash($hash);
        }
        
        $this->load->view('robo/grupos_form', $this->data);
    }
    
    public function salvarGrupo(){
        
        
        
        header('Content-Type: application/json');

        $data = $this->input->post();
        
        if ( (int) $data["id"] == 0 ){
            unset( $data["id"] );
        }
        
        $this->form_validation->set_rules('descricao', 'Descricao', 'trim|required');
        
        if ($this->form_validation->run() == false) {
            
            $statusServidor = $this->getStatusServidor();
                
            if ( $statusServidor ){
                $this->pararServidor();
                $this->iniciarServidor();
            }
            
            echo json_encode(array("error" => $this->form_validation->error_array()), JSON_UNESCAPED_UNICODE);
        } else {
            
            $this->db->trans_start();
            $this->grupos->save($data);
            $this->db->trans_complete();
            
            if ($this->db->trans_status()) {
                echo json_encode(array("success" => "Operação realizada com sucesso", "data" => $data));
            } else {
                echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
            }
        }
    }
    
    public function ativarGrupo (){

        
        
        header('Content-Type: application/json');
        
        $this->db->trans_start();
        $this->grupos->ativar( $this->input->post('hash') );
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            
            $statusServidor = $this->getStatusServidor();
                
            if ( $statusServidor ){
                $this->pararServidor();
                $this->iniciarServidor();
            }
            
            echo json_encode(array("success" => "Operação realizada com sucesso"));
        } else {
            echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
        }
        
    }
    
    public function inativarGrupo (){

        
        
        header('Content-Type: application/json');
        
        $this->db->trans_start();
        $this->grupos->inativar( $this->input->post('hash') );
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            
            $statusServidor = $this->getStatusServidor();
                
            if ( $statusServidor ){
                $this->pararServidor();
                $this->iniciarServidor();
            }
            
            echo json_encode(array("success" => "Operação realizada com sucesso"));
        } else {
            echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
        }
    }
    
    public function excluirGrupo (){

        
        
        header('Content-Type: application/json');
        
        $this->db->trans_start();
        $this->grupos->excluir( $this->input->post('hash') );
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            echo json_encode(array("success" => "Operação realizada com sucesso"));
        } else {
            echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
        }
        
    }
    
    /********************************************/
    
    public function agendamentos(){        
        
        $this->data['subTitle']     = 'Task Runner :: Agendamentos';
        $this->data['agendamentos'] = $this->agenda->getAll();
        
        $this->load->view("robo/agenda", $this->data);
    }
    
    public function formAgendamentos($hash=null){

        
        if ( $hash == null ){
            $this->data['subTitle'] = 'Task Runner :: Novo Agendamento';
            $this->data['agenda']['cfg'] = array(
                0 => array(), 1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array()
            );
        }else{
            $this->data['subTitle'] = 'Task Runner :: Editar Agendamento';
            $this->data['agenda']   = $this->agenda->getByHash($hash);
            $this->data['agenda']['cfg'] = $this->cronToCfg( $this->data['agenda']["cron"] );
        }
        
        $this->data["grupos"]     = $this->grupos->getAll();
        $this->data["servidores"] = $this->execucao->get();
        
        $this->load->view('robo/agenda_form', $this->data);
        
    }
    
    public function salvarAgendamento(){        
        
        header('Content-Type: application/json');

        $data = $this->input->post();
        
        if ( (int) $data["id"] == 0 ){
            unset( $data["id"] );
        }
        
        $this->setRegrasAgendamento();
        
        if ($this->form_validation->run() == false) {
            echo json_encode(array("error" => $this->form_validation->error_array()), JSON_UNESCAPED_UNICODE);
        } else {
            
            unset($data["seg"]);
            unset($data["min"]);
            unset($data["hor"]);
            unset($data["dia"]);
            unset($data["mes"]);
            unset($data["sem"]);
            
            $data["data_criacao"] = date("Y-m-d H:i:s");
            
            if ( $data["id_grupo"] == "" ){
                unset($data["id_grupo"]);
            }
        
            if ( $data["id_servidor_execucao"] == "" || $data["id_servidor_execucao"] == "-" ){
                $data["id_servidor_execucao"] = null;
            }
            
            $this->db->trans_start();
            $this->agenda->save($data);
            $this->db->trans_complete();
            
            if ($this->db->trans_status()) {
                echo json_encode(array("success" => "Operação realizada com sucesso", "data" => $data));
                
                $statusServidor = $this->getStatusServidor();

                if ( $statusServidor ){
                    $this->pararServidor();
                    $this->iniciarServidor();
                }
                
            } else {
                echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
            }
        }
        
    }
    
    public function ativarAgendamento (){

        
        
        header('Content-Type: application/json');
        
        $this->db->trans_start();
        $this->agenda->ativar( $this->input->post('hash') );
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            echo json_encode(array("success" => "Operação realizada com sucesso"));
                
            $statusServidor = $this->getStatusServidor();

            if ( $statusServidor ){
                $this->pararServidor();
                $this->iniciarServidor();
            }

        } else {
            echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
        }
        
    }
    
    public function inativarAgendamento (){

        
        
        header('Content-Type: application/json');
        
        $this->db->trans_start();
        $this->agenda->inativar( $this->input->post('hash') );
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            echo json_encode(array("success" => "Operação realizada com sucesso"));
                
            $statusServidor = $this->getStatusServidor();

            if ( $statusServidor ){
                $this->pararServidor();
                $this->iniciarServidor();
            }

        } else {
            echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
        }
    }
    
    public function excluirAgendamento (){

        
        
        header('Content-Type: application/json');
        
        $this->db->trans_start();
        $this->agenda->excluir( $this->input->post('hash') );
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            echo json_encode(array("success" => "Operação realizada com sucesso"));
                
            $statusServidor = $this->getStatusServidor();

            if ( $statusServidor ){
                $this->pararServidor();
                $this->iniciarServidor();
            }

        } else {
            echo json_encode(array("error" => "Ocorreu um erro durante a operação. Nada foi alterado"));
        }
        
    }
    
    public function execAgendamento(){
        
        
        
        header('Content-Type: application/json');
        
        if ( $hash = $this->input->post("hash") ){
            
            $agenda = $this->agenda->getByHash($hash);
            
            if ( $agenda["tipo"] == 0 ){ //Executar Arquivo
                
                $prefix = "";
                
                if ( $agenda["id_servidor_execucao"] != null ){
                    $servidorExec = $this->execucao->getByHash( md5( $agenda["id_servidor_execucao"] ) );
                    $prefix = "{$this::$psExecPath} " . $servidorExec["host"] . " -u " . $servidorExec["usuario"] . " -p " . addslashes($servidorExec["senha"]) . " -i ";
                }
                
                pclose(popen( "start cmd /c " . $prefix.$agenda["exec"], 'r') );
                
            }else{
                
                $url = parse_url($agenda["exec"]);
                
                parse_str($url["query"], $query);

                foreach($query as &$q){
                    $q = urlencode($q);
                }

                $query = http_build_query($query, '', '&');
                
                @file_get_contents( $url["scheme"]."://".$url["host"].$url["path"]."?".$query );
                
            }
            
            $this->agenda->setUltimaExecucao($hash);
            
            echo json_encode(array("success" => "Operação realizada com sucesso"));
            
        }
        
    }


    private function setRegrasAgendamento(){
        $this->form_validation->set_rules('tipo', 'Tipo', 'trim|required');
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');
        $this->form_validation->set_rules('cron', 'Cron', 'trim|required');
        $this->form_validation->set_rules('exec', 'Ação', 'trim|required');
        
        $this->form_validation->set_rules('seg', 'Segundos', 'trim|required');
        $this->form_validation->set_rules('min', 'Minutos', 'trim|required');
        $this->form_validation->set_rules('hor', 'Horas', 'trim|required');
        $this->form_validation->set_rules('dia', 'Dias', 'trim|required');
        $this->form_validation->set_rules('mes', 'Meses', 'trim|required');
        $this->form_validation->set_rules('sem', 'Semanas', 'trim|required');
    }
    
    private function cronToCfg($str){
        
        $arr = explode(" ", $str);
        
        if ( is_array($arr) ){
            if ( count( $arr ) > 0 ){
                foreach( $arr as &$item ){
                    $item = explode(",", $item);
                }
            }
        }
        
        return $arr;
    }
        
    /********************************************/
    
    private function createServer($robo=null){
        if ( $robo == null ){
            $robo = $this->robo->get();
        }
        
        $content = "var http    = require('http');
var file    = require('fs');
var CronJob = require('cron').CronJob;
var wget    = require('wget');
var exec    = require('child_process').exec;

var querystring = require('querystring');
var dateFormat  = require('dateformat');
var txt         = file.createWriteStream('erro-critico.log', {flags: 'a', defaultEncoding: 'utf8'});

var server = http.createServer(function(request, response){
    response.writeHeader(200, {\"Content-Type\" : \"text/html\"});
    response.write(\"<h1>Servidor NodeJS</h1>\");
    
    if ( request.url == '/shutdown' ){
        process.exit();
    }

    response.end();
});

server.listen({$robo["port"]}, function(){
    log(\"Servidor Node.js online\");
});

process.stdin.resume();//so the program will not close instantly

function exitHandler(err) {

    var date = dateFormat(new Date(), \"yyyy-mm-dd hh:MM:ss\");    
    var data = new Buffer('['+date+'] [ERROR] Servidor Node.js offline... Good Bye!\\r\\n');

    try{
        file.writeSync(txt.fd, data, 0, data.length, txt.pos);
    }catch(e){}

    process.exit();
}

process.on('exit', exitHandler.bind(null));
process.on('SIGINT', exitHandler.bind(null));
process.on('uncaughtException', exitHandler.bind(null));

";

        $content .= $this->createSchedules();
        
        $content .= $this->endServer();
            
        file_put_contents($robo["path"] . DIRECTORY_SEPARATOR . $robo["file"], utf8_decode($content));
    }
    
    private function createSchedules(){
        
        $content = "";
        
        $url_server = $this->config->config["base_url"];
        
        $agendamentos = $this->agenda->getAllActive();
        
        foreach ($agendamentos as $agenda){
            
            if ( $agenda["tipo"] == 0 ){ //Executar Arquivo
                
                $prefix = "";
                
                if ( $agenda["id_servidor_execucao"] != null ){
                    $servidorExec = $this->execucao->getByHash( md5( $agenda["id_servidor_execucao"] ) );
                    $prefix = "{$this::$psExecPath} " . addslashes($servidorExec["host"]) . " -u " . addslashes($servidorExec["usuario"]) . " -p " . addslashes($servidorExec["senha"]) . " -i ";
                }
                
                $content .= "
try{
    new CronJob('{$agenda["cron"]}', function() {

        log(\"Executando JOB {$agenda["nome"]}\");

        try{
        
            set_ultima_execucao('".md5($agenda['id'])."');

            exec('{$prefix}{$agenda["exec"]}', function( error, stdout, stderr) {
                if ( error != null ) {
                    log(\"Erro ao executar o JOB {$agenda["nome"]} \\r\\n\" + stderr);
                }else{
                    log(\"JOB {$agenda["nome"]} executado com sucesso\");
                }

            });
        }catch(e){
            log('Erro critico \\r\\n' + e);
        }

    }, null, true, 'America/Sao_Paulo');
}catch(e){
    log('Erro critico \\r\\n' + e);
}
";
            }else{ //Página
                
                $url = parse_url($agenda["exec"]);
                
                parse_str($url["query"], $query);

                foreach($query as &$q){
                    $q = urlencode($q);
                }

                $query = http_build_query($query, '', '&');
                
                $content .= "
try{
    new CronJob('{$agenda["cron"]}', function() {

        log(\"Executando JOB {$agenda["nome"]}\");

        var options = {
            protocol: '{$url["scheme"]}',
            host: '{$url["host"]}',
            path: '{$url["path"]}?{$query}',
            method: 'GET'
        };
        
        try{
        
            set_ultima_execucao('".md5($agenda['id'])."');
        
            var req = wget.request(options, function(res) {
                var content = '';
                if (res.statusCode === 200) {
                    res.on('error', function(err) {
                        log(\"JOB {$agenda["nome"]} executado com sucesso\");
                    });
                } else {
                    log(\"Erro ao executar o JOB {$agenda["nome"]} \\r\\n\" + \"Server respond \" + res.statusCode);
                }
            });

            req.end();
            req.on('error', function(err) {
                log(\"Erro ao executar o JOB {$agenda["nome"]} \\r\\n\" + err);
            });
            
        }catch(e){
            log('Erro critico \\r\\n' + e);
        }

    }, null, true, 'America/Sao_Paulo');
}catch(e){
    log('Erro critico \\r\\n' + e);
}
";
                
            }
        }
        
        return $content;
        
    }
    
    private function endServer(){
        
        $url = parse_url( $this->config->config["base_url"] );
        
        $content = "
/*Função responsável por setar a data/hora da última execução da tarefa agendada*/
function set_ultima_execucao(hash) {

    var post_data = querystring.stringify({
        'hash' : hash
    });

  
    var post_options = {
        host: '{$url["host"]}',
        path: '{$url["path"]}robo-start/agendamentos/set_ultima_execucao',
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Content-Length': Buffer.byteLength(post_data)
        }
    };

    var post_req = http.request(post_options, function(res) {
        res.setEncoding('utf8');
        res.on('data', function (chunk) {
            console.log('Response: ' + chunk);
        });
    });

    post_req.write(post_data);
    post_req.end();

}            


/*Função responsável pela criação de logs dentro do portal*/
function log(message){
    
    try{
        var options = {
            protocol: '{$url["scheme"]}',
            host: '{$url["host"]}',
            path: '{$url["path"]}logs/inserir?t=5&m='+encodeURIComponent(message),
            method: 'GET'
        };

        var req = wget.request(options, function(res) {});
            req.end();
            req.on('error', function(err) {});
    }catch(e){
        var date = dateFormat(new Date(), \"yyyy-mm-dd hh:MM:ss\");
            txt.write('['+date+'] [ERROR] '+message+'\\r\\n                              '+e.message+'\\r\\n');
    }

}
";
        
        return $content;
    }
    
    private function getStatusServidor(){
        
        ini_set('default_socket_timeout', 2);
        header('Content-Type: application/json; charset=utf-8');

        $file_headers = @get_headers( $this->robo->getServerHost() );
        
        if($file_headers[0] == 'HTTP/1.1 200 OK') {
            $result = true;
        }else {
            $result = false;
        }

        return $result;
        
    }
    
}
