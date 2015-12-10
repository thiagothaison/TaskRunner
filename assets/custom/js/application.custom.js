//Tempo entre as requisições ajax que verificam se existem novas intenções de acesso ou novas mensagens
var delayRequests = 5000;

//Identificando o idioma do navegador
if(navigator.browserLanguage) {  
    var idioma = navigator.browserLanguage;    
}else if(navigator.language) {
    var idioma = navigator.language;
}

//Reescrita no método contains do jQuery para que ele consiga entender acentos
jQuery.expr[':'].contains = function(a, i, m) {
    var rExps = [
        {re: /[\xC0-\xC6]/g, ch: "A"},
        {re: /[\xE0-\xE6]/g, ch: "a"},
        {re: /[\xC8-\xCB]/g, ch: "E"},
        {re: /[\xE8-\xEB]/g, ch: "e"},
        {re: /[\xCC-\xCF]/g, ch: "I"},
        {re: /[\xEC-\xEF]/g, ch: "i"},
        {re: /[\xD2-\xD6]/g, ch: "O"},
        {re: /[\xF2-\xF6]/g, ch: "o"},
        {re: /[\xD9-\xDC]/g, ch: "U"},
        {re: /[\xF9-\xFC]/g, ch: "u"},
        {re: /[\xC7-\xE7]/g, ch: "c"},
        {re: /[\xD1]/g, ch: "N"},
        {re: /[\xF1]/g, ch: "n"}
    ];

    var element = $(a).text();
    var search = m[3];

    $.each(rExps, function() {
        element = element.replace(this.re, this.ch);
        search = search.replace(this.re, this.ch);
    });

    return element.toUpperCase()
            .indexOf(search.toUpperCase()) >= 0;
};

/****** Alert ******/
AlertMessage = function() {

    var element = jQuery('<div class="row">' +
            '<div class="col-sm-12 col-lg-12">' +
            '<div class="alert alert-dismissable">' +
            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
            '<h4><strong></strong></h4>' +
            '<p></p>' +
            '</div>' +
            '</div>' +
            '</div>');

    var createAlert = function(type, text, title) {

        switch (type) {
            case 'info':
                cls = 'alert-info';
                ico = "<i class='fa fa-info-circle'></i> Informação";
                break;

            case 'warn':
                cls = 'alert-warning';
                ico = "<i class='fa fa-warning'></i> Atenção";
                break;

            case 'error':
                cls = 'alert-danger';
                ico = "<i class='icon fa fa-ban'></i>";
                break;

            case 'success':
                cls = 'alert-success';
                ico = ":)";
                break;
        }

        if (title != null) {
            ico = ico + title;
        }

        if (jQuery("div.alert.alert-dismissable").length) {
            e = jQuery("div.alert.alert-dismissable");
            //e.fadeOut('fast');
            //window.setTimeout(function(){
            e.remove();
            createAlert(type, text, title);
            //}, 350);
            return;
        }

        var e = element.clone();
        e.find('p').html(text);
        e.find('h4 > strong').html(ico);
        e.find('div.alert').addClass(cls);
        e.hide();

        if ( $("section.content").length > 0 ){
            $("section.content").eq(0).prepend(e);
        }else{
            $("section.content-message").eq(0).prepend(e);
        }

        
        e.fadeIn(250);

        scrollTop();

        window.setTimeout(function() {
            e.fadeOut('fast');
            window.setTimeout(function() {
                e.remove();
            }, 250);
        }, 10000);
    };

    var scrollTop = function() {
        jQuery("body").animate({scrollTop: 0}, 'fast');
    };

    this.info = function(text, title) {
        createAlert('info', text, title);
    };

    this.warn = function(text, title) {
        createAlert('warn', text, title);
    };

    this.error = function(text, title) {
        createAlert('error', text, title);
    };

    this.success = function(text, title) {
        createAlert('success', text, title);
    };

};

/*Função responsável por criar os alertas na tela:
 * Ex: AlertBallon.info(mensagem, titulo)*/
AlertBallon = new AlertMessage();

/*Criação dos layouts dos alertas modal*/
var mAlert = $("<div class='modal fade' role='dialog' tabindex='-1'> " +
        "  <div class='modal-dialog'> " +
        "    <div class='modal-content'> " +
        "      <div class='modal-header'> " +
        "        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button> " +
        "        <h4 class='modal-title'></h4> " +
        "      </div> " +
        "      <div class='modal-body'> " +
        "        <p></p> " +
        "      </div> " +
        "      <div class='modal-footer'> " +
        "        <button type='button' class='btn btn-primary' data-dismiss='modal'>Ok, entendi!</button> " +
        "      </div> " +
        "    </div> " +
        "  </div> " +
        "</div> ");

