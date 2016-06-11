<?php

namespace BaseTheme;

/**
 * Loads the base theme class.  The BaseThemeClass is extended here.
 * Please see wiki documentation for full set of features and helpers available in the BaseThemeClass.
 */
include_once( 'core/BaseThemeClass.php' );

class Theme extends BaseThemeClass {

    /**
     * Allows you to disable WordPress from including jQuery by default.
     * You should only set this to true if your theme.js file includes jQuery.
     */
    public $includeJQuery = true;

    /*
     * Loads an options panel in wp-admin.
     * If this is enabled, you create custom fields and target them to this option panel.
     */
    public $loadOptionsPanel = true;

    /*
     * If you want to force disable to WP theme editor, set this to true.
     * Since we keep our WP themes in version control, we set this to true by default.
     */
    public $disabledThemeEditor = true;

    /*
     * Toggle featured image support on your posts and pages
     */
    public $loadThumbnailSupport = true;

    /*
     * This allows you to edit the default text that appears with post excerpts.
     * If you set this to null, a simple "..." will output at the end of each excerpt.
     */
    public $excerptText = 'Read More';

    /*
     * By default, the theme will disable the ACF Options menu in wp-admin, unless WP_DEBUG is set to true.
     * If you want to force enable to ACF options panel to display, you can set this variable as true
     */
    public $forceEnableAcfOptionPanel = false;

    public function __construct()
    {
        parent::__construct();

        $this->themeName = defined('THEME_NAME') ? THEME_NAME : 'base-theme';
        $this->version = getenv('VERSION') ? getenv('VERSION') : '1.0';
    }

    /*
     * Specify your custom post types here and they will be loaded by the theme
     */
    public function loadCustomPostTypes()
    {

        $this->customPostTypes['custom_post'] = array(

            'label' => 'Custom Post',
            'description' => 'This is a custom post type',
            'public' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'supports' => [ 'title', 'editor' ],
            'has_archive' => false,
            'rewrite' => false,
            'single-post-view' => 'custom-post'
        );

    }

    /*
     * Specify your custom taxonomies here and they will be loaded by the theme
     */
    public function loadCustomTaxonomies()
    {
        // Sample Custom Taxonomy - Add as many as you'd like
        /*
        $this->customTaxonomies['custom_post-category'] = array(

            'belongs_to_post_type' => 'custom_post',
            'label' => 'Post Categories',
            'description' => 'These are the categories used to sort custom posts',
            'public' => true,
            'hierarchical' => false

            // any additional options can be added as defined in WP codex: https://codex.wordpress.org/Function_Reference/register_taxonomy
        );
        */
    }

    /*
     * Specify your custom shortcodes here
     */
    public function loadShortcodes()
    {
        //This is a sample shortcode.  Please see full shortcode documentation.

        /*
        add_shortcode( 'contact_form', function($atts) {
            return $this->blade->view('forms/contact-form', array(
                'form_title' => 'Contact Us',
                'atts' => $atts
            ));
        });
        */
    }

    /*
     * Specify your sidebars to be loaded here
     */
    public function loadSidebars()
    {
        /*
        register_sidebar(array(
            'name'          => 'Primary',
            'id'            => 'sidebar-primary',
            'before_widget' => '<section class="widget %1$s %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        ));
        */
    }

    /*
     * Add ACF Options pages here
     */
    public function loadOptionsPanel()
    {
        acf_add_options_page(array(
            'page_title'    => 'Theme Options',
            'menu_title'    => 'Options',
            'menu_slug'     => 'theme-options-settings',
            'capability'    => 'edit_posts',
            'redirect'      => true
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Header & Footer Options',
            'menu_title'    => 'Header / Footer',
            'parent_slug'   => 'theme-options-settings',
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'JavaScript & CSS Options',
            'menu_title'    => 'Javascript / CSS',
            'parent_slug'   => 'theme-options-settings',
        ));
    }

    /*
     * Specify the menus to be loaded by the theme
     */
    public function setMenus()
    {
        $this->menus = array(
            'main_nav' => 'Main Navigation',
            'footer_nav' => 'Footer Navigation'
        );
    }

    /**
     * Set the image size array.
     *
     * $image_sizes[] = array('name' => 'image-size-name', 'width' => 600, 'height' => 400, 'crop' => true)
     * set width/height to 9999 to not force that size.
     * set crop to false to not force the size.
     */
    public function setImageSizes()
    {
        $this->imageSizes[] = array(
            'name' => 'medium-size',
            'width' => 600,
            'height' => 400,
            'crop' =>true
        );
    }

}

$theme = new \BaseTheme\Theme;
