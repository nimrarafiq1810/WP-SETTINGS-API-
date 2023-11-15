<?php
function sunset_add_admin_page()
{
    add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'nimra_sunset', 'sunset_theme_create_page', get_template_directory_uri() . '/img/sunset-icon.png', 110 );
    add_submenu_page( 'nimra_sunset', 'Sunset Theme Options', 'Sidebar', 'manage_options', 'nimra_sunset', 'sunset_theme_create_page' );
	add_submenu_page( 'nimra_sunset', 'Sunset CSS Options', 'Custom CSS', 'manage_options', 'nimra_sunset_css', 'sunset_theme_settings_page');
    add_submenu_page( 'nimra_sunset', 'Sunset Theme Options', 'Theme Options', 'manage_options', 'nimra_sunset_theme_options', 'sunset_theme_support_page');
	add_submenu_page( 'nimra_sunset', 'Conatct Form Options', 'Contact Form', 'manage_options', 'nimra_sunset_contact_setting', 'sunset_contact_form_page');
    add_action('admin_init', 'sunset_custom_settings');
}

add_action('admin_menu','sunset_add_admin_page');

function sunset_theme_create_page() {
	require_once(get_template_directory(). '/inc/template/sunset-admin.php');
}
function sunset_theme_settings_page(){

	require_once(get_template_directory(). '/inc/template/custom_css.php');
}
function sunset_theme_support_page(){
    require_once(get_template_directory(). '/inc/template/sunset-theme-support.php');

}
function sunset_contact_form_page(){
	require_once(get_template_directory(). '/inc/template/contact-form-activate.php');
}
 
function sunset_custom_settings(){
    //Sidebar subpage
    register_setting( 'sunset-settings-group', 'profile_picture' );
    register_setting( 'sunset-settings-group', 'first_name' );
    register_setting( 'sunset-settings-group', 'last_name' );
    register_setting( 'sunset-settings-group', 'twitter_handler', 'sunset_sanitize_twitter_handler' );
	register_setting( 'sunset-settings-group', 'facebook_handler' );
	register_setting( 'sunset-settings-group', 'gplus_handler' );
    add_settings_section( 'sunset-sidebar-options', 'Sidebar Option', 'sunset_sidebar_options', 'nimra_sunset');
    add_settings_field( 'sidebar-picture', 'Profile Picture', 'sunset_sidebar_profile', 'nimra_sunset', 'sunset-sidebar-options');
    add_settings_field( 'sidebar-name', 'Full Name', 'sunset_sidebar_name', 'nimra_sunset', 'sunset-sidebar-options');
    add_settings_field( 'sidebar-twitter', 'Twitter handler', 'sunset_sidebar_twitter', 'nimra_sunset', 'sunset-sidebar-options');
	add_settings_field( 'sidebar-facebook', 'Facebook handler', 'sunset_sidebar_facebook', 'nimra_sunset', 'sunset-sidebar-options');
	add_settings_field( 'sidebar-gplus', 'Google+ handler', 'sunset_sidebar_gplus', 'nimra_sunset', 'sunset-sidebar-options');

	//Theme Options Subpage
	register_setting( 'sunset-theme-settings', 'post_formats','sunset_post_formats_callback' );
	register_setting( 'sunset-theme-settings', 'custom_header');
	register_setting( 'sunset-theme-settings', 'custom_background');
	add_settings_section( 'sunset_theme_options_settings', 'Theme Options', 'sunset_theme_options', 'nimra_sunset_theme_options');
	add_settings_field( 'post-formats', 'Post Formats', 'sunset_theme_options_postformats', 'nimra_sunset_theme_options', 'sunset_theme_options_settings');
	add_settings_field( 'custom_header', 'Custom Header', 'sunset_theme_custom_header', 'nimra_sunset_theme_options', 'sunset_theme_options_settings');
	add_settings_field( 'custom_background', 'Custom Background', 'sunset_theme_custom_background', 'nimra_sunset_theme_options', 'sunset_theme_options_settings');
	

	//Contact Form Options
	register_setting( 'sunset-contact-form-settings', 'activate_contact' );
	add_settings_section( 'sunset_conatct_form_setting_section', 'Contact Form Setting', 'sunset_contact_form_section', 'nimra_sunset_contact_setting');
	add_settings_field( 'activate_contact', 'Activate Contact Form', 'sunset_contact_form_activate', 'nimra_sunset_contact_setting', 'sunset_conatct_form_setting_section');

	//Custom CSS Options
	register_setting( 'sunset_custom_css_settings', 'customized_css' );
	add_settings_section( 'sunset_custom_css_setting_section', 'Custom CSS', 'sunset_custom_css_section', 'nimra_sunset_css');
	add_settings_field( 'custom_css', 'Insert Custom CSS', 'sunset_insert_custom_css_activate', 'nimra_sunset_css', 'sunset_custom_css_setting_section');
}

