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

	$news = import_news_by_network( $network );
	$results = (object) $news->results;

	prepare_news_for_storage( $results );
}
else {
	
	$network_id = $db->get_var( "SELECT id FROM networks WHERE network = '$network'" );
	$news = get_news_by_network( $network_id );
	display_news( $news );
}

?>