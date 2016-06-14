<?php
/**
*
* Main plugin model
* @package Blade
*/

/**
* Main model
*/
class WP_Blade_Main_Model {

	/**
	 * Return a new class instance
	 * @return { obj } class instance
	 */
	public static function make() {

		return new self();
	}

	/**
	 * Array to store views for custom post types
	 * @var array
	 */
	protected $customPostViews;

	/**
	 * Blade template
	 */
	protected $bladedTemplate;


	public function __construct()
    {
		$this->customPostViews = array();
	}

	/**
	 * Handle the compilation of the templates
	 * @param { str } template path
	 * @return { str } compiled template path
	 */
	public function template_include_blade( $template ) {

		if( $this->bladedTemplate )
			return $this->bladedTemplate;
		if( ! $template )
			return $template; // Noting to do here. Come back later.

		$postTypes = $this->getCustomPostTypes();
		$postType = get_post_type();

		// blade friendly name
		$viewFile = str_replace('.php', '', basename($template));

		/*
		 * This is where the magic happens. If it's a custom post, load either the
		 * specified single post view or the named blade template from our views folder.
		 *
		 * If it's a single page, load our page template
		 *
		 * Otherwise, load the blade with the $template name
		 */
		if ( in_array($postType, $postTypes) && is_single() ) {
			$viewFile = isset($this->customPostViews[$postType]) ? $this->customPostViews[$postType] : $postType;
		} else if (is_page()) {
			$viewFile = get_page_template() != '' ? strstr(basename($template), '.', true) : 'page';
		} else if (is_404()) {
			$viewFile = '404';
		}

		require_once( WP_BLADE_CONFIG_PATH . 'paths.php' );
		Laravel\Blade::sharpen();

		$view = Laravel\View::make( $viewFile, array() );
		$pathToCompiled = Laravel\Blade::compiled( $view->path );

		if ( ! file_exists( $pathToCompiled ) or Laravel\Blade::expired( $view->view, $view->path ) )
			file_put_contents( $pathToCompiled, "<?php // $template ?>\n".Laravel\Blade::compile( $view ) );

		$view->path = $pathToCompiled;

		return $this->bladedTemplate = $view->path;

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
	* Return a call of templateinclude blade passing template path.
	* @param { str }
	* @return { str } path of the compiled view
	*/
	function get_query_template( $template ) {

		return $this->template_include_blade( $template );
	}

	/**
	 * Get a list of custom post types registered within WP
	 */
	private function getCustomPostTypes()
	{
		$args = array(
   			'public'   => true,
   			'_builtin' => false
		);

		$output = 'names'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'

		$postTypes = get_post_types( $args, $output, $operator );

		return $postTypes;
	}
}