var mAlert = $("<div class='modal fade' role='dialog' tabindex='-1'> " +
        "  <div class='modal-dialog'> " +
        "    <div class='modal-content'> " +
        "      <div class='modal-header'> " +
        "        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button> " +
        "        <h4 class='modal-title'></h4> " +
        "      </div> " +
        "      <div class='modal-body'> " +
        "        <p></p> " +
        "      </div> " +
        "      <div class='modal-footer'> " +
        "        <button type='button' class='btn btn-primary' data-dismiss='modal'>Ok, entendi!</button> " +
        "      </div> " +
        "    </div> " +
        "  </div> " +
        "</div> ");

var mObservacao = $("<div class='modal fade' role='dialog'> " +
        "  <div class='modal-dialog'> " +
        "    <div class='modal-content'> " +
        "      <div class='modal-header'> " +
        "        <button type='button' class='close' data-dismiss='modal' aria-label='Close'></button> " +
        "        <h4 class='modal-title'>Observação</h4> " +
        "      </div> " +
        "      <div class='modal-body'> " +
        "        <textarea rows='3' class='form-control' role='observacoes' placeholder='Insira aqui suas observações...'></textarea>" +
        "        <small class='text-red' role='error-message' style='margin: 15px 0 0 0; display: block;'></small>" +
        "      </div> " +
        "      <div class='modal-footer'> " +
        "        <button type='button' class='btn btn-default btn-no'>Cancelar</button> " +
        "        <button type='button' class='btn btn-primary btn-yes'>OK</button> " +
        "      </div> " +
        "    </div> " +
        "  </div> " +
        "</div> ");

var mConfirmation = $("<div class='modal fade' role='dialog'> " +
        "  <div class='modal-dialog'> " +
        "    <div class='modal-content'> " +
        "      <div class='modal-header'> " +
        "        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button> " +
        "        <h4 class='modal-title'></h4> " +
        "      </div> " +
        "      <div class='modal-body'> " +
        "        <p></p> " +
        "      </div> " +
        "      <div class='modal-footer'> " +
        "        <button type='button' class='btn btn-default btn-no'>Não</button> " +
        "        <button type='button' class='btn btn-primary btn-yes'>Sim, eu confirmo</button> " +
        "      </div> " +
        "    </div> " +
        "  </div> " +
        "</div> ");

var mChangePwd = $("<div class='modal fade' role='dialog'> " +
        "  <div class='modal-dialog' style='width: 400px;'> " +
        "    <div class='modal-content'> " +
        "      <div class='modal-header'> " +
        "        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button> " +
        "        <h4 class='modal-title'></h4> " +
        "      </div> " +
        "      <div class='modal-body'> " +
        "        <p></p> " +
        "      </div> " +
        "      <div class='modal-footer'> " +
        "        <button type='button' class='btn btn-primary change-pwd'>Alterar!</button> " +
        "      </div> " +
        "    </div> " +
        "  </div> " +
        "</div> ");

var mCrop = $("<div class='modal fade' role='dialog'> " +
        "  <div class='modal-dialog'> " +
        "    <div class='modal-content'> " +
        "      <div class='modal-header'> " +
        "        <button type='button' class='close' data-dismiss='modal' aria-label='Close'></button> " +
        "        <h4 class='modal-title'>Cortar Imagem</h4> " +
        "      </div> " +
        "      <div class='modal-body' style='padding: 0px; !important'> " +
        "        <p><img src='" + app_u + "assets/uploads/imagens_sistemas/unavaliable.png' class='img-responsive-height text-center center-block'/></p> " +
        "      </div> " +
        "      <div class='modal-footer'> " +
        "        <button type='button' class='btn btn-flat btn-default' role='cancelar'>Cancelar</button> " +
        "        <button type='button' class='btn btn-flat btn-primary modal-confirm-button' role='crop'>Cortar</button> " +
        "      </div> " +
        "    </div> " +
        "  </div> " +
        "</div> ");

var mWait = $("<div class='modal fade' role='dialog' tabindex='-1'> " +
        "  <div class='modal-dialog'> " +
        "    <div class='modal-content'> " +
        "      <div class='modal-header'> " +
        "        <h4 class='modal-title'></h4> " +
        "      </div> " +
        "      <div class='modal-body'> " +
        "        <div class='progress active'> " +
        "          <div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%'> "+
        "            <span class='sr-only'></span> "+
        "          </div> "+
        "        </div> "+
        "        <p style='text-align: left;'><strong>Iniciando...</strong></p> " +
        "      </div> " +
        "      <div class='modal-footer' style='border-top: none'> " +
        "      </div> " +
        "    </div> " +
        "  </div> " +
        "</div> ");

var mForm = $("<div class='modal fade' role='dialog'> " +
        "  <div class='modal-dialog' style='width: 400px;'> " +
        "    <div class='modal-content'> " +
        "      <div class='modal-header'> " +
        "        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button> " +
        "        <h4 class='modal-title'></h4> " +
        "      </div> " +
        "      <div class='modal-body'> " +
        "        <div class='form-group'><label>Usuário</label><input type='text' name='network-user' class='form-control'></div> " +
        "        <div class='form-group'><label>Senha</label><input type='password' name='network-pass' class='form-control'></div> " +
        "        <small class='text-red'></small> " +
        "      </div> " +
        "      <div class='modal-footer'> " +
        "        <button type='button' class='btn btn-flat btn-default' role='cancelar'>Cancelar</button> " +
        "        <button type='button' class='btn btn-flat btn-primary' role='start-backup'>Iniciar Backup</button> " +
        "      </div> " +
        "    </div> " +
        "  </div> " +
        "</div> ");

