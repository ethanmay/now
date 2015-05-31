var data;

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

            if( $('#admin').length > 0 ){

                if( $(this).data('reveal') === 'all' ) {

                    $('.tracks .track').each( function(){
                        query( $(this).attr('id'), true );
                    });
                }
                else {
                    query( $(this).data('reveal'), true );
                }
            }
            else {
                query( $(this).data('reveal'), false );
            }
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

function init_tooltips() {
    // Set up tooltips
    $('.tool-right[data-tooltip!=""]').qtip({
        content: {
            attr: 'data-tooltip'
        },
        position: {
            my: 'left center',
            at: 'right center'
        },
        style: {
            classes: 'qtip-bootstrap'
        }
    });
    $('.tool-bottom[data-tooltip!=""]').qtip({
        content: {
            attr: 'data-tooltip'
        },
        position: {
            my: 'top center',
            at: 'bottom center'
        },
        style: {
            classes: 'qtip-bootstrap'
        }
    });
}

function init_meta() {
    // Prepare meta info hover
    $('.meta > li').click( function() {
        var meta_id = $(this).attr('id'),
            meta_info;

        $(this).siblings().each( function(){
            if( $(this).hasClass('active') ) {
                var rmv_meta_id = $(this).attr('id');
                $(this).removeClass('active');
                meta_info = $('.story-ctn.active .meta-expanded').hide().children('.' + rmv_meta_id).remove();
                $(this).append( meta_info );
                init_tooltips();
            }
        });

        if( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            meta_info = $('.story-ctn.active .meta-expanded').hide().children('.' + meta_id).remove();
            $(this).append( meta_info );
            $('.story-ctn.active').removeClass('active');
        }
        else {
            $('.story-ctn.active').removeClass('active');
            $(this).parents('.story-ctn').addClass('active');
            $(this).addClass('active');
            meta_info = $(this).children('.' + meta_id).remove();
            $('.story-ctn.active .meta-expanded').append( meta_info ).show();
            init_tooltips();
        }
    });
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
        $( '#' + network + ' .track-content' ).append( data );
        init_meta();
        init_tooltips();
    });
}