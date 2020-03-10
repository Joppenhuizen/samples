<?php
function loc_save_postdata($post_id)
{
    if (array_key_exists('straatnaam', $_POST)) {
    	$straatnaam = sanitize_text_field($_POST['straatnaam']);
        update_post_meta(
            $post_id,
            '_straatnaam',
            $straatnaam
        );
    }
    if (array_key_exists('huisnummer', $_POST)) {
    	$huisnummer = sanitize_text_field($_POST['huisnummer']);
        update_post_meta(
            $post_id,
            '_huisnummer',
            $huisnummer
        );
    }
    if (array_key_exists('url', $_POST)) {
    	$url = esc_url_raw($_POST['url']);
        update_post_meta(
            $post_id,
            '_url',
            $url
        );
    }

 	$post_type = get_post_type($post_id);
 	if ( "locaties" == $post_type )
 	{
		$corarray = geocode($_POST['straatnaam'].' '.$_POST['huisnummer']);
		if ( metadata_exists( 'post', $post_id, '_lat' ) ) {
		   update_post_meta($post_id, '_lat', $corarray['latitude']);
		   update_post_meta($post_id, '_long', $corarray['longitude']);
		}
		else
		{
		   add_post_meta($post_id, '_lat', $corarray['latitude'], true);
		   add_post_meta($post_id, '_long', $corarray['longitude'], true);
		}
 	}
}
add_action('save_post', 'loc_save_postdata');


function geocode($string){
   	$string = urlencode($string);
   	$details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$string.",Amsterdam&key=AIzaSyCfFr0s52wR6Jqmw3ugScRO33aktlRtoJY";
 
	$request = wp_remote_get($details_url);

	if( is_wp_error( $request ) ) {
		return false;
	}

	$body = wp_remote_retrieve_body( $request );
	$response = json_decode( $body , true);

	$geometry = $response['results'][0]['geometry'];

	$array = array(
	    'latitude' => $geometry['location']['lat'],
	    'longitude' => $geometry['location']['lng'],
	    'location_type' => $geometry['location_type'],
	);

	return $array;
}
?>



