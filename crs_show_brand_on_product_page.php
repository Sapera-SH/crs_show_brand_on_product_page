<?php
	/*
	Plugin Name: Cloud Retail Systems A/S - Show brand on product page
	Plugin URI: http://cloudretailsystems.dk
	Description: Show brand on product page based on categories using this shortcode: [crs_brand].
	Author: Cloud Retail Systems A/S - Søren Højby
	Version: 1.0
	Author URI: http://cloudretailsystems.dk
	*/

	function get_brand_shortcode() {
		/*
		 * Get Brand name with link and put it into a shortcode.
		 * Inspiration: https://wordpress.stackexchange.com/questions/101268/display-all-the-subcategories-from-a-specific-category
		 */
		global $post;

		$terms = get_the_terms( $post->ID, 'product_cat', 'hide_empty=0');
		$IDbyNAME = get_term_by('name', "Mærker", 'product_cat');
		$product_cat_ID = $IDbyNAME->term_id;
		$args = array(
			'hierarchical' => 0,
			'show_option_none' => '',
			'hide_empty' => 0,
			'parent' => $product_cat_ID,
			'taxonomy' => 'product_cat'
		);
		foreach (get_categories($args) as $sc) {

			foreach ( $terms as $term ){
				if($term->slug ==$sc->slug){
					$link = get_term_link( $sc->slug, $sc->taxonomy );
					$data .= '<a href="'. $link .'" class="crs_brand" title="'.$sc->name.'" rel="nofollow">'.$sc->name.'</a></li>';
				}
			}
		}
		return $data;
	}

	add_shortcode('crs_brand', 'get_brand_shortcode');