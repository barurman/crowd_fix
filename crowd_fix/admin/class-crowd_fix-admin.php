<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://devdigital.pro
 * @since      1.0.0
 *
 * @package    Crowd_fix
 * @subpackage Crowd_fix/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Crowd_fix
 * @subpackage Crowd_fix/admin
 * @author     DEVDIGITAL <info@devdigital.pro>
 */


include 'partials/crowd_fix-admin-display.php';


class Crowd_fix_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Crowd_fix_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Crowd_fix_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/crowd_fix-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */


    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Crowd_fix_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Crowd_fix_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->version, false);

    }




}


add_action('admin_menu', 'add_plugin_page');
function add_plugin_page()
{
    add_options_page('Настройки CrowdFix', 'CrowdFix', 'manage_options', 'CrowdFix_slug', 'CrowdFix_options_page_output');
}

function CrowdFix_options_page_output()
{
    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>

        <form action="options.php" method="POST">
            <?php
            settings_fields('option_group');     // скрытые защитные поля
            do_settings_sections('CrowdFix_page'); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/**
 * Регистрируем настройки.
 * Настройки будут храниться в массиве, а не одна настройка = одна опция.
 */
add_action('admin_init', 'plugin_settings');
function plugin_settings()
{
    // параметры: $option_group, $option_name, $sanitize_callback
    register_setting('option_group', 'CrowdFix_settings', 'sanitize_callback');

    // параметры: $id, $title, $callback, $page
    add_settings_section('section_id', '', '', 'CrowdFix_page');

    // параметры: $id, $title, $callback, $page, $section, $args
    add_settings_field('CrowdFix_field1', 'Страница входа/регистрации', 'fill_CrowdFix_field1', 'CrowdFix_page', 'section_id');
    add_settings_field('CrowdFix_field2', 'Страница личного кабинета', 'fill_CrowdFix_field2', 'CrowdFix_page', 'section_id');
}

## Страница входа/регистрации
function fill_CrowdFix_field1()
{
    $options = get_option( 'CrowdFix_settings' );

    $mypages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'post_date', 'sort_order' => 'desc' ) );


   ?> <select name='CrowdFix_settings[CrowdFix_field1]'> <?
    foreach( $mypages as $page ) {?>
    <option value="<?=$page->ID;?>" <?php selected( $options['CrowdFix_field1'], $page->ID );?> ><?=$page->post_title;?></option>
    <?php
}
    echo   '</select>';

}



## Страница личного кабинета
function fill_CrowdFix_field2()
{
    $options = get_option('CrowdFix_settings');
    $mypages = get_pages( array('child_of'=>$post->ID,'sort_column'=>'post_date','sort_order'=>'desc') );
   ?> <select name='CrowdFix_settings[CrowdFix_field2]'> <?
    foreach( $mypages as $page ) {?>
        <option value="<?=$page->ID;?>" <?php selected( $options['CrowdFix_field2'], $page->ID );?>><?=$page->post_title;?></option>
        <?php
    }
    echo '</select>';


}

