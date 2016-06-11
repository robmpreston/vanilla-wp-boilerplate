<?php
/**
*
* Main plugin class
* @package Blade
*/

/**
* Main controller
*/
class WP_Blade_Main_Controller
{
	/**
	 * Main model
	 */
	private $mainModel;

	/**
	 * Constructor
	 */
	function __construct()
	{

		// Instantiate main model
		$this->mainModel = new WP_Blade_Main_Model();

		// Bind to template include action
		add_action( 'template_include', array( $this->mainModel, 'template_include_blade' ) );

		// Listen for Buddypress include action
		add_filter( 'bp_template_include', array( $this->mainModel, 'get_query_template' ));

	}

	public function registerCustomPostView($postType, $view)
	{
		$this->mainModel->registerCustomPostView($postType, $view);
	}


	/**
	 * Return a new class instance.
	 * @return { obj } class instance
	 */
	public static function make()
	{

		return new self();
	}

}
