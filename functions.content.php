<?php

//доавлем
add_filter( 'pre_post_tax_input', 'no_tax_input_create' );

function no_tax_input_create($tax_input) {
	global $wpdb, $table_prefix;
	if( !isset($tax_input['post_tag']) )
		return $tax_input;
	$output = array();
	foreach( $tax_input['post_tag'] as $tag ) {
		if (term_exists($tag, 'post_tag')) {
			$tag_name = $wpdb->get_results("SELECT *  FROM ".$table_prefix."terms WHERE term_id = " . $tag);
			if(!empty($tag_name)){
				$output[] = $tag_name['0']->name;
			} else
				$output[] = $tag;
		unset($tag_name);
		}
	}
	$tax_input['post_tag'] = implode(',',$output);
	return $tax_input;
}