/*Criação do layout do overlay*/
var overlay = $("<div class='overlay'> " +
        "    <i class='fa fa-refresh fa-spin'></i> " +
        "</div>");

function showProgressBkp(nome, hash){
    
    if ( typeof $.fileDownload !== "function" ){
        return;
    }
    
    var wait = $( mWait ).clone();
        wait.find('.modal-title').text('Realizando backup do sistema ' + nome);
        
    wait.on('hidden.bs.modal', function() {
        setTimeout(function(){
            wait.remove();
        }, 1000);
    });
    
    wait.on('shown.bs.modal', function() {
        
        var progress = wait.find('div.progress');
        var text = wait.find('div.modal-body p');
        
        var xhr = new XMLHttpRequest();
        xhr.open('post', app_u + 'cadastros/sistemas/backup/' + hash, true);

        xhr.onreadystatechange = function(e) {

            readReturnBackup(xhr, wait, progress, text, nome, hash);
            
        };

        xhr.addEventListener("error", function() {
            AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
            wait.modal('toggle');
        }, false);

        xhr.send();
        
    });
    
    wait.modal({
        backdrop: 'static',
        keyboard: false
    });
}

function getUserAndPassword(nome, hash){
            
    if ( typeof $.fileDownload !== "function" ){
        return;
    }
    
    var form = $( mForm ).clone();
        form.find('.modal-title').text('Informe seu usuário e senha de rede');
        
    form.on('hidden.bs.modal', function() {
        setTimeout(function(){
            form.remove();
        }, 1000);
    });
    
    form.on('shown.bs.modal', function() {
        form.find("input[name='network-user']").focus();
    });
    
    form.find('button[role="start-backup"]').on('click', function(){
        
        if ( 
                form.find("input[name='network-user']").val() == "" || 
                form.find("input[name='network-pass']").val() == "" 
            ){
            
            form.find('div.modal-body small').text('Todos os campos são obrigatórios');
            
        }else{
            
            form.modal('toggle');

            var wait = $( mWait ).clone();
                wait.find('.modal-title').text('Realizando backup do sistema ' + nome);

            wait.on('hidden.bs.modal', function() {
                setTimeout(function(){
                    wait.remove();
                }, 1000);
            });

            wait.on('shown.bs.modal', function() {

                var progress = wait.find('div.progress');
                var text = wait.find('div.modal-body p');

                var xhr = new XMLHttpRequest();
                xhr.open('post', app_u + 'cadastros/sistemas/backup/' + hash + '/exec', true);

                xhr.onreadystatechange = function(e) {

                    readReturnBackup(xhr, wait, progress, text, nome, hash);

                };

                xhr.addEventListener("error", function() {
                    AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                    wait.modal('toggle');
                }, false);
                
                var fData = new FormData;
                    fData.append('user', form.find("input[name='network-user']").val());
                    fData.append('pass', form.find("input[name='network-pass']").val());

                xhr.send(fData);

            });

            wait.modal({
                backdrop: 'static',
                keyboard: false
            });
            
        }
        
    });
    
    form.modal({
        backdrop: 'static',
        keyboard: false
    });
}

var readReturnBackup = function(xhr, wait, progress, text, nome, hash){
    
    console.log(xhr);
    
    if (4 === xhr.readyState) {

        try {

            var new_response = JSON.parse("[" + xhr.responseText.replace(/}{/g, '},{') + "]");
            var data = new_response[new_response.length - 1];

            if ( data.success !== undefined ){

                $.fileDownload(app_u + '/cadastros/sistemas/backup/download', {
                    successCallback: function(url) {
                        AlertBallon.success( data.success );
                        wait.modal('toggle');
                    },
                    failCallback: function(html, url) {
                        AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                        wait.modal('toggle');
                    }
                });

            }else if (typeof data.error !== "undefined") {

                if ( typeof data.error === "object") {

                    var message = "";
                    $.each(data.error, function(key, value){
                        message += value + "<br>";
                    });
                    AlertBallon.error(message, "Opss... Alguns campos merecem sua atenção:");

                }else{
                    AlertBallon.error(data.error, "Opss...");
                }

                wait.modal('toggle');

            } else {
                AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                wait.modal('toggle');
            }

        } catch (e) {
            if (console !== undefined) {
            }
        }

    } else if (xhr.readyState > 2) {
        try {

            var new_response = JSON.parse("[" + xhr.responseText.replace(/}{/g, '},{') + "]");
            var result = new_response[new_response.length - 1];

            if ( result.info !== undefined ){

                wait.modal('toggle');

                getUserAndPassword(nome, hash);

                xhr.abort();
                return;
            }

            progress.find("div.progress-bar").width(result.progress + '%');

            text.html(result.message);

        } catch (e) {
            if (typeof console !== "undefined") {
            }
        }
    }
    
}

