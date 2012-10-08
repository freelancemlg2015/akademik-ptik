<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function logged_info() {
    $CI =& get_instance();
    $date = new DateTime();
    $info->on = $date->format($CI->config->item('log_date_format'));
    $info->by = $CI->auth->logged_in();
    return $info;
}

?>