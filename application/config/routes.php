<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'robostart';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['servidor-node'] = 'robostart/servidor';
$route['servidor-node/salvar']   = 'robostart/salvarServidor';
$route['servidor-node/status']   = 'robostart/statusServidor';
$route['servidor-node/iniciar']  = 'robostart/iniciarServidor';
$route['servidor-node/parar']    = 'robostart/pararServidor';

$route['servidores-execucao']               = 'robostart/serverExec';
$route['servidores-execucao/adicionar']     = 'robostart/formServerExec';
$route['servidores-execucao/editar/(:any)'] = 'robostart/formServerExec/$1';
$route['servidores-execucao/salvar']        = 'robostart/salvarServerExec';
$route['servidores-execucao/excluir']       = 'robostart/excluirServerExec';

$route['grupos']               = 'robostart/grupos';
$route['grupos/adicionar']     = 'robostart/formGrupos';
$route['grupos/editar/(:any)'] = 'robostart/formGrupos/$1';
$route['grupos/salvar']        = 'robostart/salvarGrupo';
$route['grupos/ativar']        = 'robostart/ativarGrupo';
$route['grupos/inativar']      = 'robostart/inativarGrupo';
$route['grupos/excluir']       = 'robostart/excluirGrupo';

$route['agendamentos']               = 'robostart/agendamentos';
$route['agendamentos/adicionar']     = 'robostart/formAgendamentos';
$route['agendamentos/editar/(:any)'] = 'robostart/formAgendamentos/$1';
$route['agendamentos/salvar']        = 'robostart/salvarAgendamento';
$route['agendamentos/ativar']        = 'robostart/ativarAgendamento';
$route['agendamentos/inativar']      = 'robostart/inativarAgendamento';
$route['agendamentos/excluir']       = 'robostart/excluirAgendamento';

$route['agendamentos/set_ultima_execucao'] = 'acessolivre/setUltimaExecucaoAgendamento';
$route['agendamentos/executar']            = 'robostart/execAgendamento';