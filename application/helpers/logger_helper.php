<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @desc Simple function to check if current page is equal to nav list element.
 *       This case return "active" as class name for the list element.
 * @param String $pageID
 * @param String $linkID
 * @return String/Null
 */
function logged_info() {
    $CI = & get_instance();
    $date = new DateTime();
    $info->on = $date->format($CI->config->item('log_date_format'));
    $info->by = $CI->auth->logged_in();
    return $info;
}

function save_log($log_data) {
    $CI = & get_instance();
    $CI->load->model('crud');
    $CI->crud->use_table('logs');
    //unset unused data
    unset($log_data['log_value']['created_by']);
    unset($log_data['log_value']['created_on']);
    unset($log_data['log_value']['modified_by']);
    unset($log_data['log_value']['modified_on']);
    
    //serialize, save as array
    $log_data['log_old_value'] = !empty($log_data['log_old_value'])?serialize($log_data['log_old_value']):'';
    $log_data['log_value'] = serialize($log_data['log_value']);
    
    $log_data = array_merge($log_data, array(
        'updated_by' => logged_info()->by,
        'updated_on' => logged_info()->on));
    $CI->crud->create($log_data);
}

?>