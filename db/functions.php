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

		case 'all':
			$result['abc'] = query_import_io( "590a4436-2be2-4e6b-9686-b17e8db00b29", array( "webpage/url" => "http://abcnews.go.com/" ) );
			$result['aljazeera'] = query_import_io( "6c05b191-b04c-458d-aa58-ec6f0b023d75", array( "webpage/url" => "http://america.aljazeera.com/" ) );
			$result['bbc'] = query_import_io( "0d6d38e8-c537-428f-82d4-28ea5716abf5", array( "webpage/url" => "http://www.bbc.com/news" ) );
			$result['cnn'] = query_import_io( "c6d0891f-9c20-4fe8-aba4-c7b870af899f", array( "webpage/url" => "http://www.cnn.com/" ) );
			$result['fox'] = query_import_io( "f675c84d-6805-4e5f-86c1-06c77fae846d", array( "webpage/url" => "http://www.foxnews.com/" ) );
			$result['google'] = query_import_io( "56104162-a61e-4656-810f-1ff839e0f6cf", array( "webpage/url" => "http://news.google.com/" ) );
			$result['frontline'] = query_import_io( "216ad870-d7af-400e-812b-bc6f19b8b79c", array( "webpage/url" => "http://www.pbs.org/wgbh/pages/frontline/" ) );
			$result['newrepublic'] = query_import_io( "eb09b2ab-d56a-4820-8eb7-58fc6a1e8e3c", array( "webpage/url" => "http://www.newrepublic.com/" ) );
			$result['huffpost'] = query_import_io( "1643e164-c2d8-4e32-a28c-bc1cbd34f11e", array( "webpage/url" => "http://www.huffingtonpost.com/" ) );
			$result['nytimes'] = query_import_io( "52fad557-8a42-4213-85f8-6ef99e0fb272", array( "webpage/url" => "http://www.nytimes.com/" ) );
			$result['npr'] = query_import_io( "4c4f7281-0e4e-4048-b0ed-97ffbf60ec8c", array( "webpage/url" => "http://www.npr.org/" ) );
			// $result['reddit'] = query_import_io( "f516096f-4d02-4aab-84bb-1e2f7687360d", array( "webpage/url" => "http://www.reddit.com/" ) );
			// $result['reddit_top'] = query_import_io( "24db1886-24be-488e-a803-877b8fe056f4", array( "webpage/url" => "http://www.reddit.com/top/" ) );
			$result['wired'] = query_import_io( "dea122bd-4535-473e-959a-604f9398d57c", array( "webpage/url" => "http://www.wired.com/" ) );
			break;
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
		// case 'reddit':
		// 	$result = query_import_io( "f516096f-4d02-4aab-84bb-1e2f7687360d", array( "webpage/url" => "http://www.reddit.com/" ) );
		// 	break;
		// case 'reddit_top':
		// 	$result = query_import_io( "24db1886-24be-488e-a803-877b8fe056f4", array( "webpage/url" => "http://www.reddit.com/top/" ) );
		// 	break;
		case 'wired':
			$result = query_import_io( "dea122bd-4535-473e-959a-604f9398d57c", array( "webpage/url" => "http://www.wired.com/" ) );
			break;
		default:
			error_log( 'ya dun fucked up' );
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

		case 'all':
			$news['abc'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 1 LIMIT 30" );
			$news['aljazeera'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 2 LIMIT 30" );
			$news['bbc'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 3 LIMIT 30" );
			$news['cnn'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 4 LIMIT 30" );
			$news['fox'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 5 LIMIT 30" );
			$news['google'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 6 LIMIT 30" );
			$news['frontline'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 7 LIMIT 30" );
			$news['newrepublic'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 8 LIMIT 30" );
			$news['huffpost'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 9 LIMIT 30" );
			$news['nytimes'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 10 LIMIT 30" );
			$news['npr'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 11 LIMIT 30" );
			// $news['reddit'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 15 LIMIT 30" );
			// $news['reddit_top'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 16 LIMIT 30" );
			$news['wired'] = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 12 LIMIT 30" );
			break;
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
		case 'wired':
			$news = $db->get_results( "SELECT id, content, description FROM headlines WHERE network_id = 12 LIMIT 30" );
			break;
		default:
			error_log( "my bad" );
			break;
	}

	return $news;
}

/**
 * store_news_by_network
 * Store news results in db.
 * 
 * @param  array( object )
 * @param  int
 */
function store_news_by_network( $news, $network_id ) {

	global $db;

	if( $news ) {

		foreach( $news as $story ) {

			$story = (array) $story;
			$headline = $story[ 'headline' ];
			$description = $story[ 'description' ];
			$image = $story[ 'image' ];
			$image_alt = $story[ 'image/_alt' ];

			// Insert headlines into db
			if( is_array( $headline ) ) {

				$num_headlines = count( $headline );

				for( $i = 0; $i < $num_headlines; $i++ ) {
					$content = $db->escape( $headline[ $i ] );
					$db->query( "INSERT INTO headlines( network_id, content ) VALUES ( $network_id, '$content' )" );
				}
			}
			else {
				$headline = $db->escape( $headline );

				if( $description ) {
					$description = $db->escape( $description );
					$db->query( "INSERT INTO headlines( network_id, content, description ) VALUES ( $network_id, '$headline', '$description' )" );
					unset( $description );
				}
				else {
					$db->query( "INSERT INTO headlines( network_id, content ) VALUES ( $network_id, '$headline' )" );
				}

				$headline_id = $db->insert_id;
			}

			// Insert images into db
			if( $image ) {

				if( $image != 'http://a.abcnews.com/assets/images/v3/pixel_eee.gif' ) {
					$image = $db->escape( $image );
					$image_alt = $db->escape( $image_alt );
					$db->query( "INSERT INTO images( headline_id, image, image_alt ) VALUES ( $headline_id, '$image', '$image_alt' )" );
					unset( $image );
				}
			}
		}
	}

	return false;
}

/**
 * get_sentiments
 * Get sentiments from AlchemyAPI.
 * 
 * @param  array
 * @return array
 */
function get_sentiments( $news ) {

	require_once( './alchemy/alchemyapi.php' );
	$alchemyapi = new AlchemyAPI();

	while( $i++ < count( $news ) ) {

		echo( $news[ $i ] . ' => ' . $alchemyapi->sentiment('text', $news[ $i ], null) );
	}

	return false;
}