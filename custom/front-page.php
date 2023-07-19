<?php get_header(); ?>

<?php
global $wpdb;

$query = "SELECT * FROM users";
$result = $wpdb->get_results($query);

foreach ($result as $row) {
    $id = $row->id;
    $label = $row->label;
    $inputType = $row->input_type;
?>
    <div class="row" data-id="<?php echo $id; ?>">
        <input type="text" name="label[]" value="<?php echo $label; ?>">
        <select name="inputType[]">
            <option value="text" <?php if ($inputType === 'text') echo 'selected'; ?>>Text</option>
            <option value="number" <?php if ($inputType === 'number') echo 'selected'; ?>>Number</option>
            <option value="email" <?php if ($inputType === 'email') echo 'selected'; ?>>Email</option>
        </select>
        <button onclick="deleteFile('<?php echo $id; ?>')" class="delete">Delete</button>
    </div>
<?php
}
?>

<form action="<?php echo esc_url(get_template_directory_uri() . '/process-form.php'); ?>" method="POST" id="frmBox">
    <div id="repeater-container"></div>
    <div id="button-container">
        <button type="button" id="add-btn">Add Row</button>
        <input type="submit" name="submit" id="submit" value="Submit">
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
jQuery(document).ready(function($) {
    // Add button click event
    $('#add-btn').click(function() {
        var newRow = '<div class="row">' +
            '<input type="text" name="label[]" placeholder="Label">' +
            '<select name="inputType[]">' +
            '<option value="text">Text</option>' +
            '<option value="number">Number</option>' +
            '<option value="email">Email</option>' +
            '</select>' +
            '<button class="delete">Delete</button>' +
            '</div>';
        $('#repeater-container').append(newRow);
    });

    $(document).on('click', '.delete', function() {
        var row = $(this).closest('.row');
        var id = row.data('id');
        deleteFile(id, row);
    });

    $(document).on('click', '#submit', function(event) {
        event.preventDefault();
        var rows = $('.row');
        rows.each(function() {
            var id = $(this).data('id');
            updateFile(id);
        });
        formSubmit();
    });

    function formSubmit() {
        var form = $('#frmBox');
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                $('#success').html(response);
                $('#repeater-container').empty();
                form[0].reset();
                location.reload();
            }
        });
    }

    function deleteFile(id, row) {
        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            data: {
                action: 'delete_data',
                id: id
            },
            success: function(response) {
                row.remove();
            }
        });
    }

    function updateFile(id) {
        var row = $('.row[data-id="' + id + '"]');
        var label = row.find('input[name="label[]"]').val();
        var inputType = row.find('select[name="inputType[]"]').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo get_template_directory_uri() . "/update.php"; ?>',
            data: {
                id: id,
                label: label,
                inputType: inputType
            },
            success: function(response) {
                console.log(response);
            }
        });
    }
});


</script>


<?php get_footer(); ?>
