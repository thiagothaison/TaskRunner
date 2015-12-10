<?php

if (!function_exists('create_breadcrumb')) {

    function create_breadcrumb() {
        $ci = &get_instance();
        $i = 1;
        $uri = $ci->uri->segments[$i];
        $link = '<ol class="breadcrumb hidden-xxs">';

        $link .= '<li><a href="' . $ci->config->config["base_url"] . '"><i class="fa fa-home"></i> Página Incial</a></li>';

        while ($uri != '') {
            $prep_link = '';
            for ($j = 1; $j <= $i; $j++) {
                $prep_link .= $ci->uri->segments[$j] . '/';
            }
            
            if ( strlen($ci->uri->segments[$i]) != 32 ){
                if ( in_array($ci->uri->segments[$i-1], array("usuarios")) && isset($ci->uri->segments[$i+1]) && strlen($ci->uri->segments[$i+1]) != 32){
                    $link.='<li class="active">Busca por <u>' . urldecode( str_replace("-", " ", $ci->uri->segments[$i]) ) . '</u></li>';
                }else{
                    $link.='<li class="active">' . ucwords(str_replace("-", " ", $ci->uri->segments[$i])) . '</li>';
                }
            }

            $i++;
            $uri = $ci->uri->segments[$i];
        }
        $link .= '</ol>';

        echo $link;
    }

}

if (!function_exists('create_breadcrumb_logs')) {

    function create_breadcrumb_logs() {
        $ci = &get_instance();
        $i = 4;
        $uri = $ci->uri->segments[$i];
        
        if ( $uri != null ){
        
            $link = '<ul class="breadcrumb-log">';
            $link .= '<li><a href="' . $ci->config->config["base_url"] . 'portal/logs/arquivo">Logs :: Arquivo</a></li>';

            while ($uri != '') {

                if ( $ci->uri->segments[$i + 1] == null ){
                    $link.='<li>' . ucwords($ci->uri->segments[$i]) . '</li>';
                }else{

                    $prep_link = '';

                    for( $j=4; $j<=$i; $j++){
                        $prep_link .= $ci->uri->segments[$j] . "/";
                    }

                    $link.='<li><a href="' . $ci->config->config["base_url"] . 'portal/logs/arquivo/' . $prep_link . '">' . ucwords($ci->uri->segments[$i]) . '</a></li>';
                }

                $i++;
                $uri = $ci->uri->segments[$i];
            }

            $link .= '</ul>';
        
        }

        echo $link;
    }

}

if (!function_exists('get_uri_segment')) {

    function get_uri_segment($idx = null) {
        $ci = &get_instance();
        $segments = $ci->uri->segments;

        if ( $idx === null ){
            return $segments;
        }else if ( $idx === "first" ){
            return $segments[1];
        }else if ( $idx === "last" ){
            return $segments[count($segments)-1];
        }else{
            return $segments[$idx];
        }
        
    }

}

if (!function_exists('create_combobox')) {

    function create_combobox($arr = array(), $key = null, $value = null, $name='selectbox', $selected = '', $attr = '', $createBlank=true) {
        
        $select  = "<select name='$name' class='form-control' $attr style='width: 100%'>";
        
        $select .= $createBlank ? "<option value=''>Selecione</option>" : '';
        
        //Resetar a posição do Array
        reset($arr);
        
        //Buscar os focais do sistema
        //$data[key($data)] pega o primeiro índice do Array. Pode acontecer do primeiro índice não ser zero
        if ( is_array( $arr[key($arr)] ) ){
            foreach ($arr as $item){
                $select .= "<option value='".$item[$key]."' ".($item[$key] === $selected ? 'selected' : '').">".$item[$value]."</option>";
            }
        }else{
            foreach ($arr as $k => $v){
                $select .= "<option value='".$k."' ".($k === $selected ? 'selected' : '').">".$v."</option>";
            }
        }
        
        $select .= "</select>";
        
        return $select;
        
    }

}

