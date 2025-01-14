<?php

function check_user_role($required_role)
{
    $ci = get_instance();
    $role_id = $ci->session->userdata('role_id');
    if ($role_id != $required_role) {
        redirect('auth/blocked');
    }
}

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