function showObsBox(yes, no, title){
    
    var obs = $( mObservacao ).clone();
    
    if ( title != null ){
        obs.find('.modal-title').text(title);
    }
    
    obs.find('button.btn-yes').on('click', function() {
        if (typeof yes === "function") {
            yes(obs);
        }
    });

    obs.find('button.btn-no').on('click', function() {
        if (typeof no === "function") {
            no(obs);
        }
        obs.find('button.close').trigger('click');
    });
    
    obs.find("textarea[role='observacoes']").on("keydown", function(e){
        if ( e.ctrlKey && e.keyCode == 13 ){
            obs.find('button.btn-yes').trigger('click');
            return false;
        }
    });
    
    obs.on('shown.bs.modal', function() {
        $("textarea[role='observacoes']").focus();
    });
    
    obs.modal({
        backdrop: 'static',
        keyboard: false
    });
    
}

function showAlert(title, msg, width) {

    var alerta = $(mAlert).clone();
    
    if ( width != null ){
        alerta.find(".modal-dialog").width(width);
    }

    alerta.find('.modal-title').text(title);
    alerta.find('.modal-body').html('<p>' + msg + '</p>');

    alerta.modal('show');

}

function showConfirm(title, message, yes, no) {

    var confirm = $(mConfirmation).clone();

    confirm.find('.modal-title').text(title);
    confirm.find('.modal-body').html(message);

    confirm.find('button.btn-yes').on('click', function() {
        if (typeof yes === "function") {
            yes();
        }
        confirm.find('button.close').trigger('click');
    });

    confirm.find('button.btn-no').on('click', function() {
        if (typeof no === "function") {
            no();
        }
        confirm.find('button.close').trigger('click');
    });

    confirm.modal('show');

}

function crop(img, urlCrop, fSuccess, aspectRatio) {

    var crop = $(mCrop).clone();

    var x1 = 0, y1 = 0, x2 = 0, y2 = 0, width = 0, height = 0, fileName = img;

    function showCoords(c) {

        var areaCrop = $("div.jcrop-holder > img");
        var imgOriginal = new Image();
        imgOriginal.src = areaCrop.attr('src');

        scale = imgOriginal.width / areaCrop.width();

        x1 = parseInt(c.x * scale);
        y1 = parseInt(c.y * scale);
        x2 = parseInt(c.x2 * scale);
        y2 = parseInt(c.y2 * scale);
        width = parseInt(c.w * scale);
        height = parseInt(c.h * scale);       

    };

    crop.find("img").prop("src", app_u + "assets/uploads/temp/" + img);

    crop.on('shown.bs.modal', function() {

        crop.find("img").Jcrop({
            aspectRatio : aspectRatio,
            onChange    : showCoords,
            onSelect    : showCoords,
            bgColor     : 'black',
            bgOpacity   : 0.4,
            //setSelect   : [0, 0, 600, 375]
        });

    });
    
    crop.find("button[role='cancelar']").click(function(){
        
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: app_u + 'apagar-arquivo-temporario',
            data: {'fileName': fileName},
            success : function(){
                
            },
            error : function(){}
        });
        
        crop.find('button.close').trigger('click');
    });

    crop.find("button[role='crop']").click(function() {

        if (width == 0) {
            showAlert('Opsss', 'Selecione a área da imagem.');
        } else {
            
            $(this).prop('disabled', 'disabled');

            $.ajax({
                dataType: 'json',
                type: "POST",
                url: urlCrop,
                data: {
                    'x1': x1,
                    'y1': y1,
                    'x2': x2,
                    'y2': y2,
                    'width': width,
                    'height': height,
                    'fileName': fileName
                },
                success: function(data, textStatus, jqXHR) {

                    crop.find('button.close').trigger('click');

                    if (data !== null) {
                       if (fSuccess !== undefined && fSuccess !== null) {
                            if (typeof (fSuccess) === 'function') {
                                fSuccess(fileName);
                            } else {
                                AlertBallon.success(data.success, null);
                            }
                        } else {
                            AlertBallon.success(data.success, null);
                        }
                        
                        return;
                    }

                    AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);

                },
                error: function(jqXHR, textStatus, errorThrown){
                    AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                    if (console != undefined) {
                        console.log(textStatus, errorThrown);
                    }
                }
            });

        }

    });

    crop.modal({
        backdrop: 'static',
        keyboard: false
    });

}

