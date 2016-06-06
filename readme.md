# Vanilla WP Boilerplate
## Introduction
Vanilla WP Boilerplate is a boilerplate designed to simplify the process of taking static HTML/CSS and template it out into a custom WordPress theme.

## Table of contents ##
* [Installation](#installation)
* [What's Included](#whats-included)
* [Directory Structure](#directory-structure)

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
cd public/wp-content/themes/base-theme
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

## Theme Components ##

### Templates ###

### Controllers ###

### Custom Page Templates ###

### Custom Post Types
