$(document).ready( function(){
    init();
});

function init() {

    // Set up tracks display
    var $tracks = $('.tracks .track');
    var height = ( $('.tracks').height() ); // -20 for padding-top/bottom

    $tracks.each( function( index ){
        $(this).height( height );
        $(this).hide();
    });

    // Menu related functions
    $('#reveal-menu').click( function(){
        menuHandle();
    });

    // Set up filter buttons to show tracks & get data
    $('.buttons li').click( function(){
        if( !$(this).hasClass('acive') ){
            menuHandle();
            $(this).addClass('active');
            showTrack( $(this).data('reveal') );
            query( $(this).data('reveal'), true );
        }
    });
}

function menuHandle() {
    if( !$('#reveal-menu').hasClass('active') ) {
        $('#reveal-menu').addClass('active').animate({
            left: 199
        }, 370);
        $('.buttons').animate({
            left: 0
        }, 370);
        $('.tracks').animate({
            left: 200
        }, 370);
    }
    else {        
        $('#reveal-menu').removeClass('active').animate({
            left: 0
        }, 370, function(){
            $('#reveal-menu').addClass('activated');
        });
        $('.buttons').animate({
            left: -200
        }, 370);
        $('.tracks').animate({
            left: 0
        }, 370);
    }
}

function showTrack( trackID ) {

    if ( trackID === 'all' ) {
        $('.tracks .track').fadeIn();
    }
    else {
        var $newTrack = $('#' + trackID);
        $newTrack = $newTrack.remove();
        $('.tracks').append( $newTrack );
        $newTrack.fadeIn();
    }

    var curWidth = $('.tracks').width(),
        numTracks = $('.tracks .track:visible').length,
        newWidth = ( numTracks * 300 ) + ( numTracks * 10 ) + 10; // +10 for margin-left

    if( curWidth < newWidth ){
        $('.tracks').width( newWidth );
    }

    $('.tracks .track:visible:first').css( 'margin-left', '10px' );
}

function query( network, import_io ) {
    $.ajax({
        url: 'db/ajax.php',
        method: 'POST',
        data: {
            'network': network,
            'import_io': import_io
        },
        error: function( jqxhr, textStatus, errorThrown ){
            console.log( 'jqxhr:' + jqxhr, '\ntextStatus:' + textStatus, '\nerrorThrown:' + errorThrown );
        }
    }).done( function returnData( data ) {

        if( network === 'all' ) {
            data = JSON.parse( data );
            $('.track').each( function(){
                var network_data = data[ $(this).attr('id') ];
                for( var i = 0; i < network_data.length; i++ ) {
                    $(this).children('.track-content').append( '<div class="story-ctn">' + network_data[i]['content'] + '</div>' );
                }
            });
        }
        else {
            $( '#' + network + ' .track-content' ).append( data );
        }
    });
}