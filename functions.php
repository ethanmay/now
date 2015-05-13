<?php

if( $_REQUEST["network"] ){

	require_once( './db/init.php' );

	$network = $_REQUEST["network"];

	if( $network == 'all' ) {
		$news = get_all_news();
	}
	else {
		$network_id = $db->get_var( "SELECT id FROM networks WHERE network = '$network'" );
		if( !$network_id ) {
			$db->query( "INSERT INTO networks( network ) VALUES ( '$network' )" );
			$network_id = $db->get_var( "SELECT id FROM networks WHERE network = '$network'" );
		}

		$news = get_news_by_network( $network );
	}

	$parsed = parse_news( $news );

	for( $i = 0; $i < count( $parsed ); $i++ ) {
		$headline = $parsed[ $i ];
		echo $headline;
		echo '<br><br>';
		$headline = $db->escape( $headline );
		$db->query( "INSERT INTO headlines( network_id, content ) VALUES ( $network_id, '$headline' )" );
	}

	$db->debug();

	// get_sentiments( $parsed );
}

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
 * get_all_news
 * Get news from all networks.
 * 
 * @return array( object )
 */
function get_all_news() {

	$news = Array();

	$result = query_import_io( "590a4436-2be2-4e6b-9686-b17e8db00b29", array( "webpage/url" => "http://abcnews.go.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "6c05b191-b04c-458d-aa58-ec6f0b023d75", array( "webpage/url" => "http://america.aljazeera.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "0d6d38e8-c537-428f-82d4-28ea5716abf5", array( "webpage/url" => "http://www.bbc.com/news" ) );
	array_push( $news, $result );
	$result = query_import_io( "c6d0891f-9c20-4fe8-aba4-c7b870af899f", array( "webpage/url" => "http://www.cnn.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "f675c84d-6805-4e5f-86c1-06c77fae846d", array( "webpage/url" => "http://www.foxnews.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "56104162-a61e-4656-810f-1ff839e0f6cf", array( "webpage/url" => "http://news.google.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "216ad870-d7af-400e-812b-bc6f19b8b79c", array( "webpage/url" => "http://www.pbs.org/wgbh/pages/frontline/" ) );
	array_push( $news, $result );
	$result = query_import_io( "eb09b2ab-d56a-4820-8eb7-58fc6a1e8e3c", array( "webpage/url" => "http://www.newrepublic.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "1643e164-c2d8-4e32-a28c-bc1cbd34f11e", array( "webpage/url" => "http://www.huffingtonpost.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "52fad557-8a42-4213-85f8-6ef99e0fb272", array( "webpage/url" => "http://www.nytimes.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "4c4f7281-0e4e-4048-b0ed-97ffbf60ec8c", array( "webpage/url" => "http://www.npr.org/" ) );
	array_push( $news, $result );
	$result = query_import_io( "f516096f-4d02-4aab-84bb-1e2f7687360d", array( "webpage/url" => "http://www.reddit.com/" ) );
	array_push( $news, $result );
	$result = query_import_io( "24db1886-24be-488e-a803-877b8fe056f4", array( "webpage/url" => "http://www.reddit.com/top/" ) );
	array_push( $news, $result );
	$result = query_import_io( "dea122bd-4535-473e-959a-604f9398d57c", array( "webpage/url" => "http://www.wired.com/" ) );
	array_push( $news, $result );

	return $news;
}

/**
 * get_news_by_network
 * Get all news results.
 * 
 * @param  string
 * @return array( object )
 */
function get_news_by_network( $network ) {

	$news = Array();

	switch( $network ) {

		case 'abc':
			$result = query_import_io( "590a4436-2be2-4e6b-9686-b17e8db00b29", array( "webpage/url" => "http://abcnews.go.com/" ) );
			array_push( $news, $result );
			break;
		case 'aljazeera':
			$result = query_import_io( "6c05b191-b04c-458d-aa58-ec6f0b023d75", array( "webpage/url" => "http://america.aljazeera.com/" ) );
			array_push( $news, $result );
			break;
		case 'bbc':
			$result = query_import_io( "0d6d38e8-c537-428f-82d4-28ea5716abf5", array( "webpage/url" => "http://www.bbc.com/news" ) );
			array_push( $news, $result );
			break;
		case 'cnn':
			$result = query_import_io( "c6d0891f-9c20-4fe8-aba4-c7b870af899f", array( "webpage/url" => "http://www.cnn.com/" ) );
			array_push( $news, $result );
			break;
		case 'fox':
			$result = query_import_io( "f675c84d-6805-4e5f-86c1-06c77fae846d", array( "webpage/url" => "http://www.foxnews.com/" ) );
			array_push( $news, $result );
			break;
		case 'google':
			$result = query_import_io( "56104162-a61e-4656-810f-1ff839e0f6cf", array( "webpage/url" => "http://news.google.com/" ) );
			array_push( $news, $result );
			break;
		case 'frontline':
			$result = query_import_io( "216ad870-d7af-400e-812b-bc6f19b8b79c", array( "webpage/url" => "http://www.pbs.org/wgbh/pages/frontline/" ) );
			array_push( $news, $result );
			break;
		case 'newrepublic':
			$result = query_import_io( "eb09b2ab-d56a-4820-8eb7-58fc6a1e8e3c", array( "webpage/url" => "http://www.newrepublic.com/" ) );
			array_push( $news, $result );
			break;
		case 'huffpost':
			$result = query_import_io( "1643e164-c2d8-4e32-a28c-bc1cbd34f11e", array( "webpage/url" => "http://www.huffingtonpost.com/" ) );
			array_push( $news, $result );
			break;
		case 'nytimes':
			$result = query_import_io( "52fad557-8a42-4213-85f8-6ef99e0fb272", array( "webpage/url" => "http://www.nytimes.com/" ) );
			array_push( $news, $result );
			break;
		case 'npr':
			$result = query_import_io( "4c4f7281-0e4e-4048-b0ed-97ffbf60ec8c", array( "webpage/url" => "http://www.npr.org/" ) );
			array_push( $news, $result );
			break;
		case 'reddit':
			$result = query_import_io( "f516096f-4d02-4aab-84bb-1e2f7687360d", array( "webpage/url" => "http://www.reddit.com/" ) );
			array_push( $news, $result );
			break;
		case 'reddit_top':
			$result = query_import_io( "24db1886-24be-488e-a803-877b8fe056f4", array( "webpage/url" => "http://www.reddit.com/top/" ) );
			array_push( $news, $result );
			break;
		case 'wired':
			$result = query_import_io( "dea122bd-4535-473e-959a-604f9398d57c", array( "webpage/url" => "http://www.wired.com/" ) );
			array_push( $news, $result );
			break;
		default:
			error_log( 'ya dun fucked up' );
			break;
	}

	return $news;
}

/**
 * parse_news
 * Parse news results into headlines.
 * 
 * @param  array( object )
 * @return array( string )
 */
function parse_news( $news ) {

	$headlines = Array();
	$descriptions = Array();
	$images = Array();

	foreach( $news as $network ) {

		$stories = $network->results;

		if( $stories ) {

			foreach( $stories as $story ) {

				$headline = $story->headline;

				if( is_array( $headline ) ) {

					for( $i = 0; $i < count( $headline ); $i++ ) {
						array_push( $headlines, $headline[ $i ] );
					}
				}
				else if( $headline ) {
					array_push( $headlines, $headline );
				}
			}
		}
	}

	// var_dump( $news );

	return $headlines;
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