function sunset_sidebar_options()
{
    echo 'Blah Blah Blah Blah';
}

function sunset_sidebar_profile() {
	$picture = esc_attr( get_option( 'profile_picture' ) );
	echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button"><input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'" />';
}

function sunset_sidebar_name(){
    $firstName = esc_attr( get_option( 'first_name' ) );
	$lastName = esc_attr( get_option( 'last_name' ) );
	echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name" /> <input type="text" name="last_name" value="'.$lastName.'" placeholder="Last Name" />';
}
function sunset_sidebar_twitter() {
	$twitter = esc_attr( get_option( 'twitter_handler' ) );
	echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter handler" /><p class="description">Input your Twitter username without the @ character.</p>';
}
function sunset_sidebar_facebook() {
	$facebook = esc_attr( get_option( 'facebook_handler' ) );
	echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook handler" />';
}
function sunset_sidebar_gplus() {
	$gplus = esc_attr( get_option( 'gplus_handler' ) );
	echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Google+ handler" />';
}

function sunset_sanitize_twitter_handler( $input ){
	$output = sanitize_text_field( $input );
	$output = str_replace('@', '', $output);
	return $output;
}

function sunset_post_formats_callback($input)
{
	return $input;

}

function sunset_theme_options()
{
	echo 'Activate and Deactivate your settings';
}

function sunset_theme_options_postformats()
{
	$formats= array('aside','image','gallery','video','status','link');
	$output='';
	 $options = get_option( 'post_formats' );
	foreach($formats as $format){
		$checked = ( $options[$format] ?? null ) == 1 ? 'checked' : '';
		$output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.'/>'.$format.'</label></br>';
	}
	echo $output;
}

function sunset_theme_custom_header(){
	$output='';
	$options = get_option( 'custom_header' );
	$checked = ( $options ?? null ) == 1 ? 'checked' : '';
	$output .= '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.'/>Activate Custom Header</label></br>';
	echo $output;
}

function sunset_theme_custom_background(){
	$output='';
	$options = get_option( 'custom_background' );
	$checked = ( $options ?? null ) == 1 ? 'checked' : '';
	$output .= '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.'/>Activate Custom Background</label></br>';
	echo $output;
}

function sunset_contact_form_section()
{
	echo 'Blah Blah';
}

function sunset_contact_form_activate()
{
	$options = get_option( 'activate_contact' );
	$checked = ( @$options == 1 ? 'checked' : '' );
	echo '<label><input type="checkbox" id="activate_contact" name="activate_contact" value="1" '.$checked.' /></label>';
}

function sunset_custom_css_section()
{
	echo 'Customize Theme with your own CSS';
}

function sunset_insert_custom_css_activate()
{
	$css= get_option('customized_css');
	$css = (empty($css) ? '/* Sunset Custom Theme CSS */' : $css);
	echo '<div id="customCss">'.$css.'</div> <textarea id="customized_css" name="customized_css" style="display:none;visibility:hidden;">'.$css.'</textarea>';
}

//////// WITH OOP METHOD ///////////
// class SunsetThemeOptions {

//     public function __construct() {
//         add_action('admin_menu', array($this, 'addAdminPage'));
//         add_action('admin_init', array($this, 'initializeSettings'));
//     }

//     public function addAdminPage() {
//         add_menu_page(
//             'Sunset Theme Options',
//             'Sunset',
//             'manage_options',
//             'nimra_sunset',
//             array($this, 'renderAdminPage'),
//             get_template_directory_uri() . '/img/sunset-icon.png',
//             110
//         );

//         add_submenu_page(
//             'nimra_sunset',
//             'Sunset Theme Options',
//             'Sidebar',
//             'manage_options',
//             'nimra_sunset',
//             array($this, 'renderAdminPage')
//         );

//         add_submenu_page(
//             'nimra_sunset',
//             'Sunset CSS Options',
//             'Custom CSS',
//             'manage_options',
//             'nimra_sunset_css',
//             array($this, 'renderCustomCssPage')
//         );

//         // Add other submenu pages here using add_submenu_page()
//     }

//     public function initializeSettings() {
//         // Register settings and add sections/fields here
//         $this->registerSidebarSettings();
//         $this->registerThemeSettings();
//         $this->registerContactFormSettings();
//         $this->registerCustomCssSettings();
//     }

//     private function registerSidebarSettings() {
//         register_setting('sunset-settings-group', 'profile_picture');
//         register_setting('sunset-settings-group', 'first_name');
//         // Add other sidebar settings here

