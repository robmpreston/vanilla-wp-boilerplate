<?php
namespace BaseTheme\Core\Blade;

/**
 * Logic Controller
 */
class Controller {

	/**
	 * Defines which views the controller will send data to
	 * @var array
	 */
	protected $views = [];

	/**
	 * Constructor
	 */
	public function __construct(){}

	/**
	 * Handles the logic
	 * @return array Should always return an array of data
	 */
	public function process() {
		return [];
	}

	/**
	 * Get the views
	 * @return array
	 */
	public function getViews() {
		return $this->views;
	}

}
