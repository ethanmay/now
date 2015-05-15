<?php

include_once "init.php";
include_once "functions.php";

if( $_REQUEST["network"] ){

	$network = $_REQUEST["network"];

	$news = get_news_by_network( $network, false );

	if( $_REQUEST["network"] == 'all' ) {
		echo json_encode( $news );
	}
	else {
		foreach( $news as $headline ) {
			echo $headline->content;
			echo '<br><br>';
		}
	}
}
else {
	// query import.io
	if( $network == 'all' ) {
		$news = import_all_news();
	}
	else {
		$network_id = $db->get_var( "SELECT id FROM networks WHERE network = '$network'" );
		if( !$network_id ) {
			$db->query( "INSERT INTO networks( network ) VALUES ( '$network' )" );
			$network_id = $db->get_var( "SELECT id FROM networks WHERE network = '$network'" );
		}

		$news = import_news_by_network( $network, true );
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

?>