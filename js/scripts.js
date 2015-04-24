$(document).ready( function(){
    init();
});

function init() {

    // Set up tracks display
    var $tracks = $('.tracks .track');
    var height = ( ( $('.tracks').height() ) - 20 ); // -20 for padding-top/bottom


    $tracks.each( function( index ){
        $(this).height( height );
        queryNews( $(this).attr('id') );
        $(this).hide();
    });

    // Set up filter buttons
    $('.buttons button').click( function(){
        showTrack( $(this).data('reveal') );
    });
}

function showTrack( trackID ) {
    var $newTrack = $('#' + trackID);
    $newTrack = $newTrack.remove();
    $('.tracks').append( $newTrack );
    $newTrack.show();

    var curWidth = $('.tracks').width(),
        numTracks = $('.tracks .track:visible').length,
        newWidth = ( numTracks * 300 ) + ( numTracks * 10 );

    if( curWidth < newWidth ){
        $('.buttons').width( newWidth - 40 ); // -40 for padding
        $('.tracks').width( newWidth );
    }

    $('.tracks:first:visible').css( 'margin-left', '10px' );
}

function queryNews( network ) {
    $.ajax({
        url: 'index.php',
        method: 'POST',
        data: {
            'network': network
        },
        error: function( jqxhr, textStatus, errorThrown ){
            console.log( 'jqxhr:' + jqxhr, '\ntextStatus:' + textStatus, '\nerrorThrown:' + errorThrown );

            $( '#' + network ).append( result );
        }
    }).done( function returnData( data ) {

        $( '#' + network ).append( data );

        var result = JSON.parse( data );
        console.log( result );
    });
}