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
 * @param  string
 * @return array( object )
 */
function get_news_by_network( $network ) {
	
	global $db;

	switch( $network ) {

		case 'abc':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 1 LIMIT 30" );
			break;
		case 'aljazeera':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 2 LIMIT 30" );
			break;
		case 'bbc':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 3 LIMIT 30" );
			break;
		case 'cnn':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 4 LIMIT 30" );
			break;
		case 'fox':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 5 LIMIT 30" );
			break;
		case 'google':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 6 LIMIT 30" );
			break;
		case 'frontline':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 7 LIMIT 30" );
			break;
		case 'newrepublic':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 8 LIMIT 30" );
			break;
		case 'huffpost':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 9 LIMIT 30" );
			break;
		case 'nytimes':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 10 LIMIT 30" );
			break;
		case 'npr':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 11 LIMIT 30" );
			break;
		// case 'reddit':
		// 	$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 15 LIMIT 30" );
		// 	break;
		// case 'reddit_top':
		// 	$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 16 LIMIT 30" );
		// 	break;
		// case 'wired':
		// 	$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 12 LIMIT 30" );
		// 	break;
		default:
			error_log( 'whoops' );
			break;
	}

	return $news;
}

/**
 * store_news_by_network
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