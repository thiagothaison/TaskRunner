$(function() {
    
    var check_server_status = function(){
        $.ajax({
            url      : app_u + 'servidor-node/status',
            dataType : 'json',
            success  : function(result){
                if ( result ){
                    $('[role="server-status"]')
                        .removeClass('text-red')
                        .addClass('text-green')
                        .text('online');
                    $('[role="start-server"]').hide();
                    $('[role="stop-server"]').show();
                }else{
                    $('[role="server-status"]')
                        .removeClass('text-green')
                        .addClass('text-red')
                        .text('offline');
                    $('[role="start-server"]').show();
                    $('[role="stop-server"]').hide();
                }
            },
            beforeSend : null
        });
    };
    
    /*Funções responsável por enviar o formulário por ajax*/
    $('[role="ajax-form-servidor"]').submit(function(e) {
        e.preventDefault();

        ajaxSubmit(
            $(this),
            function() {}
        );

        return false;
    });
    
    /*Iniciar servidor*/
    $('body').on('click','[role="start-server"]', function(){
                
        $.ajax({
            url        : app_u + 'servidor-node/iniciar',
            success    : function(){
                $('[role="server-status"]')
                    .removeClass('text-red')
                    .addClass('text-green')
                    .text('online');
                $('[role="start-server"]').hide();
                $('[role="stop-server"]').show();
            }
        });
    });
    
    /*Iniciar servidor*/
    $('body').on('click','[role="stop-server"]', function(){
        
        $.ajax({
            url        : app_u + 'servidor-node/parar',
            success    : function(){
                $('[role="server-status"]')
                    .removeClass('text-green')
                    .addClass('text-red')
                    .text('offline');
                $('[role="start-server"]').show();
                $('[role="stop-server"]').hide();
            }
        });
    });
    
    /*Verificar o status do servidor*/
    if ( $('[role="server-status"]').length > 0 ){
        
        check_server_status();
        
        window.setInterval(function(){
            check_server_status();
        }, 2000);
    }

});