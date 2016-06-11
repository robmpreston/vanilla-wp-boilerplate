<?php

namespace BaseTheme;

abstract class BaseThemeClass
{
    /**
     * Set this to the version of your theme
     *
     * @var string
     */
    public $version;

    /**
     * The name of the theme
     *
     * @var string
     */
    public $themeName;

    /**
     * You can set this to false if the theme javascript includes jQuery
     *
     * @var boolean
     */
    public $includeJQuery;

    /**
     * The blade class
     * @var Blade
     */
    public $blade;

    /**
     * This is the array that holds the image sizes.
     * Set this with the set_image_sizes method.
     *
     * @var array
     */
    public $imageSizes;

    /**
     * This is the array of menus for the site.
     * Set this with the set_menus method.
     *
     * @var array
     */
    public $menus;

    /**
     * This allows you to enable/disable the theme editor.
     *
     * @var boolean
     */
    public $disabledThemeEditor;

    /**
     * Set the excerpt read more link text.
     * Set to null if you do not want to output a read more link.
     *
     * @var string
     */
    public $excerptText;

    /**
     * This is a boolean that determines whether or not to load the custom options panel
     * The custom options panel can be set in the load_options_panel method
     * Set this with the set_menus method.
     *
     * @var boolean
     */
    public $loadOptionsPanel;

    /**
     * This allows you to enable/disable the post thumbnail.
     *
     * @var boolean
     */
    public $loadThumbnailSupport;

    /**
     * By default, the ACF Option panel is wp-admin is hidden unless WP_DEBUG is defined as true.
     * By setting this var to true, you can force enable the option panel to show even if WP_DEBUG is set to false (i.e. in a production environment)
     *
     * @var boolean
     */
    public $forceEnableAcfOptionPanel;

    /**
     * This is the variable where you add the custom post types to be loaded into the theme
     *
     * @var array
     */
    public $customPostTypes;

    /**
     * This is the variable where you add the custom taxonomies to be loaded into the theme
     *
     * @var array
     */
    public $customTaxonomies;

    /**
     * Bootstrap function for the class.
     * Loads everything up based off of various parameters you can set.
     */
    public function __construct()
    {
        add_action('init', array( $this, 'loadFiles' ));

        $this->loadBladeTemplating();

        $this->includeAdvancedCustomFields();

        define( 'DISALLOW_FILE_EDIT', $this->disabledThemeEditor );

        $this->addWpActions();

        $this->loadCustom();

        /* Remove all junk */
        $this->removeJunk();
    }

    /**
     * Add WP Actions
     */
    public function addWpActions()
    {
        /* Enqueue the Theme Script */
        add_action( 'wp_enqueue_scripts', array( $this, 'loadScripts' ));

        /* Enqueue the Theme Stylesheet */
        add_action( 'wp_enqueue_scripts', array( $this, 'loadStyles' ));

        /* Load custom CSS/JS into head */
        add_action('wp_head', array( $this, 'loadAdditionalHeadJsCss' ));

        /* Load additional JS into footer */
        add_action('wp_footer', array( $this, 'loadAdditionalFooterJs' ));

        /* Load favicions into head */
        add_action('wp_head', array( $this, 'loadFavicons' ));

        /* Clean up excerpt */
        add_filter('excerpt_more', array( $this, 'excerptMore' ));

        /* Clear blade view cache if DISABLE_BLADE_CACHE constant = true */
        add_action('init', array( $this, 'clearBladeCache' ));

        add_action('init', array( $this, 'loadWpCliCommands' ));
    }

    /**
     * Load custom options if they exist
     */
    public function loadCustom()
    {
        /* Load shortcodes */
        if(method_exists($this, 'loadShortcodes'))
        {
            $this->loadShortcodes();
        }

        /* Load all custom post types */
        if(method_exists($this, 'loadCustomPostTypes'))
        {
            add_action('init', array( $this, 'addCustomPostTypes' ));
        }

        /* Load all custom post types */
        if(method_exists($this, 'loadCustomTaxonomies'))
        {
            add_action('init', array( $this, 'addCustomTaxonomies' ));
        }

        /* Load all options panels if not globally disabled */
        if(method_exists($this, 'loadOptionsPanel') && $this->loadOptionsPanel == true)
        {
            $this->loadOptionsPanel();
        }

        /* Load all dynamic sidebars */
        if(method_exists($this, 'loadSidebars'))
        {
            add_action('widgets_init', array( $this, 'loadSidebars' ));
        }

        /* Load all image sizes */
        if(method_exists($this, 'setImageSizes'))
        {
            $this->setImageSizes();
            $this->loadThumbnailSupport();
        }

        /* Set all menus and load menu support */
        if(method_exists($this, 'setMenus'))
        {
            $this->setMenus();
            $this->loadMenuSupport();
        }
    }

