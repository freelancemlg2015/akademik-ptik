<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function _update_trans_num($args) {
    $CI = & get_instance();
    $last_num = $args['last_num'];
    $last_month = $args['last_month'];
    $last_year = $args['last_year'];

    $CI->load->model('option_model');
    $month = $CI->option_model->get_options('', array('option' => $last_month))->row()->option_value;
    $year = $CI->option_model->get_options('', array('option' => $last_year))->row()->option_value;

    if (date('m') != $month) {
        $CI->option_model->update_option(array('option' => $last_month, 'option_value' => date('m')));
        $CI->option_model->update_option(array('option' => $last_num, 'option_value' => 0));
    }
    if (date('y') != $year)
        $CI->option_model->update_option(array('option' => $last_year, 'option_value' => date('y')));
}

function _get_trans_num($args) {
    $CI = & get_instance();
    $last_num = $args['last_num'];
    $last_month = $args['last_month'];
    $last_year = $args['last_year'];
    _update_trans_num($args);
    $CI->load->model('option_model');
    $next_number = $CI->option_model->get_options('', array('option' => $last_num))->row()->option_value + 1;
    $last_no = number_cast($next_number);
    $month = $CI->option_model->get_options('', array('option' => $last_month))->row()->option_value;
    $year = $CI->option_model->get_options('', array('option' => $last_year))->row()->option_value;

    $CI->option_model->update_option(array('option' => $last_num, 'option_value' => $next_number));

    return $year . $month . $last_no;
}

function number_cast($number) {
    if ($number < 9) {
        return '000' . $number;
    } else if ($number < 99) {
        return '00' . $number;
    } else if ($number < 999) {
        return '0' . $number;
    } else {
        return $number;
    }
}

?>