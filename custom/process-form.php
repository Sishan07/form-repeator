<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

global $wpdb;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['label']) && isset($_POST['inputType'])) {
        $labels = $_POST['label'];
        $inputTypes = $_POST['inputType'];

        foreach ($labels as $key => $label) {
            if (isset($inputTypes[$key]) && !empty($label) && !empty($inputTypes[$key])) {
                $label = $wpdb->esc_like($label);
                $inputType = $wpdb->esc_like($inputTypes[$key]);

                $wpdb->insert(
                    'users',
                    array('label' => $label, 'input_type' => $inputType),
                    array('%s', '%s')
                );
            }
        }

        echo "Register Successfully";
    } else {
        echo "No input data received";
    }
}
?>