    /**
     * This method will loop through the $customPostTypes array and generate the
     * register_post_type function call and register a custom single post view.
     */
    public function addCustomPostTypes()
    {
        /* loads the CPTs from functions.php */
        $this->loadCustomPostTypes();

        if( is_array($this->customPostTypes) )
        {
            foreach($this->customPostTypes as $postTypeName => $options)
            {
                register_post_type($postTypeName, $options);
                if (isset($options['single-post-view'])) {
                    $this->blade->registerCustomPostView($postTypeName, $options['single-post-view']);
                }
            }
        }
    }

    /**
     * This method will loop through the $customTaxonomies array, ensure that the
     * associated post type exists and then call register_taxonomy
     */
    public function addCustomTaxonomies()
    {
        /* loads the custom taxonomies from functions.php */
        $this->loadCustomTaxonomies();

        if ( is_array($this->customTaxonomies) )
        {
            foreach($this->customTaxonomies as $taxonomyName => $options)
            {
                $belongsToPostType = $options['belongs_to_post_type'];

                if ( !post_type_exists( $belongsToPostType ))
                {
                    add_action( 'admin_notices', function() use ( $taxonomyName ) {
                        $class = "error";
                        $message = "The taxonomy you are trying to register in functions.php references a custom post type that does not exist.  Please make sure you are properly registering your custom post type in the functions.php load_custom_post_types method.  The CPT from this error is called: <strong>{$taxonomy_name}</strong>.";
                        echo"<div class=\"$class\"> <p>$message</p></div>";
                    });
                }

                unset( $options['belongs_to_post_type'] );

                register_taxonomy($taxonomyName, $belongsToPostType, $options);
            }
        }
    }

    /**
     * Files to Include
     *
     * The $filesToLoad array determines the code included in the theme by default.
     * Add or remove files to the array as needed.
     *
     */
    public function loadFiles()
    {
        $filesToLoad = array(
            'includes/Helper.php',
        );

        foreach ($filesToLoad as $file)
        {
            require_once $file;
        }

        $customEndpoints = get_template_directory() . '/endpoints/';

        $files = glob($customEndpoints.'*');

        foreach($files as $file) {
            if  (is_file($file)) {
                require_once $file;
            }
        }
    }

    /*
     * Load custom Wordpress CLI Commands
     */
    public function loadWpCliCommands()
    {
        if ( defined( 'WP_CLI' ) && \WP_CLI )
        {
            $filesToLoad = array(
                'wp-cli-commands/DevMode.php',
                'wp-cli-commands/UpdateSiteUrl.php'
            );

            foreach ($filesToLoad as $file)
            {
                require_once $file;
            }

            \WP_CLI::add_command( 'devmode', '\DevMode_Command' );
            \WP_CLI::add_command( 'url', '\UpdateSiteUrl_Command' );
        }
    }

    /**
     * Clean up the_excerpt()
     */
    public function excerptMore($more)
    {
        if( !is_null($this->excerptText) )
        {
            return '... <a href="' . get_permalink() . '">' . $this->excerptText . '</a>';
        }
        else
        {
            return '...';
        }
    }

    public function loadAdditionalHeadJsCss()
    {
        echo get_field('header_css_js_custom', 'option');
    }

    public function loadAdditionalFooterJs()
    {
        echo get_field('custom_js_footer', 'option');
    }

    /**
     * Loads the theme scripts.
     */
    public function loadScripts()
    {
        if($this->includeJQuery === false)
        {
            wp_deregister_script('jquery');
            wp_enqueue_script( 'jquery' , asset('compiled/js/theme.js'), null, $this->version, true );
        }
        else
        {
            wp_enqueue_script( $this->themeName .'-script' , asset('compiled/js/theme.js'), array( 'jquery' ), $this->version, true );
        }
    }

