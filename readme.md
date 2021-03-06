# Vanilla WP Boilerplate
## Introduction
The Vanilla WP Boilerplate is a boilerplate designed to simplify the process of taking static HTML/CSS and template it out into a custom WordPress theme.

With the Laravel Blade engine, a custom asset pipeline using Gulp and a modifiable theme-config.php, it's easy to create beautiful, dynamic sites.

## Table of contents ##
* [Installation](#installation)
* [Basics](#basics)
* [Directory Structure](#directory-structure)
* [Theme Components](#theme-components)

## Example
One of the most immediate examples to show what this theme and the Blade syntax can do is by looking at the classic WordPress loop:

Stock Wordpress
```
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <h2>
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>
    <div class="entry">
        <?php the_content(); ?>
    </div>
<?php endwhile; else : ?>
    <p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>
```

Vanilla Boilerplate
```
@wpposts
    <h2>
        <a href="{{ the_permalink() }}">
            {{ the_title() }}
        </a>
    </h2>
    <div class="entry">
        {{ the_content() }}
    </div>
@wpempty
    <p>Sorry, no posts matched your criteria.</p>
@wpend
```

## Installation

### Clone the Github repository
```
git clone git@github.com:codemyviews/vanilla-wp-boilerplate.git ~/Code/sample-project.dev
```

### Rename the base-theme folder
The theme folder should be renamed at this point. It can be found in public/wp-content/themes/base-theme

### Composer install
If you do not already have Composer installed on your computer, it can be downloaded and installed from here: https://getcomposer.org.

Once Composer is installed, open a Terminal window (or Git Bash on Windows) and then move to the root of the project directory and install the composer dependencies.

```
cd ~/Code/sample-project.dev
composer install
```

### Create .env in the root of your project
In the project root, their is a file named .env.example. Make a copy of this and rename it to .env

Open the .env file and update the values to match your local development environment.

### Create a MySQL database
You will need to create a new MySQL database that matches the name used under DB_NAME in the **.env**

### Setup site host and finish installation
As a final step, ensure that the site is setup to be served within your local development environment. Please follow the instructions in your local development environment if you have any questions about this.

The important detail to note here is that the public path for the Vanilla boilerplate theme is this:

```
~/Code/sample-project.dev/public
```

Once this is setup, you can visit the site in your browser at the domain you've specified. For example, http://sample-project.dev

To complete installation, visit http://sample-project.dev/wp-admin and follow the prompts.

When you finish this step, you should be able to login to the wp-admin area, and then activate the boilerplate theme.

## Basics ##

### What's Included ###

#### Wordpress Core ####
This project not only includes the Vanilla theme, but also the entirety of Wordpress Core. With the latest version of WP included, it makes it easier to automate deployments
of sites that are built using the the Vanilla template. You can install the theme manually into WP elsewhere with no problems.

As a best practice, the WP core files in wp-admin and wp-includes should never be modified. Editing files here could cause problems if you update to the latest WP version
as your changes would be overwritten.

#### Laravel Blade Templating Engine ####
The Blade templating engine, developed for Laravel has been included in this theme.

Using Blade gives you the ability to make your frontend templates much cleaner and organized. You can read the blade documentation here: https://laravel.com/docs/5.2/blade

#### Gravity Forms Plugin ####
We recommend Gravity Forms as being the best plugin to use for form submission management and so it's included within the repository. There are no hard dependencies on Gravity Forms so feel free to remove or replace it with a different contact form plugin.

#### Advanced Custom Fields Pro ####
ACF5 is bundled directly into the theme itself because it relies on the ACF5 Options Panel functionality and we also use Advanced Custom Fields heavily during WP development.  For the time being, the theme does not work well without ACF5, but on a future release, we may have a version of the theme that does not use ACF5.

### Directory Structure ###
This is the directory structure of the Vanilla theme itself.  The theme directory is in `public/wp-content/themes`, which is where all of the theme coding and customization will happen.

* **assets** - All static assets
    * **compiled** - This directory should largely be untouched.  This is where compiled assets end up.  More on this later.
    * **js** - Javascript files
        * **plugins** - All JavaScript plugins your front end uses go here
        * **custom** - All custom JavaScript or jQuery should go here
    * **sass** - Default SASS directory (this can also be a less/ directory if your front end uses less).  You should place all of your SCSS or LESS files in this directory.
    * **images** - Place all of the images from your front end into this directory.
    * **fonts** - If your front end uses any custom fonts, you can place the font files in this directory.
* **controllers** - Your custom view controllers go here. Used to pass data to the blade views.
* **core** - This is all of the core theme files.  This is where the magic of the Vanilla theme happens.
* **endpoints** - This is where any endpoints that are needed for the theme are placed  For example, if your theme has a contact form, you will likely create a file in this directory called contact-form.php.
* **views** - All bladed views for the theme are contained here
    * **layouts** - Extendable layouts for the blade views
    * **partials** - Various includes (Header, Footer, etc.)
* **shortcodes** - Template files for custom shortcodes can be placed in this directory.
* **sidebars** - Custom sidebars can be placed in this directory.
* **404.php** - The default 404 template for the Vanilla theme.  This can be customized to provide a more meaningful message.
* **functions.php** - This file behaves just as a functions.php file would behave in any WordPress theme. Any WP customization code can be placed here.
* **gulpfile.js** - This file is used to compile all of the JavaScript and SASS/LESS from the assets directory into the assets/compiled directory
* **package.json** - This file defines the NPM packages that are required for the gulpfile to work correctly (more on this later)
* **screenshot.png** - This is the screenshot that appears on the theme activation page in wp-admin.  Feel free to replace this with any image you want.
* **theme-config.php** - The config file for Vanilla.  This is where the bulk of the configuration will happen for the theme.
* **style.css** - This is the default stylesheet.  The name of the theme and the author can be updated in this file.

### Asset Pipeline ###
The Vanilla theme is driven by a gulpfile.js which is included in the root of the theme. By default, Gulp will compile your theme.scss to a theme.css and your Javascript source files in the js/custom and js/plugins folders to theme.js. These two files will automatically be output into the header and footer of each page using the Vanilla boilerplate.

### Theme Config File ###
If you are already a WordPress developer, the power of the Vanilla theme comes with the theme-config.php file where you can quickly define and utilize all of the various WordPress components, all in one place.

Follow the [Theme Components](#theme-components) guide to configure your theme-config.php

## Theme Components ##
* [Templates](#templates)
* [Controllers](#controllers)
* [Custom Page Templates](#custom-page-templates)
* [Custom Post Types](#custom-post-types)
* [Custom Taxonomies](#custom-taxonomies)
* [Menus](#menus)
* [Sidebars](#sidebars)
* [Option Panels](#option-panels)
* [Custom Fields](#custom-fields)

### Blade Templates ###
The Vanilla theme uses the Laravel Blade template engine to power the theme files.  For more details on Blade, you can read the documentation here: https://laravel.com/docs/5.2/blade

#### Layouts ####
When looking at a website, most likely it has several components that are shared on multiple pages. For example, the header and footer. Layouts allow various pages on your site to share components while also extending them for any customizations that are needed on individual pages. Layouts go in the `views/layouts` folder in the theme. Usually only one layout will be required, but multiple layouts are supported as well.

For reference, here is the default layout that is used in the theme:
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ wp_title('') }}</title>

    @yield('head')

    {{ wp_head() }}

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

@yield('content')

{{ wp_footer() }}
</body>
</html>
```

#### Views ####
Views represent what a user actually sees. For example, the theme will likely have a home page, an about page and a contact page. Each of these pages will use a unique template and each of these unique templates are views. You can turn your static HTML files into dynamic reusable views that will be placed into the `views` directory of the Vanilla theme.

The default views that are created for you are:
* **404.blade.php** - This replaces the 404.php and will be displayed whenever a page is not found.
* **index.blade.php** - The root view for your site, view is loaded in place of the index.php in the root.
* **page.blade.php** - This replaces the page.php and will be displayed for pages with the default template.
* **single.blade.php** - This replaces the single.php and will be displayed for posts with the default template.
* **test-page.blade.php** - This is a simple custom page template

Other examples of common views in your theme:
* Blog index page (a feed of blog posts)
* Blog single page (a single blog post)
* Blog category page (a feed of blog posts from a specific category)
* Search results page
* Product page

The most important concept to remember is that we are creating these views so that they are reusable and completely dynamic.  For example, if you have a Product view, it may be re-used to show several different products on the site.

#### Partials ####
In the name of DRY (Don't Repeat Yourself), we place any front end code that is used in more than one view into a partial.  For example, if both your "Home Page" view and your "Product" view has a newsletter block on it, we can copy the code for the newsletter, place it into a partial, and then load the partial in both of the views using:

```
@include('partials.name-of-partial')
```

Any time you find two views using the same block of HTML, you should partial it out into a file in the `partials` directory. Never reuse the same code in two places.

### Controllers ###
Controllers can be used to pass data to a view. A TestController.php is included to demonstrate its use. Specify what views the controller applies to in the `$views` array and return the actual data to the view in the process method.

```
class TestController extends Controller
{
    // The view this will apply to
    protected $views = [
        'index'
    ];

    // The data to return to the view
    public function process()
    {
        return ['home' => 'that', 'page' => 'this'];
    }

}
```

### Custom Page Templates ###
Pages are also enabled by default in every WordPress theme. Pages and posts are identical other than  (1) pages are hierarchical, so a page can have a parent page and many children pages and (2) pages do not have category or tags associated with them (although you certainly can enable this behavior if you wanted to).

A unique feature to pages is that you can also create Custom Page Templates, and then assign the custom page templates to specific pages on your site.  For example, you may have an About Us page and you want to use a custom template  You can simply create a new file in the “views” directory called “about.blade.php”, and use the code below as a template:
```
<?php /* Template Name: About Page Template */ ?>
@section('content')
    @wpposts
        <h1>{{ the_title() }}</h1>
        <p>{{ the_content() }}</p>
    @wpempty
        <h1>No posts found</h1>
    @wpend
@endsection

```

### Custom Post Types ###
In many cases, your theme may not require additional post types, as post and page will fulfill all the needs of your theme.

However, let's assume that the site you are building has other data types.  For example, maybe your site has client testimonials that are displayed in various parts of the site. If you are building a portfolio on your site, you will have many different portfolio items.  Finally, if you are selling something on your site, you may have a list of products.  In each of those cases, you will need to create a Custom Post Type (CPT) so that you will be able to easily store this data in your theme.

An example of a simple testimonial custom post type:
```
$this->customPostTypes['testimonials'] = [

    'label' => 'Testimonials',
    'description' => 'These are client testimonials ',
    'public' => true,
    'exclude_from_search' => true,
    'show_ui' => true, // If true, WP will generate a UI for managing in admin
    'supports' => [ 'title', 'editor' ], // Array of default behaviors to use
    'has_archive' => false, // Prevent archiving for this post type
    'rewrite' => true, // Rewriter for pretty URLs
    'single-post-view' => 'testimonial' // Specifies a custom view for this, in this case it refers to views/testimonial.blade.php
];
```
Within the theme-config.php, it is easy to add an additional post type within the loadCustomPostTypes() method. You can reference the WordPress documentation for register_post_type to see what arguments can be added for each custom post type. https://codex.wordpress.org/Function_Reference/register_post_type

By default, your custom post type will use a blade based off of the name of the post type. So for example testimonials above would use `testimonials.blade.php` by default. However, if you specify the single-post-view option, you can specify whichever template you'd like.

### Custom Taxonomies ###
Taxonomies can be used to sort and filter your post types. We support creating custom taxonomies as needed.

Custom taxonomies can be created and assigned to post types within the theme which allows filtering of posts. For example, if we have a Testimonials CPT, we may want to be able to filter those Testimonials by type of client (residential or business). We can create a custom taxonomy called "client_type" and then assign it to the Testimonials CPT. This would allow us to then add the client type and add them to the testimonials.

```
$this->customTaxonomies['testimonial-client'] = [

    'belongs_to_post_type' => 'testimonials',
    'label' => 'Client Type,
    'description' => 'This is the client type for a testimonial',
    'public' => true,
    'hierarchical' => false
];
```

Within the theme-config.php, you can create custom taxonomies and assign them to post types within the loadCustomTaxonomies() method. Reference the WordPress documentation for register_taxonomy to see what arguments can be added for each custom taxonomy. https://codex.wordpress.org/Function_Reference/register_taxonomy

### Menus ###
Your theme likely has a navigation menu (or two menus, or many).  For example, you may have a menu in the header, and also a menu in the footer.  Menus in WordPress allow you to dynamically control which pages are outputted into the menus.

Within the theme-config.php, you can create and define menus within the setMenus() method.
```
$this->menus = [
    'main_nav' => 'Main Navigation',
    'footer_nav' => 'Footer Navigation'
];
```

### Sidebars ###
To define a new custom sidebar widget area, please see the loadSidebars() method in the theme-config.php file.
```
register_sidebar([
    'name'          => 'Primary',
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
]);
```

### Option Panels ###
Within the theme, you can create custom Option Panels that will then appear in wp-admin. ACF field groups can then be assigned to these option panels. The purpose of these are to give the theme some global configuration options. For example, if you want the user to be able to update the logo on the site you can create an option panel called "Header Options" and then create a field group on this option panel called "Header Logo". The user will then be able to update the logo dynamically in wp-admin.

Within the theme-config.php, you can create custom options panels within the loadOptionsPanel() method.

### Custom Fields ###
Every custom page template, post type, options panel, custom taxonomy may have additional data associated with it. For example, on your testimonial post you will want to be able to store the name of your client and their testimonial.

For each area on the site where we have custom data to be stored, we will create an Advanced Custom Fields field group, and then create fields that will allow the user to easily update the content on that specific page, post, options panel, or taxonomy.

## Helper Functions ##

### Helper::image ###
The Helper::image function allows you output an image that is stored as a custom field. When an image is stored into a custom field, the attachment_id will always be stored. By passing that ID to Helper::image you can automatically generate the <img> tag.

For example, this:
```
{{ Helper::image(get_field('profile_image'), 'attorney', array('class' => 'pull-left')) }}
```
Would generate this:
```
<img src="http://path-to-image/size/profile-image.jpg" alt="Image Alt Text" title="Image Title Text" class="pull-left" />
```

### asset() ###
The asset helper function allows you to easily return an absolute URL to a file in the assets directory of the theme.  For example, if you want to get the URL to a image in the assets/images directory, you can use the function like so:
```
<img src="{{ asset('images/image-name.png') }}" />
```

You can also use the `@asset` directive within blades for the same functionality.
