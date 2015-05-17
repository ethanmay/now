<?php

include_once "init.php";
include_once "functions.php";

$network = $_REQUEST["network"];

if( $_REQUEST["import_io"] == 'true' ) {
	// query import.io

	$news = import_news_by_network( $network );

	if( $network == 'all' ){

		store_all_news( $news );
	}
	else {
		// if new network, create network in db
		$network_id = $db->get_var( "SELECT id FROM networks WHERE network = '$network'" );
		if( !$network_id ) {
			$db->query( "INSERT INTO networks( network ) VALUES ( '$network' )" );
			$network_id = $db->insert_id;
		}

		store_news_by_network( $news->results, $network_id );
	}
	
	// get_sentiments( $parsed );
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