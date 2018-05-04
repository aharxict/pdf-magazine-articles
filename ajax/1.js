jQuery( document ).on( 'click', '#create-post', function() {
    var postTitle = jQuery('#post-title').val();
    var postContent = jQuery('#post-content').val();
    jQuery(document).ajaxStart(function(){
        jQuery("#wait").css("display", "block");
    });
    jQuery(document).ajaxComplete(function(){
        jQuery("#wait").css("display", "none");
        jQuery('#post-title').val('');
        jQuery('#post-content').val('');
    });
    jQuery.ajax({
        url : getdata_form.ajax_url,
        type : 'post',
        data : {
            action :'getFormTest',
            title : postTitle,
            content : postContent,
        },
        success : function( response ) {
            alert(response);
        }
    });
    return false;
});