<?php 

    if ( $message = $this->session->flashdata('message') ){

        if ( is_array($message) ){
            if (array_key_exists("error", $message) ){
                $this->view('elements/messages/error', $message); 
            }
            if (array_key_exists("info", $message) ){
                $this->view('elements/messages/information', $message); 
            }
            if (array_key_exists("success", $message) ){
                $this->view('elements/messages/success', $message); 
            }
            if (array_key_exists("warn", $message) ){
                $this->view('elements/messages/warning', $message); 
            }
        }

?>
            
    <script>
        jQuery(function() {
            jQuery("div.alert").each(function() {

                alerta = jQuery(this);

                window.setTimeout(function() {
                    alerta.fadeOut("fast", function() {
                        alerta.find('button').trigger('click');
                    });
                }, 20000);
            });
        });
    </script>
    
<?php } ?>
