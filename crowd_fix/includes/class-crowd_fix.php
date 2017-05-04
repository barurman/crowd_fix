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


                if (is_page('dashboard') || is_page('cf-dashboard') || is_page('customer-logout')  ) {

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


        // Добавим новое поле VK для юзера

        add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
        add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

        function my_show_extra_profile_fields( $user ) { ?>

            <h3>Дополнительные поля (Crowdfix)</h3>

            <table class="form-table">

                <tr>
                    <th><label for="VK">Вконтакте</label></th>

                    <td>
                        <input type="text" name="vk" id="vk" value="<?php echo esc_attr( get_the_author_meta( 'vk', $user->ID ) ); ?>" class="regular-text" /><br />
                        <span class="description">Ссылка на страницу Вконтакте</span>
                    </td>
                </tr>

            </table>
        <?php }



        // Добавляем поле VK

        add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
        add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

        function my_save_extra_profile_fields( $user_id ) {

            if ( !current_user_can( 'edit_user', $user_id ) )
                return false;

            /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
            update_usermeta( $user_id, 'vk', $_POST['vk'] );
        }




        function debug_to_console( $data ) {
            $output = $data;
            if ( is_array( $output ) )
                $output = implode( ',', $output);

            echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
        }

        // Добавляем хук VK
        add_action( 'wpneo_crowdfunding_after_save_dashboard', 'wpneo_dashboard_form_save_vk');

        function wpneo_dashboard_form_save_vk(){
          //  debug_to_console( 'работает' );
            $id  =  get_current_user_id();
            $vk  =  sanitize_text_field($_POST['vk']);

            update_usermeta( $id, 'vk', $vk  );

        }


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

