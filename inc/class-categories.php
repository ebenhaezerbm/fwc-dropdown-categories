<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * FWC Dropdown Categories Class.
 */
class FWCDropdownCategories {
	
	/* constructor */
	function __construct() {
		$this->init();

		$this->includes();
	}

	public function init() 
	{
		add_action( 'wp_ajax_dropdown_categories', array($this, 'dropdown_categories_ajax_callback') );
		add_action( 'wp_ajax_nopriv_dropdown_categories', array($this, 'dropdown_categories_ajax_callback') );
	}

	public function dropdown_categories_ajax_callback() 
	{
		$search = ( isset($_GET['q']) && !empty($_GET['q']) ) ? sanitize_text_field( $_GET['q'] ) : '';     
		$page = ( isset($_GET['page']) && !empty($_GET['page']) ) ? intval( $_GET['page'] ) : 1;
		$limit = 20;
		$offset = ($page * $limit) - $limit;

		$taxonomy = 'category';

		$args = array(
			'search' => $search, 
			'hide_empty' => false, 
			'orderby' => 'name', 
			'order' => 'ASC', 
			'offset' => $offset, 
			'number' => $limit 
		);

		$terms = get_terms($taxonomy, $args);
		$total_count = wp_count_terms($taxonomy, $args);

		$response = [];
		if( $terms )
		{
			foreach ($terms as $term) 
			{
				$response[] = array(
						'id' => $term->term_id,
						'name' => $term->name,
						'taxonomy' => 'Category'
					);
			}
		}

		$response['total_count'] = $total_count;
		$response['item_per_page'] = $limit;

		wp_send_json_success($response);
	}

	public function includes() {}

}

return new FWCDropdownCategories();