    /**
     * Loads the theme styles.
     */
    public function loadStyles()
    {
        wp_enqueue_style( $this->themeName .'-style', asset('compiled/css/theme.css'), array(), $this->version);
    }

    /**
     * Load the thumbnail and image size options
     */
    protected function loadThumbnailSupport()
    {
        if($this->loadThumbnailSupport === true)
        {
            add_theme_support( 'post-thumbnails' );
        }

        if(is_array($this->imageSizes))
        {
            foreach($this->imageSizes as $size)
            {
                add_image_size($size['name'], $size['width'], $size['height'], $size['crop']);
            }
        }
    }

    /**
    * Outputs the html for the favicon and other icons
    */
    public function loadFavicons()
    {
        $output = '';

        $faviconPath = get_field('favicon','option');
        $otherIcons  = get_field('other_icons','option');

        if ($faviconPath) {
            $output .= "<link rel='shortcut icon' href='{$faviconPath}' type='image/x-icon'>\n";
        }

        if ($otherIcons) {
            foreach($otherIcons as $icon) {
                $output .= "<link rel='apple-touch-icon' type='image/png' sizes='{$icon['size']}' href='{$icon['image']}'>\n";
            }
        }

        echo $output;
    }


    /**
    * Loads the menus.
    *
    * You will need to set the $menus param in theme-config.php
    */
    protected function loadMenuSupport()
    {
        if (is_array( $this->menus ))
        {
            add_theme_support( 'menus' );
            register_nav_menus( $this->menus );
        }
    }

    /**
    * Loads the blade template engine.
    */
    protected function loadBladeTemplating()
    {
        if( !class_exists('WP_Blade_Main_Controller') )
        {
            include_once( 'blade/blade.php' );
            $this->blade = \WP_Blade_Main_Controller::make();
        }
    }

    /**
    * Clears the blade view cache in development
    */
    public function clearBladeCache()
    {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            $cachedViewsDirectory = get_template_directory() . 'core/blade/cache/';

            $files = glob($cachedViewsDirectory.'*');

            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    /**
    * Loads ACF if the plugin is not included.
    */
    public function includeAdvancedCustomFields()
    {
        if ( ! class_exists('acf') ) {
            add_filter('acf/settings/path', array( $this, 'myAcfSettingsPath' ));
            add_filter('acf/settings/dir',  array( $this, 'myAcfSettingsDir'  ));

            include_once( 'acf/acf.php');

            if(WP_DEBUG == false && $this->forceEnableAcfOptionPanel === false) {
                add_filter('acf/settings/show_admin', '__return_false');
            }
        }

        add_filter('acf/format_value', array( $this,'parseTemplateDirectory' ), 10, 3);

        /* Load WPCLI Interface for ACF */
        include_once('acf-wpcli/advanced-custom-fields-wpcli.php');

        if(function_exists('acf_wpcli_register_groups')) {
            acf_wpcli_register_groups();
        }
    }

    public function parseTemplateDirectory( $value, $post_id, $field )
    {
        $searchAndReplace = array(
            '{IMAGEPATH}' => get_template_directory_uri() . '/public/images'
        );

        foreach($searchAndReplace as $search => $replace) {
            $value = str_replace($search, $replace, $value);
        }

        return $value;
    }

    public function myAcfSettingsPath( $path )
    {
        $path = get_stylesheet_directory() . '/core/acf/';

        return $path;
    }

    public function myAcfSettingsDir( $dir )
    {
        $dir = get_stylesheet_directory_uri() . '/core/acf/';

        return $dir;
    }

    /**
     * Clean code = better code.
     */
    protected function removeJunk()
    {
        // Remove "Link" canonical HTTP header
        remove_action('template_redirect', 'wp_shortlink_header', 11);

        add_filter('wp_headers', array( $this, 'removeXPingback' ));

        // remove junk from head
        remove_action('wp_head', 'rel_canonical');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'start_post_rel_link', 10, 0);
        remove_action('wp_head', 'parent_post_rel_link', 10, 0);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    }

    /**
     * Unneeded pingback header.
     */
    public function removeXPingback($headers)
    {
        unset($headers['X-Pingback']);

        return $headers;
    }
}
