<?php

/**
 * query_import_io
 * Query Import.io Data.
 * 
 * @param  string
 * @param  array( string => string )
 * @return object
 */
function query_import_io( $connectorGuid, $input ) {

	$userGuid = "49b192ae-ac72-452a-8a94-0b096524c9a5";
	$apiKey = "49b192ae-ac72-452a-8a94-0b096524c9a5:STaiZOPCSj+ldR7+/8J7QlXTHlg0wzoulud2/O+HkWOtplNF/R6wkqV7XPn/4shWfg/gMT2XbQse/gjicxUpAw==";
	$url = "http://query.import.io/store/connector/" . $connectorGuid . "/_query?_user=" . urlencode( $userGuid ) . "&_apikey=" . urlencode( $apiKey );

	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
		"import-io-client: import.io PHP client",
		"import-io-client-version: 2.0.0"
	));
	curl_setopt( $ch, CURLOPT_POSTFIELDS,  json_encode( array("input" => $input) ) );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_HEADER, 0 );
	$result = curl_exec( $ch );
	curl_close( $ch );

	return json_decode($result);
}

/**
 * import_news_by_network
 * Gets news from import.io based on netowrk.
 * 
 * @param  string $network
 * @return object
 */
function import_news_by_network( $network ) {

	switch( $network ) {

		case 'abc':
			$result = query_import_io( "590a4436-2be2-4e6b-9686-b17e8db00b29", array( "webpage/url" => "http://abcnews.go.com/" ) );
			break;
		case 'aljazeera':
			$result = query_import_io( "6c05b191-b04c-458d-aa58-ec6f0b023d75", array( "webpage/url" => "http://america.aljazeera.com/" ) );
			break;
		case 'bbc':
			$result = query_import_io( "0d6d38e8-c537-428f-82d4-28ea5716abf5", array( "webpage/url" => "http://www.bbc.com/news" ) );
			break;
		case 'cnn':
			$result = query_import_io( "c6d0891f-9c20-4fe8-aba4-c7b870af899f", array( "webpage/url" => "http://www.cnn.com/" ) );
			break;
		case 'fox':
			$result = query_import_io( "f675c84d-6805-4e5f-86c1-06c77fae846d", array( "webpage/url" => "http://www.foxnews.com/" ) );
			break;
		case 'google':
			$result = query_import_io( "56104162-a61e-4656-810f-1ff839e0f6cf", array( "webpage/url" => "http://news.google.com/" ) );
			break;
		case 'frontline':
			$result = query_import_io( "216ad870-d7af-400e-812b-bc6f19b8b79c", array( "webpage/url" => "http://www.pbs.org/wgbh/pages/frontline/" ) );
			break;
		case 'newrepublic':
			$result = query_import_io( "eb09b2ab-d56a-4820-8eb7-58fc6a1e8e3c", array( "webpage/url" => "http://www.newrepublic.com/" ) );
			break;
		case 'huffpost':
			$result = query_import_io( "1643e164-c2d8-4e32-a28c-bc1cbd34f11e", array( "webpage/url" => "http://www.huffingtonpost.com/" ) );
			break;
		case 'nytimes':
			$result = query_import_io( "52fad557-8a42-4213-85f8-6ef99e0fb272", array( "webpage/url" => "http://www.nytimes.com/" ) );
			break;
		case 'npr':
			$result = query_import_io( "4c4f7281-0e4e-4048-b0ed-97ffbf60ec8c", array( "webpage/url" => "http://www.npr.org/" ) );
			break;
		case 'usatoday':
			$result = query_import_io( "6a99efdf-2ed6-4c8d-90a0-8d6179061c3d", array( "webpage/url" => "http://www.usatoday.com/" ) );
			break;
		case 'msnbc':
			$result = query_import_io( "34497626-6da0-480a-a813-e763ad42a2d9", array( "webpage/url" => "http://www.msnbc.com/" ) );
			break;
		case 'wpost':
			$result = query_import_io( "1f1590c4-8d67-43c6-974c-67b9166102b1", array( "webpage/url" => "http://www.washingtonpost.com/" ) );
			break;
		// case 'reddit':
		// 	$result = query_import_io( "f516096f-4d02-4aab-84bb-1e2f7687360d", array( "webpage/url" => "http://www.reddit.com/" ) );
		// 	break;
		// case 'reddit_top':
		// 	$result = query_import_io( "24db1886-24be-488e-a803-877b8fe056f4", array( "webpage/url" => "http://www.reddit.com/top/" ) );
		// 	break;
		// case 'wired':
		// 	$result = query_import_io( "dea122bd-4535-473e-959a-604f9398d57c", array( "webpage/url" => "http://www.wired.com/" ) );
		// 	break;
		default:
			error_log( 'way to break it' );
			break;
	}

	return $result;
}