if ( !function_exists('criarPaginacao') ){
    
    function criarPaginacao($query, $pagina, $inicio, $fim, $offset, $result, $base_url = 'cadastros/usuarios/'){
        
        $CI = &get_instance();
        
        $last_query = $CI->db->last_query();
        $strQuery      = substr($last_query, 0, strpos($last_query, "LIMIT"));

        $total = $CI->db->query($strQuery)->num_rows();

        $pag  = '<div class="row" style="margin-top: 15px">';
        $pag .= '    <div class="col-xs-6">';
        $pag .= '        <div class="dataTables_info" id="DataTables_Table_0_info">';

        if ( count( $result ) == 0 ){
            $pag .= '        Nenhum resultado encontrado';
        }else if( count( $result ) < $offset ){
            if ( $total == $offset ){
                $pag .= '    Mostrando de ' . ($inicio + 1) . ' à ' . count( $result ) . ' dos ' . count( $result ) . ' registros';
            }else{
                $pag .= '    Mostrando de ' . ($inicio + 1) . ' à ' . $total . ' dos ' . $total . ' registros';
            }
        }else{
            $pag .= '        Mostrando de ' . ($inicio + 1) . ' à ' . $fim . ' dos ' . $total . ' registros';
        }

        if ( $query != '' ){
            $pag .= ' (Resultados filtrados por <strong>'.$query.'</strong>)';
        }

        $pag .= '        </div>';
        $pag .= '    </div>';
        $pag .= '    <div class="col-xs-6">';
        $pag .= '        <div class="dataTables_paginate paging_bootstrap">';
        $pag .= '            <ul class="pagination">';

        $totalPaginas = ceil(($total/$offset)+(1-(($total/$offset)%1))%1);

        if ( $pagina == 1 ){
            $pag .= '            <li class="prev disabled"><a href="#">← Anterior</a></li>';
        }else{

            $url = 'pagina-'.($pagina-1);
            $query != '' ? $url = $query .'/'.$url : false;
            $url = $CI->config->item('base_url').$base_url . $url;

            $pag .= '            <li class="prev"><a href="'.$url.'">← Anterior</a></li>';
        }

        if ( $totalPaginas <= 5 ){
            for ($i=1; $i<=$totalPaginas; $i++){

                $url = 'pagina-'.($i);
                $query != '' ? $url = $query .'/'.$url : false;
                $url = $CI->config->item('base_url').$base_url . $url;

                $pag .= '        <li class="'.($i==$pagina?'active':'').'"><a href="'.$url.'">'.$i.'</a></li>';
            }
        }else{
            $adjacentes = 2;

            if ( $pagina < 1 + ( 2 * $adjacentes) ){

                for ($i=1; $i<=2 + ( 2 * $adjacentes); $i++){

                    $url = 'pagina-'.($i);
                    $query != '' ? $url = $query .'/'.$url : false;
                    $url = $CI->config->item('base_url').$base_url . $url;

                    $pag .= '    <li class="'.($i==$pagina?'active':'').'"><a href="'.$url.'">'.$i.'</a></li>';
                }
            }else if($pagina > ( 2 * $adjacentes ) && $pagina < $totalPaginas - 3){

                $url    = 'pagina-1';
                $query != '' ? $url = $query .'/'.$url : false;
                $url    = $CI->config->item('base_url').$base_url . $url;
                $pag .= '        <li><a href="'.$url.'">1</a></li>';

                $url    = 'pagina-2';
                $query != '' ? $url = $query .'/'.$url : false;
                $url    = $CI->config->item('base_url').$base_url . $url;
                $pag .= '        <li><a href="'.$url.'">2</a></li>';

                $pag .= '        <li class="disabled"><a href="#">...</a></li>';

                for($i=($pagina-$adjacentes); $i<=($pagina+$adjacentes); $i++){

                    $url = 'pagina-'.($i);
                    $query != '' ? $url = $query .'/'.$url : false;
                    $url = $CI->config->item('base_url').$base_url . $url;

                    $pag .= '    <li class="'.($i==$pagina?'active':'').'"><a href="'.$url.'">'.$i.'</a></li>';
                }

                $pag .= '        <li class="disabled"><a href="#">...</a></li>';

                $url    = 'pagina-'.($totalPaginas-1);
                $query != '' ? $url = $query .'/'.$url : false;
                $url    = $CI->config->item('base_url').$base_url . $url;
                $pag .= '        <li><a href="'.$url.'">'.($totalPaginas-1).'</a></li>';

                $url    = 'pagina-'.$totalPaginas;
                $query != '' ? $url = $query .'/'.$url : false;
                $url    = $CI->config->item('base_url').$base_url . $url;
                $pag .= '        <li><a href="'.$url.'">'.$totalPaginas.'</a></li>';

            }else{

                $url    = 'pagina-1';
                $query != '' ? $url = $query .'/'.$url : false;
                $url    = $CI->config->item('base_url').$base_url . $url;
                $pag .= '        <li><a href="'.$url.'">1</a></li>';

                $url    = 'pagina-2';
                $query != '' ? $url = $query .'/'.$url : false;
                $url    = $CI->config->item('base_url').$base_url . $url;
                $pag .= '        <li><a href="'.$url.'">2</a></li>';

                $pag .= '        <li class="disabled"><a href="#">...</a></li>';

                for($i=($totalPaginas-(4+(2*$adjacentes))); $i<=$totalPaginas; $i++){
                    
                    if ( $i > 2 ){

                        $url = 'pagina-'.($i);
                        $query != '' ? $url = $query .'/'.$url : false;
                        $url = $CI->config->item('base_url').$base_url . $url;

                        $pag .= '    <li class="'.($i==$pagina?'active':'').'"><a href="'.$url.'">'.$i.'</a></li>';
                    
                    }
                    
                }
            }

        }

        if ( $totalPaginas == $pagina ){
            $pag .= '            <li class="next disabled"><a href="#">Próximo → </a></li>';    
        }else{
            $url = 'pagina-'.($pagina+1);
            $query != '' ? $url = $query .'/'.$url : false;
            $url = $CI->config->item('base_url').$base_url . $url;
            $pag .= '            <li class="next"><a href="'.$url.'">Próximo → </a></li>';
        }

        $pag .= '            </ul>';
        $pag .= '        </div>';
        $pag .= '    </div>';
        $pag .= '</div>';

        return $pag;

    }
    
}