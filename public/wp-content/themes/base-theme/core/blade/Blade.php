<?php
namespace BaseTheme\Core\Blade;

/**
 * Uses the Blade templating engine
 */
class Blade {

	/**
	 * Blade engine
	 * @var Blade
	 */
	protected $blade;

	/**
	 * View folder
	 * @var string
	 */
	protected $views;

	/**
	 * Array to store views for custom post types
	 * @var array
	 */
	protected $customPostViews;

	/**
	 * Cache folder
	 * @var string
	 */
	protected $cache;

	/**
	 * Controllers
	 * @var Controllers
	 */
	public $controller;

	/**
	 * Set up hooks and initialize Blade
	 */
	public function __construct($views)
    {
		$this->customPostViews = [];
		$this->views = $views;
		$this->cache = get_template_directory() . '/core/blade/cache';
		$this->controller = new Controllers;

		$this->blade = new \Philo\Blade\Blade($this->views, $this->cache);
		$this->extend();

		// Bind to template include action
		add_action( 'template_include', [ $this, 'bladeInclude' ] );

		// Listen for Buddypress include action
		add_filter( 'bp_template_include', [ $this, 'bladeInclude' ] );
	}

	/**
	 * Include the template
	 * @return string
	 */
	public function bladeInclude( $template )
    {
		if( ! $template )
			return $template; // Noting to do here. Come back later.

		$postTypes = $this->getCustomPostTypes();
		$postType = get_post_type();

		/*
		 * This is where the magic happens. If it's a custom post, load either the
		 * specified single post view or the named blade template from our views folder.
		 *
		 * If it's a single page, load our page template
		 *
		 * Otherwise, load the blade with the $template name
		 */
		if ( in_array($postType, $postTypes) && is_single() ) {
			if (isset($this->customPostViews[$postType])) {
				$view = $this->customPostViews[$postType];
			} else {
				$view = $postType;
			}
		} else if (is_page()) {
			$pageTemplate = get_page_template();
			if ($pageTemplate != '') {
				$view = strstr(basename($pageTemplate), '.', true);
			} else {
				$view = 'page';
			}
		} else if (is_404()) {
			$view = '404';
		} else {
			// get the base name
			$file = basename($template);

			// blade friendly name
			$view = str_replace('.php', '', $file);
		}

		// Find controllers for this view
		$controller = $this->getController($view);

		// Compile and output the blade, with the attached controller's data if it exists
		echo $this->blade->view()->make($view)->with([ 'data' => $controller ? $controller->process() : [] ])->render();

		// halt including
		return '';
	}

	/**
	 * Simple helper function to render a specific view with passed data
	 */
	public function view($view, $attributes)
	{
		return $this->blade->view()->make($view)->with($attributes);
	}

	/**
	 * Registers a view for a specific custom post type
	 * to be used in place of default view with the same
	 * name as the custom post type
	 */
	public function registerCustomPostView($postType, $view)
	{
		$this->customPostViews[$postType] = $view;
	}

	/**
	 * Check if the view has a controller which can be attached
	 * @param  string $view The view name
	 * @return mixed A controller instance or false
	 */
	protected function getController($view)
	{
		foreach($this->controller->getControllers() as $controller) {
			if(in_array($view, $controller->getViews())) {
				return $controller;
			}
		}
		return false;
	}