/**
 * get_news_by_network
 * Get all news results from DB.
 * 
 * @param  int
 * @return array( object )
 */
function get_news_by_network( $network_id ) {
	
	global $db;

	$news = $db->get_results( "SELECT id, content, url, sentiment, date_published FROM headlines WHERE network_id = $network_id LIMIT 30" );

	return $news;
}

/**
 * store_news_by_url
 * Store news results in db.
 * 
 * @param  string
 * @param  int
 */
function store_news_by_url( $news_link, $network_id ) {

	global $db;

	if( $news_link ) {

		include_once './alchemyapi.php';

		$alchemyapi = new AlchemyAPI();

		$options = array(
			'extract' => 'title, pub-date, page-image, taxonomy, entity, keyword, concept',
			'linkedData' => 0,
			'quotations' => 1,
			'sentiment'  => 1
		);

		$alchemy = $alchemyapi->combined( 'url', $news_link, $options );
		$data = (object) $alchemy;

		// Title
		$title = $data->title;
		$title = $db->escape( $title );

		// Publication Date
		$pub_date = $data->publicationDate['date'];
		$pub_date = strtotime( $pub_date );
		$pub_date = date( 'Y-m-d H:i:s', $pub_date );

		// Overall Sentiment
		$sentiment = $alchemyapi->sentiment( 'url', $news_link, null );
		$sentiment = (object) $sentiment;
		$sentiment = round( $sentiment->docSentiment['score'], 2 );

		$db->query( "INSERT INTO headlines( network_id, url, content, sentiment, date_published ) VALUES ( '$network_id', '$news_link', '$title', '$sentiment', '$pub_date' )" );
		$headline_id = $db->insert_id;

		// Image
		$image = $data->image;
		$image = $db->escape( $image );
		$db->query( "INSERT INTO images( headline_id, url ) VALUES ( '$headline_id', '$image' )" );

		// Keywords
		$keywords = $data->keywords;
		foreach( $keywords as $keyword ) {
			$keyword = (object) $keyword;
			$text = $keyword->text;
			$text = $db->escape( $text );
			$relevance = round( $keyword->relevance, 2 );
			$sentiment = round( $keyword->sentiment['score'], 2 );
			$keyword_id = $db->get_var( "SELECT id FROM keywords WHERE content = '$text'" );
			if( !$keyword_id ) {
				$db->query( "INSERT INTO keywords( content ) VALUES ( '$text' )" );
				$keyword_id = $db->insert_id;
			}
			$db->query( "INSERT INTO link_keywords( headline_id, keyword_id, relevance, sentiment ) VALUES ( '$headline_id', '$keyword_id', '$relevance', '$sentiment' )" );
		}

		// Concepts
		$concepts = $data->concepts;
		foreach( $concepts as $concept ) {
			$concept = (object) $concept;
			$text = $concept->text;
			$text = $db->escape( $text );
			$relevance = round( $concept->relevance, 2 );
			$concept_id = $db->get_var( "SELECT id FROM concepts WHERE content = '$text'" );
			if( !$concept_id ) {
				$db->query( "INSERT INTO concepts( content ) VALUES ( '$text' )" );
				$concept_id = $db->insert_id;
			}
			$db->query( "INSERT INTO link_concepts( headline_id, concept_id, relevance ) VALUES ( '$headline_id', '$concept_id', '$relevance' )" );
		}

		// Entities
		$entities = $data->entities;
		foreach( $entities as $entity ) {
			$entity = (object) $entity;
			$text = $entity->text;
			$text = $db->escape( $text );
			$count = $entity->count;
			$type = $entity->type;
			$type = $db->escape( $type );
			$relevance = round( $entity->relevance, 2 );
			$sentiment = round( $entity->sentiment['score'], 2 );
			$entity_id = $db->get_var( "SELECT id FROM entities WHERE content = '$text'" );
			if( !$entity_id ) {
				$db->query( "INSERT INTO entities( type, content ) VALUES ( '$type', '$text' )" );
				$entity_id = $db->insert_id;
			}
			$db->query( "INSERT INTO link_entities( headline_id, entity_id, appear_count, relevance, sentiment ) VALUES ( '$headline_id', '$entity_id', '$count', '$relevance', '$sentiment' )" );

			// Quotations
			if( $entity->quotations ) {
				$quotation = (object) $entity->quotations[0];
				$text = $quotation->quotation;
				$text = $db->escape( $text );
				$sentiment = round( $quotation->sentiment['score'], 2 );
				$db->query( "INSERT INTO quotations( headline_id, content, sentiment ) VALUES ( '$headline_id', '$text', '$sentiment' )" );
			}
		}

		// Taxonomies
		$taxonomies = $data->taxonomy;
		foreach( $taxonomies as $taxonomy ) {
			$taxonomy = (object) $taxonomy;

			// Heirarchical taxonomies
			$labels = explode( '/', $taxonomy->label );
			for( $i = 0; $i < count( $labels ); $i++ ) {
				// parent
				if( $i == 1 ) {
					$text = $labels[$i];
					$text = $db->escape( $text );
					$parent_id = $db->get_var( "SELECT id FROM taxonomies WHERE content = '$text'" );
					if( !$parent_id ) {
						$db->query( "INSERT INTO taxonomies( content ) VALUES ( '$text' )" );
						$parent_id = $db->insert_id;
					}
				}
				// children
				else if( $i > 1 ) {
					$text = $labels[$i];
					$text = $db->escape( $text );
					$child_id = $db->get_var( "SELECT id FROM taxonomies WHERE ancestor_id = '$parent_id' AND content = '$text'" );
					if( !$child_id ) {
						$db->query( "INSERT INTO taxonomies( ancestor_id, content ) VALUES ( '$parent_id', '$text' )" );
						$child_id = $db->insert_id;
						$parent_id = $child_id;
					}
				}
			}

			$relevance = round( $taxonomy->score, 2 );

			if( !$child_id ) {
				$db->query( "INSERT INTO link_taxonomies( headline_id, taxonomy_id, relevance ) VALUES ( '$headline_id', '$parent_id', '$relevance' )" );
			}
			else {
				$db->query( "INSERT INTO link_taxonomies( headline_id, taxonomy_id, relevance ) VALUES ( '$headline_id', '$child_id', '$relevance' )" );
			}
		}
	}

	return false;
}

