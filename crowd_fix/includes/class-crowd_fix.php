<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://devdigital.pro
 * @since      1.0.0
 *
 * @package    Crowd_fix
 * @subpackage Crowd_fix/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Crowd_fix
 * @subpackage Crowd_fix/includes
 * @author     DEVDIGITAL <info@devdigital.pro>
 */


class Crowd_fix
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Crowd_fix_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {

        $this->plugin_name = 'crowd_fix';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->main_functions();


    } // end construct


    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Crowd_fix_Loader. Orchestrates the hooks of the plugin.
     * - Crowd_fix_i18n. Defines internationalization functionality.
     * - Crowd_fix_Admin. Defines all hooks for the admin area.
     * - Crowd_fix_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crowd_fix-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crowd_fix-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-crowd_fix-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-crowd_fix-public.php';

        $this->loader = new Crowd_fix_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Crowd_fix_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Crowd_fix_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Crowd_fix_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

//		/$this->loader->add_action('admin_menu', $plugin_admin, 'my_admin' );


    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Crowd_fix_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Crowd_fix_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }


    public function main_functions()
    {


        // редирект на дашбоард
        add_action('template_redirect', function () {


            // получаем id страниц из настроек

            $options = get_option('CrowdFix_settings');
            $acc_page_id = $options['CrowdFix_field2'];
            $login_page_id = $options['CrowdFix_field1'];


            if ($login_page_id && $acc_page_id) :


                if (is_page('my-account') || is_page('cf-dashboard') ) {

                    wp_redirect(get_the_permalink($acc_page_id));
                    exit;
                }


                if (is_user_logged_in()) {
                    if (is_page('login')) {
                        wp_redirect('http://ivanov2/dashboard/', 301);
                        exit;
                    }
                } else {
                    if (is_page('login')) {
                        wp_redirect('http://ivanov2/dashboard/', 301);
                        exit;
                    }
                }



            endif; // $login_page_id && $acc_page_id

        });

        // логин page шаблон
//        add_filter('page_template', 'wpa3396_page_template');
//        function wpa3396_page_template($page_template)
//        {
//
//            $options = get_option('CrowdFix_settings');
//            $acc_page_id = $options['CrowdFix_field2'];
//            $login_page_id = $options['CrowdFix_field1'];
//
//
//            if (is_page($login_page_id) && $login_page_id != null) {
//                $page_template = plugin_dir_path(__FILE__) . 'tpl/crowd_fix-public-display.php';
//
//            }
//            return $page_template;
//        }



    }


}