function ajaxSubmit(form, onSuccess, onError){
    
    $.ajax({
        url      : form.attr('action'),
        data     : form.serialize(),
        dataType : 'json',
        type     : form.attr('method'),
        success  : function(data){
            if ( typeof data.success !== "undefined" ){
                AlertBallon.success(data.success);
                
                if (typeof (onSuccess) === 'function') {
                    onSuccess(data);
                }

            }else if ( typeof data.error !== "undefined" ){
                if ( typeof data.error === "object") {
                    var message = "";
                    $.each(data.error, function(key, value){
                        message += value + "<br>";
                    });
                    AlertBallon.error(message, "Opss... Alguns campos merecem sua atenção:");
                }else{
                    AlertBallon.error(data.error, "Opss...");
                }
                
                if (typeof (onError) === 'function') {
                    onError(data);
                }
                
            }else{
                AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                
                if (typeof (onError) === 'function') {
                    onError(data);
                }
                
            }
        }
    });
    
}

function initDataTables(ID){
    
    var query;
    
    if ( ID == null ){
        query = "table.data-table";
    }else{
        query = "table.data-table#"+ID;
    }
    
    /*Configuração padrão dos DataTables*/
    $(query).each(function() {
        
        if ( ! $.fn.DataTable.fnIsDataTable( query ) ) {

            pageLength = parseInt($(this).attr('pageLength') == undefined ? 10 : $(this).attr('pageLength'));
            ignoreOrder = new Array();

            if ($(this).attr('ignoreOrder') != undefined) {
                arrOrder = $(this).attr('ignoreOrder').split(",");

                for (var i = 0; i < arrOrder.length; i++) {
                    ignoreOrder.push(parseInt(arrOrder[i], 10));
                }

            }

            if ($(this).attr('aaSorting') != undefined) {
                aaSorting = jQuery.parseJSON($(this).attr('aaSorting'))
            } else {
                aaSorting = [];
            }

            if ($(this).attr('filter') == undefined) {
                dom = '<"hidden" f>,t,<"row" <"col-xs-6"i><"col-xs-6"p>>';
            } else if ($(this).attr('filter') == 'true') {
                dom = '<"row" <"col-xs-6"><"col-xs-6" f>>, t,<"row" <"col-xs-6"i><"col-xs-6"p>>';
            } else {
                dom = '<"hidden" f>,t,<"row" <"col-xs-6"i><"col-xs-6"p>>';
            }

            if ($(this).attr('paginate') != undefined) {
                paginate = $(this).attr('paginate') == true;
            } else {
                paginate = true;
            }

            if ($(this).attr('sort') != undefined) {
                sort = $(this).attr('sort') == true;
            } else {
                sort = true;
            }

            $(this).dataTable({
                "iDisplayLength": pageLength,
                "bPaginate": paginate,
                "bLengthChange": false,
                "bFilter": true,
                "bSort": sort,
                "bInfo": paginate,
                "bAutoWidth": false,
                "aaSorting": aaSorting,
                "oLanguage": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ à _END_ dos _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 á 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                },
                "order": [[1, "desc"]],
                "aoColumnDefs": [
                    {"bSortable": false, "aTargets": ignoreOrder},
                ],
                sDom: dom

            });
        
        }
        
    });
}

function initAutocompletes(ID){
    
    if ( typeof $().autocomplete == "function" ){
        
        var query;
    
        if ( typeof ID === "object"){
            query = ID;
        }else if ( ID == null ){
            query = $("input[data-type='autocomplete']");
        }else{
            query = $("input#"+ID+"[data-type='autocomplete']");
        }

        /*Configuração padrão dos campos autocomplete*/
        query.each(function() {

            var href = $(this).attr('data-url'),
                target = $(this).parents(".form-group").eq(0).find("[id='"+$(this).attr('data-target').substring(1)+"']"), //$($(this).attr('data-target')),
                field = $(this);

            field.autocomplete({
                source: function(request, response) {

                    $.ajax({
                        url: app_u + href,
                        dataType: 'jsonp',
                        data: {
                            query: request.term
                        },
                        success: function(data) {

                            if (data !== null) {
                                response($.map(data, function(item) {

                                    var result = {};

                                    if (typeof item.sigla !== "undefined") {
                                        result.label = item.descricao + ' (' + item.sigla + ')';
                                    } else if (typeof item.chapa !== "undefined") {
                                        result.label = item.chapa + ' - ' + item.nome;
                                    } else if (typeof item.nome !== "undefined") {
                                        result.label = item.descricao + ' - ' + item.nome;
                                    } else {
                                        result.label = item.descricao;
                                    }

                                    result.value = item.descricao;
                                    result.id = item.id;

                                    return result;

                                }));
                            }
                        },
                        beforeSend: null,
                        complete: null,
                        error: function(e) {
                        }
                    });
                },
                select: function(event, ui) {
                    var data = ui.item;
                    target.val(data.id);
                    field.val(data.value);

                    if ( field.parent().hasClass('input-group') ){
                        var inputGroup = field.parent();

                        if ( inputGroup.hasClass("input-group") ){
                            if ( inputGroup.find("span.input-group-addon i").hasClass('fa-warning') ){
                                inputGroup.find("span.input-group-addon i")
                                    .removeClass("fa-warning text-yellow")
                                    .addClass("fa-check text-green");

                                inputGroup.find("span.input-group-btn").remove();
                            }
                        }
                    }
                },
                autoFocus: false,
                minLength: 2,
                open: function() {
                }
            });

            $(this).on('input', function(e) {
                target.val('-');
                
                var inputGroup = $(e.target).parent();

                if ( inputGroup.hasClass("input-group") ){
                    if ( inputGroup.find("span.input-group-addon i").hasClass('fa-check') ){
                        inputGroup.find("span.input-group-addon i")
                            .removeClass("fa-check text-green")
                            .addClass("fa-warning text-yellow");
                    }
                }
                
            });

        });
        
    }
    
}

