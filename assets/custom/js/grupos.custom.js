$(function() {
    
    /*Funções responsável por inativar o grupo*/
    $("body").on("click", '[role="inativar-grupo"]', function(e) {

        e.stopPropagation();

        var field   = $(this),
            btnGroup = $(this).parents('div.btn-group'),
            label    = field.parents('tr').find('td').eq(2),
            nome     = field.parents('tr').find('td').eq(0).text(),
            id       = btnGroup.attr('data-id');
            
        showConfirm(
            "Atenção",
            "Deseja realmente inativar grupo <strong>"+nome+"</strong>? Os agendamentos relacionados a este grupo não serão mais executados. Confirma esta operação?",
            function() {
                
                $.ajax({
                    type : 'POST',
                    url  : app_u + 'grupos/inativar',
                    dataType: 'json',
                    data : {
                        'hash' : id
                    },
                    success : function(data){
                        
                        if (typeof data.success !== "undefined") {
                            AlertBallon.success(data.success);
                            
                            btnGroup.find('button').removeClass('btn-primary').addClass('btn-danger');
                            var li = btnGroup.find('a[role="inativar-grupo"]').parent('li');
                                li.html('<a href="javscript:;" role="ativar-grupo"><i class="glyphicon glyphicon-ok"></i> Ativar</a>');
                                
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
    $("body").on("click", '[role="ativar-grupo"]', function(e) {

        e.stopPropagation();

        var field   = $(this),
            btnGroup = $(this).parents('div.btn-group'),
            label    = field.parents('tr').find('td').eq(2),
            nome     = field.parents('tr').find('td').eq(0).text(),
            id       = btnGroup.attr('data-id');
            
        showConfirm(
            "Atenção",
            "Deseja realmente ativar o grupo <strong>"+nome+"</strong>? Os agendamentos relacionados a este grupo passarão a ser executados novamente. Confirma esta operação?",
            function() {
                
                $.ajax({
                    type : 'POST',
                    url  : app_u + 'grupos/ativar',
                    dataType: 'json',
                    data : {
                        'hash' : id
                    },
                    success : function(data){
                        
                        if (typeof data.success !== "undefined") {
                            AlertBallon.success(data.success);
                            
                            btnGroup.find('button').removeClass('btn-danger').addClass('btn-primary');
                            var li = btnGroup.find('a[role="ativar-grupo"]').parent('li');
                                li.html('<a href="javscript:;" role="inativar-grupo"><i class="glyphicon glyphicon-remove"></i> Inativar</a>');
                                
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
    $("body").on("click", '[role="excluir-grupo"]', function(e) {

        e.stopPropagation();

        var field   = $(this),
            btnGroup = $(this).parents('div.btn-group'),
            nome     = field.parents('tr').find('td').eq(0).text(),
            id       = btnGroup.attr('data-id');
            
        showConfirm(
            "Atenção",
            "Deseja realmente excluir o grupo <strong>"+nome+"</strong>? Os agendamentos relacionados a este grupo não serão excluídos. Confirma esta operação?",
            function() {
                
                $.ajax({
                    type : 'POST',
                    url  : app_u + 'grupos/excluir',
                    dataType: 'json',
                    data : {
                        'hash' : id
                    },
                    success : function(data){
                        
                        if (typeof data.success !== "undefined") {
                            AlertBallon.success(data.success);
                            
                            var oTable = $("table#data-table-grupos").dataTable();
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

    /*Funções responsável por enviar o formulário por ajax*/
    $('[role="ajax-form-grupo"]').submit(function(e) {
        e.preventDefault();

        var form = $(this);

        ajaxSubmit(
            $(this),
            function() {
                if (form.find("input[name=id]").val() == '') {
                    form.find(":input").val('');
                }
            }
        );

        return false;
    });

});