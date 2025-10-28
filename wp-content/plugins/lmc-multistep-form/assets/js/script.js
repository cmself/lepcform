jQuery(document).ready(function($){
    $('#form-lmc-multistep-form').submit(function() {
        $('#step_loader').show();
        $('#step_content').hide();
        return true;
    });

    //$("#form-lmc-multistep-form").validate();
});
