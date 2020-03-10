<?php

function artiestenwidget()
{

	$the_query = new WP_Query( array( 
		'post_type' => 'artiesten',
		'posts_per_page' => -1,
		'nopaging' => true,
		'meta_key' => '_zoekletter',
		'orderby' => 'meta_value',
		'order' => 'ASC',
	) ); 

	if ( $the_query->have_posts() ) {
		$html = '<div class="artiesten-zoeken-char">';
		$letters = range('A', 'Z');
		foreach($letters as $letter)
		{
			$html .= '<div class="artiesten-zoeken-letter">'.esc_html($letter).'</div>';
		}
		$html .= '</div>';
		$html .= '<div class="artiesten-list-container">';
		$html .= '<div class="artiesten-list-img"><div class="artiesten-list-img-con"><img class="art-thumb-img" id="artiest-widget-img" src="'.esc_url(get_the_post_thumbnail_url($the_query->posts[0]->ID)).'" alt="'.esc_attr(get_post_meta(get_post_thumbnail_id( $the_query->posts[0]->ID ), '_wp_attachment_image_alt', true)).'"/></div></div>';
		$html .= '<div class="artiesten-list-nav"><i class="fa fa-angle-up next"></i><i class="fa fa-angle-down prev"></i></div>';

		$html .= '<div class="artiesten-list">';
   		while ( $the_query->have_posts() ) {
	    	$the_query->the_post();
				$lettermeta = get_post_meta(get_the_ID(), '_zoekletter', true);
		    	if(! empty ($lettermeta))
		    	{
		    		$letter = $lettermeta;
		    	}
				$html .= '<div class="artiest-list-item" data-image="'.esc_url(get_the_post_thumbnail_url()).'" data-alt="'.esc_attr(get_post_meta(get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true)).'" data-id="'.esc_attr(get_the_ID()).'" data-letter="'.esc_attr($letter).'">';
				$html .= '<a href="'.esc_url(get_permalink()).'">'.esc_html(get_the_title()).'</a>';
				$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		wp_reset_postdata();
	} 
	wp_enqueue_script( 'artiestenwidget');
	
	return $html;
}
add_shortcode( 'artiestenwidget', 'artiestenwidget' );

?>