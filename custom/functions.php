<?php
function custom_theme_styles() {
    wp_enqueue_style('custom-style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'custom_theme_styles');

add_action('wp_ajax_delete_data', 'delete_data');
add_action('wp_ajax_nopriv_delete_data', 'delete_data');

function delete_data() {
    global $wpdb;

    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        $wpdb->delete('users', array('id' => $id));
    }

    wp_die();
}

?>
