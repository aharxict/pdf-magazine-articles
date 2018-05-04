(function ($) {
    var add_btn = $('#create-post');
    var inner_content = $('#inner_content');
    var latest_posts_container = $('.mh-home-2 .mh-posts-large-widget');
    var load_more =$('#load-more');
    var
    // add_btn.on("click", function () {
    //     var postTitle = jQuery('#post-title').val();
    //     var postContent = jQuery('#post-content').val();
    //     jQuery(document).ajaxStart(function(){
    //         jQuery("#wait").css("display", "block");
    //     });
    //     jQuery(document).ajaxComplete(function(){
    //         jQuery("#wait").css("display", "none");
    //         jQuery('#post-title').val('');
    //         jQuery('#post-content').val('');
    //     });
    //     jQuery.ajax({
    //         url : getdata_form.ajax_url,
    //         type : 'post',
    //         data : {
    //             action :'getFormTest',
    //             title : postTitle,
    //             content : postContent,
    //             count : inner_content.children().length,
    //         },
    //         success : function( response ) {
    //             //alert(response);
    //             console.log(inner_content);
    //
    //             inner_content.append(response);
    //         }
    //     });
    //     return false;
    // });
    load_more.on("click", function () {
        jQuery(document).ajaxStart(function(){
           // jQuery("#wait").css("display", "block");
        });
        jQuery(document).ajaxComplete(function(){
          //  jQuery("#wait").css("display", "none");
           // jQuery('#post-title').val('');
           // jQuery('#post-content').val('');
        });
        jQuery.ajax({
            url : getdata_form.ajax_url,
            type : 'post',
            data : {
                action :'getFormTest',
               // title : postTitle,
              //  content : postContent,
                count : latest_posts_container.children().length,
            },
            success : function( response ) {
                //alert(response);
                console.log(latest_posts_container);

                latest_posts_container.append(response);
            }
        });
        return false;
    });
})(jQuery);

// jQuery( document ).on( 'click', '#create-post', function() {
//
// });