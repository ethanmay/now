<?php

include_once './alchemy/alchemyapi.php';

$alchemyapi = new AlchemyAPI();

$options = array(
	'extract' => 'title, author, pub-date, page-image, taxonomy, entity, keyword, concept',
	'linkedData' => 0,
	'quotations' => 1,
	'sentiment'  => 1
);

$alchemy = $alchemyapi->combined( 'url', 'http://abcnews.go.com/International/delta-force-commandos-kill-key-isis-leader-ground/story?id=31092834', $options );
$data = (object) $alchemy;

// Title
$title = $data->title;

// Publication Date
$pub_date = $data->publicationDate['date'];
$pub_date = strtotime( $pub_date );
$pub_date = date( 'Y-m-d H:i:s', $pub_date );

// Image
$image = $data->image;

// Overall Sentiment
// $sentiment = $alchemyapi->sentiment( 'url', 'http://abcnews.go.com/International/delta-force-commandos-kill-key-isis-leader-ground/story?id=31092834', null );
// $sentiment = (object) $sentiment;
// $sentiment = round( $sentiment->docSentiment['score'], 2 );

// Author
$author = $data->author;

// Keywords
$keywords = $data->keywords;
foreach( $keywords as $keyword ) {
	$keyword = (object) $keyword;
	$text = $keyword->text;
	$relevance = round( $keyword->relevance, 2 );
	$sentiment = round( $keyword->sentiment['score'], 2 );
}

// Concepts
$concepts = $data->concepts;
foreach( $concepts as $concept ) {
	$concept = (object) $concept;
	$text = $concept->text;
	$relevance = round( $concept->relevance, 2 );
}

// Entities
$entities = $data->entities;
foreach( $entities as $entity ) {
	$entity = (object) $entity;
	$text = $entity->text;
	$count = $entity->count;
	$type = $entity->type;
	$relevance = round( $entity->relevance, 2 );
	$sentiment = round( $entity->sentiment['score'], 2 );

	// Quotations
	if( $entity->quotations ) {
		$quotation = (object) $entity->quotations[0];
		$text = $quotation->quotation;
		$sentiment = round( $quotation->sentiment['score'], 2 );
	}
}

// Taxonomies
$taxonomies = $data->taxonomy;
foreach( $taxonomies as $taxonomy ) {
	$taxonomy = (object) $taxonomy;

	// Heirarchical taxonomies
	$labels = explode( '/', $taxonomy->label );
	var_dump($labels);
	// for( $i = 0; $i < count( $labels ); $i++ ) {
	// 	// parent
	// 	if( $i == 0 ) {
	// 		$parent_text = $labels[$i];
	// 	}
	// 	// children
	// 	else {
	// 		$parent = 0; // get last submitted taxonomy parent id
	// 		$child_text = $labels[$i];
	// 	}
	// }

	$relevance = round( $taxonomy->score, 2 );
}

?>