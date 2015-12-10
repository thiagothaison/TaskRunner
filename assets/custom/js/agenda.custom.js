$(function() {

    if ( typeof $().select2 == "function" ){
        
        $("select[role='select-box']").each(function() {
            $(this).removeClass('form-control');
            $(this).select2(
                {
                    language: "pt-BR", 
                    placeholder: "Selecione",
                    multiple : false,
                }
            );
        });

        $("select[role='tag-select-box']").each(function() {
            $(this).removeClass('form-control');
            $(this).select2(
                {
                    language: "pt-BR", 
                    multiple : true
                }
            ).on("select2:select", function(e) {
                data = e.params.data;

                if ( isNaN( data.id ) ){
                    $(e.target).select2("val", "");
                    $(e.target).select2("val", data.id);
                }else{

                    $.each($(e.target).val(), function(k,v){

                        if ( isNaN( v ) ){
                            $(e.target).select2("val", data.id);
                        }

                    });

                }

            }).on("change", function(){

                cron = new Array();

                cron[0] = $('select[data-name="second"]').val();
                cron[1] = $('select[data-name="minute"]').val();
                cron[2] = $('select[data-name="hour"]').val();
                cron[3] = $('select[data-name="day"]').val();
                cron[4] = $('select[data-name="month"]').val();
                cron[5] = $('select[data-name="weekday"]').val();

                $('[name="cron"]').val( cron.join(" ") );


            });
        });

        $("select[name='tipo']").select2().on('change', function(){
            if ( $(this).val() == 1 ){
                $("select[name='id_servidor_execucao']").prop("disabled", true);
            }else{
                $("select[name='id_servidor_execucao']").prop("disabled", false);
            }

            $(this).find("option[value='']").remove();

        });
        
    }

    /*****/
    
    /*Funções responsável por inativar o grupo*/
    $("body").on("click", '[role="inativar-agendamento"]', function(e) {

        e.stopPropagation();

        var field   = $(this),
            btnGroup = $(this).parents('div.btn-group'),
            label    = field.parents('tr').find('td').eq(2),
            nome     = field.parents('tr').find('td').eq(1).text() + " - " + field.parents('tr').find('td').eq(2).text(),
            id       = btnGroup.attr('data-id');
            
        showConfirm(
            "Atenção",
            "Deseja realmente inativar o agendamento <strong>"+nome+"</strong>? Se inativá-lo ele não será mais executado. Confirma esta operação?",
            function() {
                
                $.ajax({
                    type : 'POST',
                    url  : app_u + 'agendamentos/inativar',
                    dataType: 'json',
                    data : {
                        'hash' : id
                    },
                    success : function(data){
                        
                        if (typeof data.success !== "undefined") {
                            AlertBallon.success(data.success);
                            
                            btnGroup.find('button').removeClass('btn-primary').addClass('btn-danger');
                            var li = btnGroup.find('a[role="inativar-agendamento"]').parent('li');
                                li.html('<a href="javscript:;" role="ativar-agendamento"><i class="glyphicon glyphicon-ok"></i> Ativar</a>');
                                
                            label.text('Não');
                            
                        }else if (typeof data.error !== "undefined") {
                            AlertBallon.error(data.error, "Opss...");
                        } else {
                            AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                        }
                    }
                });
            },
            null
        );

        return false;

    });

    /*Funções responsável por ativar o grupo*/
    $("body").on("click", '[role="ativar-agendamento"]', function(e) {

        e.stopPropagation();

        var field   = $(this),
            btnGroup = $(this).parents('div.btn-group'),
            label    = field.parents('tr').find('td').eq(2),
            nome     = field.parents('tr').find('td').eq(1).text() + " - " + field.parents('tr').find('td').eq(2).text(),
            id       = btnGroup.attr('data-id');
            
        showConfirm(
            "Atenção",
            "Deseja realmente ativar o agendamento <strong>"+nome+"</strong>? Confirma esta operação?",
            function() {
                
                $.ajax({
                    type : 'POST',
                    url  : app_u + 'agendamentos/ativar',
                    dataType: 'json',
                    data : {
                        'hash' : id
                    },
                    success : function(data){
                        
                        if (typeof data.success !== "undefined") {
                            AlertBallon.success(data.success);
                            
                            btnGroup.find('button').removeClass('btn-danger').addClass('btn-primary');
                            var li = btnGroup.find('a[role="ativar-agendamento"]').parent('li');
                                li.html('<a href="javscript:;" role="inativar-agendamento"><i class="glyphicon glyphicon-remove"></i> Inativar</a>');
                                
                            label.text('Sim');
                            
                        }else if (typeof data.error !== "undefined") {
                            AlertBallon.error(data.error, "Opss...");
                        } else {
                            AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                        }
                    }
                });
            },
            null
        );

        return false;

    });

    /*Funções responsável por ativar o grupo*/
    $("body").on("click", '[role="excluir-agendamento"]', function(e) {

        e.stopPropagation();

        var field   = $(this),
            btnGroup = $(this).parents('div.btn-group'),
            nome     = field.parents('tr').find('td').eq(1).text() + " - " + field.parents('tr').find('td').eq(2).text(),
            id       = btnGroup.attr('data-id');
            
        showConfirm(
            "Atenção",
            "Deseja realmente excluir o agendamento <strong>"+nome+"</strong>? Essa operação não poderá ser desfeita. Confirma esta operação?",
            function() {
                
                $.ajax({
                    type : 'POST',
                    url  : app_u + 'agendamentos/excluir',
                    dataType: 'json',
                    data : {
                        'hash' : id
                    },
                    success : function(data){
                        
                        if (typeof data.success !== "undefined") {
                            AlertBallon.success(data.success);
                            
                            var oTable = $("table#data-table-agendamentos").dataTable();
                            var index  = $("<div></div>").append( oTable.fnGetNodes() ).find("tr[data-id=" + id + "]").index();
                                oTable.fnDeleteRow( index );
                                
                        }else if (typeof data.error !== "undefined") {
                            AlertBallon.error(data.error, "Opss...");
                        } else {
                            AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                        }
                    }
                });
            },
            null
        );

        return false;

    });

    
    /*****/
    
    /*Funções responsável por enviar o formulário por ajax*/
    $('[role="ajax-form-agenda"]').submit(function(e) {
        e.preventDefault();

        var form = $(this);

        ajaxSubmit(
                $(this),
                function() {
                }
        );

        return false;
    });
    
    /*Função responsável por executar manualmente um agendamento*/
    $('[role="exec-agendamento"]').click(function(){
        
        var id = $(this).attr('data-id');
        
        $.ajax({
            url: app_u + 'agendamentos/executar',
            type: 'POST',
            async: false,
            data: {
                hash: id
            },
            success: function(data) {
                        
                if (typeof data.success !== "undefined") {
                    AlertBallon.success(data.success);
                }else if (typeof data.error !== "undefined") {
                    AlertBallon.error(data.error, "Opss...");
                } else {
                    AlertBallon.error("Ocorreu um erro durante a requisição. Tente novamente.", null);
                }
            }
        });
    });

});