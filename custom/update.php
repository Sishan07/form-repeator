<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

global $wpdb;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $label = $_POST['label'];
    $inputType = $_POST['inputType'];

    $wpdb->update(
        'users',
        array('label' => $label, 'input_type' => $inputType),
        array('id' => $id),
        array('%s', '%s'),
        array('%d')
    );

    echo "Data updated successfully";
}
?>