	/**
	 * Extend blade
	 * @return void
	 */
	protected function extend()
    {
		// add @acfrepeater
		$this->blade->getCompiler()->extend(function($view, $compiler) {
			if(!function_exists('get_field')) {
				return $view;
			}
		    $pattern = '/(\s*)@acf\(((\s*)(.+))\)/';
			$replacement = '$1<?php if ( have_rows( $2 ) ) : ';
			$replacement .= 'while ( have_rows( $2 ) ) : the_row(); ?>';

		    return preg_replace($pattern, $replacement, $view);
		});

		// add @acfempty
		$this->blade->getCompiler()->extend(function($view, $compiler) {
		    return str_replace('@acfempty', '<?php endwhile; ?><?php else: ?>', $view);
		});

		// add @acfend
		$this->blade->getCompiler()->extend(function($view, $compiler) {
			if(!function_exists('get_field')) {
				return $view;
			}
		    return str_replace('@acfend', '<?php endif; ?>', $view);
		});

		// add @subfield
		$this->blade->getCompiler()->extend(function($view, $compiler) {
			if(!function_exists('get_field')) {
				return $view;
			}
		    $pattern = '/(\s*)@subfield\(((\s*)(.+))\)/';
			$replacement = '$1<?php if ( get_sub_field( $2 ) ) : ';
			$replacement .= 'the_sub_field($2); endif; ?>';

		    return preg_replace($pattern, $replacement, $view);
		});

		// add @field
		$this->blade->getCompiler()->extend(function($view, $compiler) {
			if(!function_exists('get_field')) {
				return $view;
			}
		    $pattern = '/(\s*)@field\(((\s*)(.+))\)/';
			$replacement = '$1<?php if ( get_field( $2 ) ) : ';
			$replacement .= 'the_field($2); endif; ?>';

		    return preg_replace($pattern, $replacement, $view);
		});

		// add @hasfield
		$this->blade->getCompiler()->extend(function($view, $compiler) {
			if(!function_exists('get_field')) {
				return $view;
			}
		    $pattern = '/(\s*)@hasfield\(((\s*)(.+))\)/';
			$replacement = '$1<?php if ( get_field( $2 ) ) : ?>';

		    return preg_replace($pattern, $replacement, $view);
		});

		// add @wpposts
		$this->blade->getCompiler()->extend(function($view, $compiler) {
		    return str_replace('@wpposts', '<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>', $view);
		});

		// add @wpquery
		$this->blade->getCompiler()->extend(function($view, $compiler) {
		    $pattern = '/(\s*)@wpquery(\s*\(.*\))/';
			$replacement  = '$1<?php $bladequery = new WP_Query$2; ';
			$replacement .= 'if ( $bladequery->have_posts() ) : ';
			$replacement .= 'while ( $bladequery->have_posts() ) : ';
			$replacement .= '$bladequery->the_post(); ?> ';

			return preg_replace( $pattern, $replacement, $view );
		});

		// add @wpempty
		$this->blade->getCompiler()->extend(function($view, $compiler)
		{
		    return str_replace('@wpempty', '<?php endwhile; ?><?php else: ?>', $view);
		});

		// add @wpend
		$this->blade->getCompiler()->extend(function($view, $compiler)
		{
		    return str_replace('@wpend', '<?php endif; wp_reset_postdata(); ?>', $view);
		});

		// add @scripts
		$self = $this;
		$this->blade->getCompiler()->directive('scripts', function($expression) use ($self) {
            return '<?php '. get_class($self) .'::add_scripts('.$expression.'); ?>';
        });

		// add @asset
		$this->blade->getCompiler()->extend(function($view, $compiler) {
			$pattern = '/(\s*)@asset(\s*\(.*\))/';
			$replacement = '$1<?php Helper::asset($2); ?>';

			return preg_replace($pattern, $replacement, $view);
		})
	}

	/**
	 * Adds scripts added via the scripts directive
	 * @param array $scripts
	 */
	public static function addScripts($scripts)
    {
		add_action('wp_enqueue_scripts', function() use($scripts) {
			foreach($scripts as $script) {
				$name = basename($script);
				$slug = sanitize_title($name);
				wp_enqueue_script( $slug, get_template_directory_uri() . '/' . $script, [ 'jquery' ]);
			}
		});
	}

	private function getCustomPostTypes()
	{
		$args = [
   			'public'   => true,
   			'_builtin' => false
		];

		$output = 'names'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'

		$postTypes = get_post_types( $args, $output, $operator );

		return $postTypes;
	}
}
