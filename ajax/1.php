<?php

class Test{
    public function __construct()
    {
        add_action('wp_ajax_nopriv_getFormTest', array($this, 'getFormTest'));
        add_action('wp_ajax_getFormTest', array($this, 'getFormTest'));
        add_action('wp_enqueue_scripts', array($this, 'addJS'));
    }
    function addJS(){
        wp_enqueue_script('getForm', plugins_url('/js/getFormData.js', _FILE_), array('jquery'), NULL, true);
        wp_localize_script('getForm', 'getdata_form', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
    function getFormTest(){
        echo strtoupper($_POST['cat']);
        wp_die();
    }
}
new Test;