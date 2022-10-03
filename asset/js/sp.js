jQuery(document).ready(function($){ 
    $("#btnSubmit").on("click",function(){
        var hidden_value = $("#post_id").val();
        jQuery.ajax({
            url:   ajax_object.ajaxurl,
            type: 'POST',
            data: {  
                action: 'ajax_callback_bc_api',  
                hidden_value: hidden_value 
            },
            success: function (data) {
                console.log("Succuess");
                console.log(data);
             }
        });
    });
});



