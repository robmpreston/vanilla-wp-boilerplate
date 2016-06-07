# Vanilla WP Boilerplate
## Introduction
Vanilla WP Boilerplate is a boilerplate designed to simplify the process of taking static HTML/CSS and template it out into a custom WordPress theme.

## Table of contents ##
* [Installation](#installation)
* [Basics](#basics)
* [Directory Structure](#directory-structure)
* [Theme Components](#theme-components)

## Example

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

As you can see, using blade syntax will help to clean up your templates.

## Installation

### Clone the Github repository
```
git clone git@github.com:codemyviews/vanilla-wp-boilerplate.git ~/Code/sample-project.dev
```

### Rename the base-theme folder
It is recommended that you rename the theme folder to the name of your theme. It can be found in public/wp-content/themes/base-theme

### Composer install
If you do not already have Composer installed on your computer, you will need to download and install it here: https://getcomposer.org.

Once you have Composer installed on your machine, you will need to open your Terminal (or Git Bash if you are on Windows) and then move to the root of the project directory and install the composer dependencies.

```
cd ~/Code/sample-project.dev
composer install
```

### Create .env in the root of your project

In the project root, you will find a file called .env.example, make a copy of this and name it .env

Open the .env file and update the values to match your local development environment.

### Create a MySQL database

You will need to create a new MySQL database that matches the name you used under DB_NAME in the **.env**

### Setup site host and finish installation

As a final step, you will need to ensure that you setup the site to be served within your local dev environment.  Please follow the instructions in your local dev environment setup guide if you have questions about this.  

The important detail to note here is that the public path for the Vanilla boilerplate theme is this:

```
~/Code/sample-project.dev/public
```

Once this is setup, you can visit the site in your browser at the domain you've specified. For example, http://sample-project.dev

To complete installation, visit http://sample-project.dev/wp-admin and follow the prompts

When you finish this step, you should be able to login to your wp-admin area, and then activate the boilerplate theme.

## Basics ##

### What's Included ###

#### Wordpress Core ####
This project not only includes the Vanilla theme, but also the entirety of Wordpress Core. With the latest version of WP included, it makes it easier to automate deployments
of sites that are built using the Vanilla template. You can install the theme manually into WP elsewhere with no problems.

As a best practice, the WP core files in wp-admin and wp-includes should never be modified. Editing files here could cause problems if you update to the latest WP version
as your changes would be overwritten.

#### Laravel Blade Templating Engine ####
The Blade templating engine, developed for Laravel has been included in this theme.

Using Blade gives you the ability to make your frontend templates much cleaner and organized. You can read the blade documentation here: https://laravel.com/docs/5.2/blade

#### Gravity Forms Plugin ####
We always recommend Gravity Forms as the best plugin to use for form submission management and so we include it within the repository.  There are no hard dependencies on Gravity Forms so if you wanted to remove this or replace it with a different contact form plugin, that would be fine.

#### Advanced Custom Fields Pro ####
ACF5 is bundled directly into the theme itself because it relies on the ACF5 Options Panel functionality and we also use Advanced Custom Fields heavily during WP development.  For the time being, the theme does not work well without ACF5, but on a future release, we may have a version of the theme that does not use ACF5.

### Directory Structure ###

This is the directory structure of the Vanilla theme itself.  The theme directory is in `public/wp-content/themes`, which is where all of your theme coding and customization will happen.

* **assets** - All static assets
    * **compiled** - This directory should largely be untouched by you.  This is where compiled assets end up.  More on this later.
    * **js** - Javascript files
        * **plugins** - All JavaScript plugins your front end uses go here
        * **custom** - All custom JavaScript or jQuery should go here
    * **sass** - Default SASS directory (this can also be a less/ directory if your front end uses less).  You should place all of your SCSS or LESS files in this directory.
    * **images** - Place all of the images from your front end into this directory.
    * **fonts** - If your front end uses any custom fonts, you can place the font files in this directory.
* **controllers** - Your custom view controllers go here. Used to pass data to the blade views.
* **core** - This is all of the core theme files.  This is where the magic of the Vanilla theme happens.
* **endpoints** - This is where we place any endpoints that are needed in the theme.  For example, if your theme has a contact form, you will likely create a file in this directory called contact-form.php.
* **views** - All bladed views for the theme are contained here
    * **layouts** - Fundamental layouts of the templates
    * **partials** - Various includes (Header, Footer, etc.)
        * **forms** - This is an optional directory where you can store any form partials
* **shortcodes** - If your theme will have any custom shortcodes, you can place the template files for the shortcodes in this directory.
* **sidebars** - For any custom sidebars, you can place them in this directory.
* **404.php** - the default 404 template for the Vanilla theme.  This can be customized as you see fit.
* **functions.php** - This file behaves just as a functions.php file would behave in any WordPress theme.  You can place any WP customization code here as needed
* **gulpfile.js** - This file is what we use to compile all of the JavaScript and SASS/LESS from the assets directory into the assets/compiled directory
* **package.json** - This file defines the Node.js packages that are required for the gulpfile to work correctly (more on this later)
* **screenshot.png** - This is the screenshot that appears on the theme activation page in wp-admin.  Feel free to replace this with any image you want.
* **theme-config.php** - The config file for Vanilla.  This is where the bulk of the configuration will happen for your theme.
* **style.css** - This is the default stylesheet.  You can update the name of the theme, and the author, in this file.

### Asset Pipeline ###
The Vanilla theme is driven by a gulpfile.js which is included in the root of the theme. By default, Gulp will compile your theme.scss to a theme.css and your Javascript source files in the js/custom and js/plugins folders to theme.js. These two files will automatically be output into the header and footer of each plage using the Vanilla boilerplate.

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

### Templates ###
The Vanilla theme uses the Laravel Blade template engine to power the theme files.  For more details on Blade, you can read the documentation here: https://laravel.com/docs/5.2/blade

#### Layouts ####

For reference, here is the default layout that we use in the theme:
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
Views represent what the user of your site will actually see. For example, your theme will likely have a home page, an about page, a contact page, etc. Each of these pages will use a unique template, and each of these unique templates is what we call a "view". We will turn your static HTML files into a reusable view that will be placed into the views directory of the Vanilla theme. The goal being to convert all of your static HTML files into a dynamic, reusable view.

The default views that are created for you are:
* **404.blade.php** - This replaces the 404.php and will be displayed whenever a page is not found.
* **index.blade.php** - The root view for your site, view is loaded in place of the index.php in the root.
* **page.blade.php** - This replaces the page.php and will be displayed for pages with the default template.
* **single.blade.php** - This replaces the single.php and will be displayed for posts with the default template.
* **test-page.blade.php** - This is a simple custom page template

Other examples of common views in your theme:

Blog index page (a feed of blog posts)
Blog single page (a single blog post)
Blog category page (a feed of blog posts from a specific category)
Search results page
Product page

The most important concept to remember is that we are creating these views so that they are reusable and completely dynamic.  For example, if you have a Product view, it may be re-used to show several different products on the site.

#### Partials ####
In the name of DRY (Don't Repeat Yourself), we place any front end code that is used across more than 1 view into a specific partial.  For example, if both your "Home Page" view and your "Product" view has a newsletter HTML on it, we can copy the code for the newsletter, place it into a partial, and then load the partial in both of the views using:

```
@include('partials/name-of-partial')
```

Any time you find two views using the same block of HTML, you should partial it out into a file in the `partials` directory.  Never have the same code in two different places.

### Controllers ###
Controllers can be used to pass data to a view. A TestController.php is included to demonstrate it's use. Specify what views the controller applies to in the $views array and return the actual data in the process method.

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
@layout('layouts/master')
<?php /* Template Name: About Page Template */ ?>
@section('content')

@wpposts
    <!--  
    your html goes here
    -->
@wpempty
@wpend
```

### Custom Post Types ###
Post Types refer to the data of your WP theme.  Both “Posts” and “Pages” that we just covered, are “post types” within WordPress that are enabled by default.

WordPress gives you the ability to create more post types if your theme requires it.

In many cases, your theme will not require you to create any additional post types, and the post and page post types will fulfill all the needs of your theme.

However, let's assume that the site you are building has other data types.  For example, maybe your site has client testimonials that are displayed in various parts of the site.  Or, if you are building a portfolio on your site, you will have many different portfolio items.  Finally, if you are selling something on your site, you may have a list of products.  In each of those cases, you will need to create a Custom Post Type (CPT) so that you will be able to easily store this data in your theme.

Within the theme-config.php, it is easy to add an additional post type within the loadCustomPostTypes() method. You can reference the WordPress documentation for register_post_type to see what arguments can be added for each custom post type. https://codex.wordpress.org/Function_Reference/register_post_type

### Custom Taxonomies ###
Taxonomies can be used to sort and filter your post types.  By default, WordPress includes the following taxonomies:

Categories - categories, by default, only exist on the "Posts" post type.  Categories allow you to group many posts together.
Tags - tags, by default, also only exists on the "Posts" post type.  Tags also allow you to group many posts together.

The main difference between categories and tags is that categories are hierarchical and tags are not.  This means that categories can have parent and children categories, whereas tags cannot.

In the Post Types section, we explained how you can create "Custom Post Types".  We can also create "Custom Taxonomies" and assign them to the Post Types in the theme which us allows us to filter the posts.  For example, if we have a Products CPT, we may want to be able to filter these Products by their color.  We can create a Custom Taxonomy called "Color" and then assign it to the Products CPT.  This would allow us to then add Colors, and assign them to the products.

Within the theme-config.php, you can create custom taxonomies and assign them to post types within the loadCustomTaxonomies() method.

## Menus ##
Your theme likely has a navigation menu (or two menus, or many).  For example, you may have a menu in the header, and also a menu in the footer.  Menus in WordPress allow you to dynamically control which pages are outputted into the menus.

Within the theme-config.php, you can create and define menus within the setMenus() method.

## Sidebars ##
To define a new custom sidebar widget area, please see the loadSidebars() method in the theme-config.php file.

## Option Panels ##
Within the Vanilla theme, you can create custom Options Panels that will then appear in wp-admin.  You can assign ACF field groups to these option panels.  The purpose of the Options Panels is to give the theme some Global configuration options.  For example, perhaps you want the user to be able to update the logo on the site.  You can create an Options panel called "Header Options", and then create a field group on this Options panel called "Header Logo".  The user will then be able to update the logo dynamically in wp-admin.

Within the theme-config.php, you can create custom options panels within the loadOptionsPanel() method.

## Custom Fields ##
Every custom page template, post type, options panel, custom taxonomy may have additional data associated with it.  For example, on your product posts, you will want to be able to store the color of your product, pricing information, and customer reviews.  Or, on your about us custom page template, you may want to store a group of client testimonials.

For each area on the site where we have custom data to be stored, we will create an Advanced Custom Fields field group, and then create fields that will allow the user to easily update the content on that specific page, post, options panel, or taxonomy.
