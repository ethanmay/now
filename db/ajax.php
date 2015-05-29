<?php

include_once "init.php";
include_once "functions.php";

$network = $_REQUEST["network"];

if( $_REQUEST["import_io"] == 'true' ) {
	
	// if new network, create network in db
	$network_id = $db->get_var( "SELECT id FROM networks WHERE network = '$network'" );
	if( !$network_id ) {
		$db->query( "INSERT INTO networks( network ) VALUES ( '$network' )" );
		$network_id = $db->insert_id;
	}

	// query import.io
	$news = import_news_by_network( $network );
	
	// convert result to object
	$results = (object) $news->results;

	// loop through results and store headline url
	foreach( $results as $result ) {
		$headline_text = $result->{'headline/_text'};

		for( $i = 0; $i < count( $headline_text ); $i++ ) {

			// if headline word count is less than 2
			if( count( explode( ' ', $headline_text[$i] ) ) > 2 ) {

				// if headline doesn't contain the following words
				if( preg_match( '[\/photo\/|\/photos\/|\/video\/|\/videos\/|\/posttv\/]', $result->headline[$i] ) == 0 ) {
					store_news_by_url( $result->headline[$i], $network_id );
				}
			}
		}
	}
}
else {

	if( $_REQUEST["network"] == 'all' ) {
		$network_news = get_news_by_network( $network );
		$content = '';

		$network_news = json_decode(json_encode($network_news), FALSE);

		foreach( $network_news as $key => $news ){

			if( $news ) {
				foreach( $news as $headline ) {
					$headline_id = $headline->id;
					$image = $db->get_row( "SELECT image, image_alt FROM images WHERE headline_id = $headline_id" );
					$image_src = $image->image;
					$image_alt = $image->image_alt;
					$description = $headline->description;

					$content .= '<div class="story-ctn">';
						if( $image ) {
							$content .= '<div class="image-ctn">';
								$content .= '<img src="'. $image_src .'" alt="'. $image_alt .'" />';
							$content .= '</div>';
						}
						$content .= '<p><b>'. $headline->content .'</b></p>';
						if( $description ) {
							$content .= '<div class="desc-ctn">';
								$content .= '<p>'. $description .'</p>';
							$content .= '</div>';
						}
					$content .= '</div>';
				}

				$network_news->$key = $content;
				$content = '';
			}
		}

		echo json_encode( $network_news );
	}
	else {
		$news = get_news_by_network( $network );

		foreach( $news as $headline ) {
			$headline_id = $headline->id;
			$image = $db->get_row( "SELECT image, image_alt FROM images WHERE headline_id = $headline_id" );
			$image_src = $image->image;
			$image_alt = $image->image_alt;
			$description = $headline->description;

			echo '<div class="story-ctn">';
				if( $image ) {
					echo '<div class="image-ctn">';
						echo '<img src="'. $image_src .'" alt="'. $image_alt .'" />';
					echo '</div>';
				}
				echo '<p><b>'. $headline->content .'</b></p>';
				if( $description ) {
					echo '<div class="desc-ctn">';
						echo '<p>'. $description .'</p>';
					echo '</div>';
				}
			echo '</div>';
		}
	}
}

?>