/**
 * prepare_news_for_storage
 * Filter out bad headlines, store each result.
 * 
 * @param  object
 */
function prepare_news_for_storage( $results ) {

	foreach( $results as $result ) {
		$headline_text = $result->{'headline/_text'};

		if( is_array( $headline_text ) ) {

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
		else {
			// if headline word count is less than 2
			if( count( explode( ' ', $headline_text ) ) > 2 ) {

				// if headline doesn't contain the following words
				if( preg_match( '[\/photo\/|\/photos\/|\/video\/|\/videos\/|\/posttv\/]', $result->headline ) == 0 ) {
					store_news_by_url( $result->headline, $network_id );
				}
			}
		}
	}
}

/**
 * recurse_ancestors
 * Recurse through ancestors and built taxonomy string
 * 
 * @param  string
 * @param  int
 * 
 * @return string
 */
function recurse_ancestors( $parent_text, $taxonomy_id ) {

	global $db;

	if( $taxonomy_id != 0 ) {
		$ancestor_id = $db->get_var( "SELECT ancestor_id FROM taxonomies WHERE id = $taxonomy_id" );
		$parent_text .= $db->get_var( "SELECT content FROM taxonomies WHERE id = $ancestor_id" ) . ' > ';
		return recurse_ancestors( $parent_text, $ancestor_id );
	}
	else {
		return $parent_text;
	}
}

/**
 * display_news
 * Displays news on front end.
 * 
 * @param  object
 */
function display_news( $news ) {

	global $db;

	foreach( $news as $headline ) {

		// get headline info
		$headline_id = $headline->id;
		$text = $headline->content;
		$url = $headline->url;
		$date = date( 'l, M j, Y', strtotime( $headline->date_published ) );

		// get image info
		$image = $db->get_var( "SELECT url FROM images WHERE headline_id = $headline_id" );

		// get concept info
		$concepts = $db->get_results( "SELECT concept_id, relevance FROM link_concepts WHERE headline_id = $headline_id", OBJECT );

		// get entities info
		$entities = $db->get_results( "SELECT entity_id, appear_count, relevance, sentiment FROM link_entities WHERE headline_id = $headline_id ORDER BY appear_count DESC", OBJECT );

		// get keyword info 
		$keywords = $db->get_results( "SELECT keyword_id, relevance, sentiment FROM link_keywords WHERE headline_id = $headline_id", OBJECT );

		// get taxonomy info
		$taxonomies = $db->get_results( "SELECT taxonomy_id, relevance FROM link_taxonomies WHERE headline_id = $headline_id", OBJECT );

		// get quotations info
		$quotations = $db->get_results( "SELECT content, sentiment FROM quotations WHERE headline_id = $headline_id", OBJECT );

		echo '<div class="story-ctn">';
			echo '<p class="date">'. $date .'</p>';
			if( $image ) {
				echo '<div class="image-ctn">';
					if( $headline->sentiment < 0 ) {
						echo '<div class="overall-sentiment negative tool-right" data-tooltip="'. $headline->sentiment * -100 .'% negative sentiment">';
							echo $headline->sentiment * -100 .'%';
						echo '</div>';
					}
					else if( $headline->sentiment == 0 ) {
						echo '<div class="overall-sentiment neutral tool-right" data-tooltip="neutral sentiment">';
							echo 'neutral';
						echo '</div>';
					}
					else {
						echo '<div class="overall-sentiment positive tool-right" data-tooltip="'. $headline->sentiment * 100 .'% positive sentiment">';
							echo $headline->sentiment * 100 .'%';
						echo '</div>';
					}
					echo '<a href="'. $url .'" target="_blank"><img src="'. $image .'" alt="'. $text .'" /></a>';
				echo '</div>';
			}
			echo '<p><a href="'. $url .'" target="_blank"><b>'. $text .'</b></a></p>';
			echo '<ul class="meta cf">';
				if( $concepts ) {
					echo '<li id="concepts" class="tool-bottom" data-tooltip="'. count( $concepts ) .' concepts">';
					echo file_get_contents("../images/concepts.svg");
						echo '<ul class="concepts">';
							echo '<li><b>Concetps by relevance</b></li>';
							foreach( $concepts as $concept ) {
								$concept_id = $concept->concept_id;

								$relevance = $concept->relevance;
								$text = $db->get_var( "SELECT content FROM concepts WHERE id = $concept_id" );

								echo '<li class="tool-right" data-tooltip="'. $relevance * 100 .'% relevant">';
									echo $text;
								echo '</li>';
							}
						echo '</ul>';
					echo '</li>';
				}
				if( $entities ) {
					echo '<li id="entities" class="tool-bottom" data-tooltip="'. count( $entities ) .' entities">';
						echo file_get_contents("../images/entities.svg");
						echo '<ul class="entities">';
							echo '<li><b>Entities by appearance count</b></li>';
							foreach( $entities as $entity ) {
								$entity_id = $entity->entity_id;
								$entity_content = $db->get_results( "SELECT type, content FROM entities WHERE id = $entity_id", OBJECT );
								$tooltip = '<ul class="info">';
									$tooltip .= '<li>';
										$type = preg_split('/(?=[A-Z])/', $entity_content[0]->type);
										$type = implode( ' ', $type );
										$tooltip .= $type;
									$tooltip .= '</li>';
									$tooltip .= '<li>';
										$tooltip .= $entity->appear_count .' appearances';
									$tooltip .= '</li>';
									$tooltip .= '<li>';
										$tooltip .= $entity->relevance * 100 .'% relevant';
									$tooltip .= '</li>';
									if( $entity->sentiment < 0 ) {
										$tooltip .= '<li class="sentiment negative">';
											$tooltip .= $entity->sentiment * -100 .'% negative sentiment';
										$tooltip .= '</li>';
									}
									else if( $entity->sentiment == 0 ) {
										$tooltip .= '<li class="sentiment neutral">';
											$tooltip .= 'neutral sentiment';
										$tooltip .= '</li>';
									}
									else {
										$tooltip .= '<li class="sentiment positive">';
											$tooltip .= $entity->sentiment * 100 .'% positive sentiment';
										$tooltip .= '</li>';
									}
								$tooltip .= '</ul>';
								echo "<li class='tool-right' data-tooltip='". $tooltip ."'>";
									echo $entity_content[0]->content;
								echo '</li>';
							}
						echo '</ul>';
					echo '</li>';
				}
				if( $keywords ) {
					echo '<li id="keywords" class="tool-bottom" data-tooltip="'. count( $keywords ) .' keywords">';
						echo file_get_contents("../images/keywords.svg");
						echo '<ul class="keywords">';
							echo '<li><b>Keywords by relevance</b></li>';
							foreach( $keywords as $keyword ) {
								$keyword_id = $keyword->keyword_id;
								$text = $db->get_var( "SELECT content FROM keywords WHERE id = $keyword_id" );
								$relevance = $keyword->relevance;
								$sentiment = $keyword->sentiment;

								$tooltip = '<ul class="info">';
									$tooltip .= '<li>';
										$tooltip .= $relevance * 100 .'% relevant';
									$tooltip .= '</li>';
									if( $sentiment < 0 ) {
										$tooltip .= '<li class="sentiment negative">';
											$tooltip .= $sentiment * -100 .'% negative sentiment';
										$tooltip .= '</li>';
									}
									else if( $sentiment == 0 ) {
										$tooltip .= '<li class="sentiment neutral">';
											$tooltip .= 'neutral sentiment';
										$tooltip .= '</li>';
									}
									else {
										$tooltip .= '<li class="sentiment positive">';
											$tooltip .= $sentiment * 100 .'% positive sentiment';
										$tooltip .= '</li>';
									}
								$tooltip .= '</ul>';

								echo "<li class='tool-right' data-tooltip='". $tooltip ."'>";
									echo $text;
								echo '</li>';
							}
						echo '</ul>';
					echo '</li>';
				}
				if( $taxonomies ) {
					echo '<li id="taxonomy" class="tool-bottom" data-tooltip="'. count( $taxonomies ) .' taxonomies">';
						echo file_get_contents("../images/taxonomy.svg");
						echo '<ul class="taxonomy">';
						echo '<li><b>Taxonomies by relevance</b></li>';
						foreach( $taxonomies as $taxonomy ) {
							$taxonomy_id = $taxonomy->taxonomy_id;
							$text = $db->get_var( "SELECT content FROM taxonomies WHERE id = $taxonomy_id" );
							$ancestor_string = recurse_ancestors( '', $taxonomy_id );
							echo '<li class="tool-right" data-tooltip="'. $taxonomy->relevance * 100 .'% accurate">';
								echo $ancestor_string . $text;
							echo '</li>';
						}
						echo '</ul>';
					echo '</li>';
				}
				if( $quotations ) {
					echo '<li id="quotes" class="tool-bottom" data-tooltip="'. count( $quotations ) .' quotations">';
						echo file_get_contents("../images/quotations.svg");
						echo '<ul class="quotes">';
							echo '<li><b>Direct Quotes</b></li>';
							foreach( $quotations as $quotation ) {
								$tooltip = '';
								if( $quotation->sentiment < 0 ) {
									$tooltip .= '<span class="sentiment negative">';
										$tooltip .= $quotation->sentiment * -100 .'% negative';
									$tooltip .= '</span>';
								}
								else if( $quotation->sentiment == 0 ) {
									$tooltip .= '<span class="sentiment neutral">';
										$tooltip .= 'neutral';
									$tooltip .= '</span>';
								}
								else {
									$tooltip .= '<span class="sentiment positive">';
										$tooltip .= $quotation->sentiment * 100 .'% positive';
									$tooltip .= '</span>';
								}
								echo "<li class='tool-right' data-tooltip='". $tooltip ."'>";
									echo '<p>';
										echo $quotation->content;
									echo '</p>';
								echo '</li>';
							}
						echo '</ul>';
					echo '</li>';
				}
			echo '</ul>';
			echo '<div class="meta-expanded"></div>';
		echo '</div>';
	}
}