//         add_settings_section('sunset-sidebar-options', 'Sidebar Option', array($this, 'renderSidebarSection'), 'nimra_sunset');
//         add_settings_field('sidebar-picture', 'Profile Picture', array($this, 'renderSidebarProfileField'), 'nimra_sunset', 'sunset-sidebar-options');
//         // Add other sidebar fields here
//     }

//     private function registerThemeSettings() {
//         register_setting('sunset-theme-settings', 'post_formats', array($this, 'sanitizePostFormats'));
//         register_setting('sunset-theme-settings', 'custom_header');
//         // Add other theme settings here

//         add_settings_section('sunset_theme_options_settings', 'Theme Options', array($this, 'renderThemeOptionsSection'), 'nimra_sunset_theme_options');
//         add_settings_field('post-formats', 'Post Formats', array($this, 'renderPostFormatsField'), 'nimra_sunset_theme_options', 'sunset_theme_options_settings');
//         // Add other theme fields here
//     }

//     private function registerContactFormSettings() {
//         register_setting('sunset-contact-form-settings', 'activate_contact');
//         // Add other contact form settings here

//         add_settings_section('sunset_conatct_form_setting_section', 'Contact Form Setting', array($this, 'renderContactFormSection'), 'nimra_sunset_contact_setting');
//         add_settings_field('activate_contact', 'Activate Contact Form', array($this, 'renderContactFormActivateField'), 'nimra_sunset_contact_setting', 'sunset_conatct_form_setting_section');
//         // Add other contact form fields here
//     }

//     private function registerCustomCssSettings() {
//         register_setting('sunset_custom_css_settings', 'customized_css');
//         // Add other custom CSS settings here

//         add_settings_section('sunset_custom_css_setting_section', 'Custom CSS', array($this, 'renderCustomCssSection'), 'nimra_sunset_css');
//         add_settings_field('custom_css', 'Insert Custom CSS', array($this, 'renderCustomCssActivateField'), 'nimra_sunset_css', 'sunset_custom_css_setting_section');
//         // Add other custom CSS fields here
//     }

//     public function renderAdminPage() {
//         // Render the admin page content here
//         require_once(get_template_directory() . '/inc/template/sunset-admin.php');
//     }

//     public function renderCustomCssPage() {
//         // Render the custom CSS page content here
//         require_once(get_template_directory() . '/inc/template/custom_css.php');
//     }

//     // Implement rendering methods for each section and field

//     public function renderSidebarSection() {
//         echo 'Blah Blah Blah Blah';
//     }

//     public function renderSidebarProfileField() {
//         $picture = esc_attr(get_option('profile_picture'));
//         echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button"><input type="hidden" id="profile-picture" name="profile_picture" value="' . $picture . '" />';
//     }

// 	public function 

//     // Implement other rendering methods for sidebar fields

//     public function renderThemeOptionsSection() {
//         echo 'Activate and Deactivate your settings';
//     }

//     public function renderPostFormatsField() {
//         $formats = array('aside', 'image', 'gallery', 'video', 'status', 'link');
//         $output = '';
//         $options = get_option('post_formats');
//         foreach ($formats as $format) {
//             $checked = ($options[$format] ?? null) == 1 ? 'checked' : '';
//             $output .= '<label><input type="checkbox" id="' . $format . '" name="post_formats[' . $format . ']" value="1" ' . $checked . '/>' . $format . '</label></br>';
//         }
//         echo $output;
//     }

//     // Implement other rendering methods for theme fields

//     public function renderContactFormSection() {
//         echo 'Blah Blah';
//     }

//     public function renderContactFormActivateField() {
//         $options = get_option('activate_contact');
//         $checked = (@$options == 1 ? 'checked' : '');
//         echo '<label><input type="checkbox" id="activate_contact" name="activate_contact" value="1" ' . $checked . ' /></label>';
//     }

//     // Implement other rendering methods for contact form fields

//     public function renderCustomCssSection() {
//         echo 'Customize Theme with your own CSS';
//     }

//     public function renderCustomCssActivateField() {
//         $css = get_option('customized_css');
//         $css = (empty($css) ? '/* Sunset Custom Theme CSS */' : $css);
//         echo '<div id="customCss">' . $css . '</div> <textarea id="customized_css" name="customized_css" style="display:none;visibility:hidden;">' . $css . '</textarea>';
//     }

//     // Implement other rendering methods for custom CSS fields

//     public function sanitizePostFormats($input) {
//         // Sanitize post formats input
//         return $input;
//     }

//     // Implement other sanitation methods if needed
// }

// // Instantiate the class
// $sunsetThemeOptions = new SunsetThemeOptions();
