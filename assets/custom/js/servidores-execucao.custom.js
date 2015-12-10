$(function() {
    
    /*Funções responsável por ativar o grupo*/
    $("body").on("click", '[role="excluir-servidor"]', function(e) {

        e.stopPropagation();

        var field   = $(this),
            btnGroup = $(this).parents('div.btn-group'),
            nome     = field.parents('tr').find('td').eq(0).text(),
            id       = btnGroup.attr('data-id');
            
        showConfirm(
            "Atenção",
            "Deseja realmente excluir o servidor de execução <strong>"+nome+"</strong>? Os agendamentos relacionados a este servidor ficarão inativos. Confirma esta operação?",
            function() {
                
                $.ajax({
                    type : 'POST',
                    url  : app_u + 'servidores-execucao/excluir',
                    dataType: 'json',
                    data : {
                        'hash' : id
                    },
                    success : function(data){
                        
                        if (typeof data.success !== "undefined") {
                            AlertBallon.success(data.success);
                            
                            var oTable = $("table#data-table-servidores").dataTable();
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
    $('[role="ajax-form-servidor"]').submit(function(e) {
        e.preventDefault();

        var form = $(this);

        ajaxSubmit(
            $(this),
            function() {}
        );

        return false;
    });

});