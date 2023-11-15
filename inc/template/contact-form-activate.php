<h1>Sunset Contact Form Options</h1>
<?php settings_errors();
?>
<?php 
	// $description = esc_attr( get_option( 'user_description' ) );
	
?>

<form method="post" action="options.php">
    <?php
    settings_fields('sunset-contact-form-settings');
    do_settings_sections('nimra_sunset_contact_setting');
    submit_button();
    ?>

</form>