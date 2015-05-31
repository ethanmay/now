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

	// get overall sentiment
	$sentiments = $db->get_col( "SELECT sentiment FROM headlines WHERE network_id = $network_id" );
	for( $i = 0; $i < count( $sentiments ); $i++ ) {
		$avg += $sentiments[$i];
	}
	$avg = round( $avg / count( $sentiments ), 2 );

	if( $avg < 0 ) {
		echo '<div class="network-sentiment negative"><span>';
			echo $avg * 100 .'% average sentiment';
		echo '</span></div>';
	}
	else if( $avg == 0 ) {
		echo '<div class="network-sentiment"><span>';
			echo 'neutral average sentiment';
		echo '</span></div>';
	}
	else {
		echo '<div class="network-sentiment positive"><span>';
			echo $avg * 100 .'% average sentiment';
		echo '</span></div>';
	}

	$news = get_news_by_network( $network_id );
	display_news( $news );
}

?>