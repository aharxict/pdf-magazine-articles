(function ($) {
    var add_btn = $('#create-post');
    var inner_content = $('#inner_content');
    var latest_posts_container = $('.mh-home-2 .mh-posts-large-widget');
    var ajax_blog_content = $('#ajax-blog-content');
    var load_more = $('#load-more');
    var blog_load_more = $('#blog-load-more');
    var issue_number = $('#issue_number');
    var post_section = $('#post_section');
    var sort_date = $('#sort_date');
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
    issue_number.on("change", function () {
        console.log('changed');
        blog_ajax_update();
    });
    post_section.on("change", function () {
        console.log('changed');
        blog_ajax_update();
    });
    sort_date.on("change", function () {
        console.log('changed');
        blog_ajax_update();
    });
    function blog_ajax_update() {
        jQuery.ajax({
            url : getdata_form.ajax_url,
            type : 'post',
            data : {
                action :'getBlog',
                issue_number : issue_number.val(),
                post_section : post_section.val(),
                sort_date : sort_date.val(),
            },
            success : function( response ) {
                //alert(response);
                console.log('done');

                ajax_blog_content.empty();
                ajax_blog_content.append(response);
                console.log(ajax_blog_content);
                // latest_posts_container.append(response);
            }
        });
        return false;
    }

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
                count : latest_posts_container.children("article").length,
            },
            success : function( response ) {
                //alert(response);
                console.log(latest_posts_container);

                latest_posts_container.append(response);
            }
        });
        return false;
    });
    blog_load_more.on("click", function () {
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
                action :'getMoreBlogPosts',
                issue_number : issue_number.val(),
                post_section : post_section.val(),
                sort_date : sort_date.val(),
                // title : postTitle,
                //  content : postContent,
                count : ajax_blog_content.children("article").length,
            },
            success : function( response ) {
                //alert(response);
                console.log(ajax_blog_content);

                ajax_blog_content.append(response);
               // console.log('tester', tester);
            }
        });
        return false;
    });
})(jQuery);

// jQuery( document ).on( 'click', '#create-post', function() {
//
// });