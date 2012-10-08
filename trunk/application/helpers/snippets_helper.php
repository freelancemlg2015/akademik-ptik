<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** -------------------------------------
 *  Required field indicator
 * --------------------------------------
 */
function required($blurb = '') {
    if ($blurb != '') {
        $blurb = lang($blurb);
    }

    return "<em class='required'>* </em>" . $blurb . "\n";
}

function layout_preview_links($data, $channel_id) {
    $EE = & get_instance();

    $layout_preview_links = "<p>" . $EE->lang->line('choose_layout_group_preview') . NBS . "<span class='notice'>" . $EE->lang->line('layout_save_warning') . "</span></p>";
    $layout_preview_links .= "<ul class='bullets'>";
    foreach ($data->result() as $group) {
        $layout_preview_links .= '<li><a href=\"' . BASE . AMP . 'C=content_publish' . AMP . "M=entry_form" . AMP . "channel_id=" . $channel_id . AMP . "layout_preview=" . $group->group_id . '\">' . $group->group_title . "</a></li>";
    }
    $layout_preview_links .= "</ul>";

    return $layout_preview_links;
}

//  ini standar format pada saat akan disave ke database
function dateformat($date, $format = 'Y-m-d') {
    return $date != '' ? date($format, strtotime($date)) : NULL;
}

//page pagination style
function default_pagination_btn() {
    $config['full_tag_open'] = '<ul>';
    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li class="first">';
    $config['first_tag_close'] = '</li>';

    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li class="last">';
    $config['last_tag_close'] = '</li>';

    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $config['next_link'] = 'Next &rarr;';
    $config['next_tag_open'] = '<li class="next">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '&larr; Previous';
    $config['prev_tag_open'] = '<li class="prev">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';

    return $config;
}

/* End of file snippets_helper.php */
/* Location: ./system/expressionengine/helpers/snippets_helper.php */