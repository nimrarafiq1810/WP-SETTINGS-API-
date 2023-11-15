<h1>Sunset Theme Support Options</h1>
<?php settings_errors();
?>
<?php 
	// $description = esc_attr( get_option( 'user_description' ) );
	
?>

<form method="post" action="options.php">
    <?php
    settings_fields('sunset-theme-settings');
    do_settings_sections('nimra_sunset_theme_options');
    submit_button();
    ?>

</form>