$(function() {
    
    /*
     * Início das configuraçõs padrões
     */
    
    if ( typeof $().sortable === "function" ){
    
        $(".sistemas.sortable").sortable({
            placeholder : "col-xs-6 col-sm-4 col-md-3 col-lg-2 sistema-box sistema-box-highlight",

                start: function(){ 
                    $("div.small-box").find('div:first').removeClass('flip-container');

                    var target = $("div.sistema-box-highlight");
                    var obj = $("div.sistema-box").not(target).eq(0);

                    target.width( obj.width() - 30 - 4 -2); //(-) as margens laterais (-) as bordas laterais
                    target.height( obj.height() -15 - 4); //(-) as margens laterais (-) as bordas laterais

                },
                stop: function(){ 
                    if ( menu_animado ){
                        $("div.small-box").find('div:first').addClass('flip-container'); 
                    }
                },
                out: function(){
                    var arr = {};
                    $("div.sistema-box").each(function(){
                        var obj = $(this);
                        arr[obj.index()] = obj.attr("data-id");
                    });
                    
                    $.ajax({
                       url      : app_u + 'reorganizar-sistemas',
                       type     : 'post',
                       dataType : 'json',
                       data     : {reorder : arr}
                    });
                    
                },
        });

        $(".sistemas").disableSelection();
    
    }

    /*Configuração padrão dos preloaders nas requisições ajax*/
    $.ajaxSetup({
        cache : false,
        beforeSend: function(jqXHR, settings) {
            overlay.appendTo(
                $(".box.allow-preloader, .nav-tabs-custom.allow-preloader")
            );
        },
        complete: function(jqXHR, textStatus) {
            overlay.remove();
        },
        error: function(jqXHR, textStatus, errorThrown){
            AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
            if (console != undefined) {
            }
        }
    });

    /*Configuração padrão das mascaras dos campos*/
    if (!(typeof $.mask === "undefined")) {

        $("input[data-type='phone']")
                .mask("(99) 9999-9999?9")
                .focusout(function(event) {
                    var target, phone, element;
                    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                    phone = target.value.replace(/\D/g, '');
                    element = $(target);
                    element.unmask();
                    if (phone.length > 10) {
                        element.mask("(99) 99999-999?9");
                    } else {
                        element.mask("(99) 9999-9999?9");
                    }
                });

        $("input[data-type='zip-code']").mask("99999-999");
        $("input[data-type='cpf']").mask("999.999.999-99");
        $("input[data-type='cnpj']").mask("99.999.999/9999-99");
        $("input[data-type='rg']").mask("99.999.999?-*");
        $("input[data-type='plate']").mask("***-9999");

    }
    
    /*Configuração padrão dos campos com datepicker*/
    if (!(typeof $().datetimepicker === "undefined")) {
        $("input[data-type='datetimepicker']").datetimepicker({
            format  : "DD/MM/YYYY HH:mm",
            minDate : new Date()
        });
    }

    /*Configuração padrão dos campos com datepicker*/
    if (!(typeof $().datepicker === "undefined")) {
        $("input[data-type='calendar']").datepicker({
            format: "dd/mm/yyyy",
            weekStart: 0,
            language: "pt-BR",
        }).on('changeDate', function(e) {
            $(this).datepicker('hide');
        });
    }
    
    initAutocompletes();
    
    /*Autocompletes por unidade*/
    $("input[data-type='autocomplete-por-unidade']").each(function() {

        var href = $(this).attr('data-url'),
                target = $($(this).attr('data-target')),
                field = $(this);

        field.autocomplete({
            source: function(request, response) {
                
                var unidade = $("input[name='id_unidade']");
                
                if ( !isNaN( parseInt( unidade.val(), 10) )  ){
                    
                    $.ajax({
                        url: app_u + href,
                        dataType: 'jsonp',
                        data: {
                            query: request.term,
                            unidade : unidade.val()
                        },
                        success: function(data) {

                            if (data !== null) {
                                response($.map(data, function(item) {

                                    var result = {};

                                    if ( result.nome != '' ){
                                        result.label = item.descricao + ' ' + item.nome;
                                    }else{
                                        result.label = item.descricao;
                                    }
                                    result.value = item.descricao;
                                    result.id = item.id;

                                    return result;

                                }));
                            }
                        },
                        beforeSend: null,
                        complete: null,
                        error: null
                    });
                    
                }else{
                    AlertBallon.info('Primeiro selecione a Unidade');
                }
            },
            select: function(event, ui) {
                var data = ui.item;
                target.val(data.id);
                field.val(data.value);

                if ( field.parent().hasClass('input-group') ){
                    var inputGroup = field.parent();

                    if ( inputGroup.hasClass("input-group") ){
                        if ( inputGroup.find("span.input-group-addon i").hasClass('fa-warning') ){
                            inputGroup.find("span.input-group-addon i")
                                .removeClass("fa-warning text-yellow")
                                .addClass("fa-check text-green");

                            inputGroup.find("span.input-group-btn").remove();
                        }
                    }
                }
            },
            autoFocus: false,
            minLength: 2,
            open: function() {
            }
        });

        $(this).on('input', function(e) {
            target.val('-');

            var inputGroup = $(e.target).parent();

            if ( inputGroup.hasClass("input-group") ){
                if ( inputGroup.find("span.input-group-addon i").hasClass('fa-check') ){
                    inputGroup.find("span.input-group-addon i")
                        .removeClass("fa-check text-green")
                        .addClass("fa-warning text-yellow");
            }
            }

        });

    });
    
    /*Autocompletes por área*/
    $("input[data-type='autocomplete-por-area']").each(function() {

        var href = $(this).attr('data-url'),
                target = $($(this).attr('data-target')),
                field = $(this);

        field.autocomplete({
            source: function(request, response) {
                
                var area = $("input[name='id_area']");
                
                if ( !isNaN( parseInt( area.val(), 10) )  ){
                    
                    $.ajax({
                        url: app_u + href,
                        dataType: 'jsonp',
                        data: {
                            query: request.term,
                            area : area.val()
                        },
                        success: function(data) {

                            if (data !== null) {
                                response($.map(data, function(item) {

                                    var result = {};

                                    if ( typeof result.sigla != 'undefined' ){
                                        if ( result.sigla != '' ){
                                            result.label = item.descricao + ' (' + item.sigla + ')';
                                        }else{
                                            result.label = item.descricao;
                                        }
                                    }else{
                                        result.label = item.descricao;
                                    }
                                    result.value = item.descricao;
                                    result.id = item.id;

                                    return result;

                                }));
                            }
                        },
                        beforeSend: null,
                        complete: null,
                        error: null
                    });
                    
                }else{
                    AlertBallon.info('Primeiro selecione a Área');
                }
            },
            select: function(event, ui) {
                var data = ui.item;
                target.val(data.id);
                field.val(data.value);

                if ( field.parent().hasClass('input-group') ){
                    var inputGroup = field.parent();

                    if ( inputGroup.hasClass("input-group") ){
                        if ( inputGroup.find("span.input-group-addon i").hasClass('fa-warning') ){
                            inputGroup.find("span.input-group-addon i")
                                .removeClass("fa-warning text-yellow")
                                .addClass("fa-check text-green");

                            inputGroup.find("span.input-group-btn").remove();
                        }
                    }
                }
            },
            autoFocus: false,
            minLength: 2,
            open: function() {
            }
        });

        $(this).on('input', function(e) {
            target.val('-');

            var inputGroup = $(e.target).parent();

            if ( inputGroup.hasClass("input-group") ){
                if ( inputGroup.find("span.input-group-addon i").hasClass('fa-check') ){
                    inputGroup.find("span.input-group-addon i")
                        .removeClass("fa-check text-green")
                        .addClass("fa-warning text-yellow");
            }
            }

        });

    });
    
    initDataTables();
    
    $("input[role='data-table-filter']").on("input", function() {
        var oTable = $($(this).attr("target")).dataTable();
        oTable.fnFilter($(this).val());
    });

    /*
     * Countdown Session time left
     */

    
    $("body").on("mousedown", "span[role='show-password']", function(){
        var field = $(this).parent('div.input-group').find("input[type='password']");
        field.attr('type', 'text');
    });
    
    $("body").on("mouseup mouseleave", "span[role='show-password']", function(){
        var field = $(this).parent('div.input-group').find("input[type='text']");
        field.attr('type', 'password');
    });

    /*
     * Fim das configurações padrões
     */

    /**/

    $("input[role='search-systems']").on('input', function(e) {
        var query = $(this).val();

        $(".sistema-box").hide();
        $(".sistema-box:contains('" + query + "')").show();
    });

    $("button[role='sistema-info']").click(function() {
        showAlert($(this).attr('title'), $(this).attr('information'));
    });

    $("#upload-attachment").change(function() {
        fileName = $(this).val().split("\\");
        fileName = fileName[fileName.length - 1];
        $("#fake-upload-attachment, input[role='fake-upload-attachment']").val(fileName);
        if( $("[role='dialog']").length > 0 ){
            $("[role='dialog']").remove();
        }
    });
    
    /*Requisições para verificar se existem novas intenções de acesso*/
    if ( $("[role='menu-novos-acessos']").length > 0 ){
        window.setInterval(
            function(){

                $.ajax({
                    url      : app_u + 'novos-acessos/procurar-novos',
                    dataType : 'json',
                    success  : function(data){
                        if ( data.length > 0 ){
                            var txtQtd = $("[role='count-novos-acessos']").eq(0).text();
                            var qtd = isNaN( parseInt( txtQtd, 10 ) ) ? 0 : parseInt( txtQtd, 10 );

                            $("[role='count-novos-acessos']").text( qtd + data.length );

                            $.each(data, function(k, item){

                                var txt = item.usuario.shortName + ' solicita acesso ao sistema ' + item.sistema.nome;
                                var url = app_u + 'novos-acessos/' + item.hash;
                                var img = app_u + 'imagem-usuario/' + item.usuario.hash;

                                var li = $('<li> '+
                                           '    <a href="' + url + '"> '+
                                           '        <i class="fa fa-user-plus text-green"></i> '+
                                           '        <small>' + txt + '</small> '+
                                           '    </a> '+
                                           '</li>');

                                OpenNotification('Nova intenção de acesso', txt, img, url);

                                var ul = $("[role='menu-novos-acessos']");

                                if ( ul.find("ul").length > 0 ){                               
                                    li.prependTo( ul );
                                }else{
                                    ul.find("li:first").remove();

                                    ul.append("<li class='header'>Existe 1 intenção de acesso ao Sistemas</li>");

                                    ul.append('<li> '+
                                              '    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"> '+
                                              '        <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;"> '+
                                              $("<div>").append(li).html() +
                                              '        </ul> '+
                                              '        <div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 200px; background: rgb(0, 0, 0);"></div> '+
                                              '        <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div> '+
                                              '    </div> '+
                                              '</li>');

                                    ul.append("<li class='footer'><a href='" + app_u + "novos-acessos'>Visualizar todas</a></li>");

                                }


                            });



                        }
                    },
                    error    : function(){},
                    beforeSend    : function(){}
                });
            },
            delayRequests
        );

    }
    
    if ( $("[role='menu-novos-usuarios']").length > 0 ){
            
        window.setInterval(
            function(){    

                $.ajax({
                    url      : app_u + 'novos-usuarios/procurar-novos',
                    dataType : 'json',
                    success  : function(data){
                        if ( data.length > 0 ){
                            var txtQtd = $("[role='count-novos-usuarios']").eq(0).text();
                            var qtd = isNaN( parseInt( txtQtd, 10 ) ) ? 0 : parseInt( txtQtd, 10 );

                            $("[role='count-novos-usuarios']").text( qtd + data.length );

                            $.each(data, function(k, item){

                                var txt = item.shortName + ' solicita acesso ao Portal de Sistemas';
                                var url = app_u + 'novos-usuarios/' + item.hash;
                                var img = app_u + 'imagem-usuario/' + item.hash;

                                var li = $('<li> '+
                                           '    <a href="' + url + '"> '+
                                           '        <i class="fa fa-user-plus text-green"></i> '+
                                           '        <small>' + txt + '</small> '+
                                           '    </a> '+
                                           '</li>');

                                OpenNotification('Nova intenção de acesso', txt, img, url);

                                var ul = $("[role='menu-novos-usuarios']");

                                if ( ul.find("ul").length > 0 ){                               
                                    li.prependTo( ul );
                                }else{
                                    ul.find("li:first").remove();

                                    ul.append("<li class='header'>Existe 1 intenção de acesso ao Portal de Sistemas</li>");

                                    ul.append('<li> '+
                                              '    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"> '+
                                              '        <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;"> '+
                                              $("<div>").append(li).html() +
                                              '        </ul> '+
                                              '        <div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 200px; background: rgb(0, 0, 0);"></div> '+
                                              '        <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div> '+
                                              '    </div> '+
                                              '</li>');

                                    ul.append("<li class='footer'><a href='" + app_u + "novos-acessos'>Visualizar todas</a></li>");

                                }

                            });



                        }
                    },
                    error    : function(){},
                    beforeSend    : function(){}
                });

            },
            delayRequests
        );

    }
    
    /*Limpar os campos Área, Centro de Custo, Célula e Cargo
     *Sempre que a Unidade for alterada*/
    $("[data-name='unidade']:not([role='new'])").on("input", function(){
        $("[data-name='area'], [data-name='c_custo'],\n\
           [data-name='celula'], [data-name='cargo']").val("");
        
        $("[name='id_area'], [name='id_c_custo'], \n\
           [name='id_celula'], [name='id_cargo']").val("-");
    });
    
    /*Limpar os campos Área, Centro de Custo, Célula e Cargo
     *Sempre que a Unidade for alterada*/
    $("[data-name='area']:not([role='new']").on("input", function(){
        $("[data-name='c_custo'], [data-name='celula'], [data-name='cargo']").val("");
        $("[name='id_c_custo'], [name='id_celula'], [name='id_cargo']").val("-");
    });

});
