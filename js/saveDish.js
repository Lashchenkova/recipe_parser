"use strict";

$( ".dish_img" ).click(function() {
    $( this ).css({
        width: 600,
        opacity: 1
    });

    $( ".dish_img" ).not( this ).css({
        width: '24%',
        opacity: 0.4
    });

    $( '#dish_photoPath' ).val($( this ).attr( 'src' ));
});

$( ".dish" ).click(function() {
    $( this ).css({ background: 'lightgrey' });
    $( ".dish" ).not( this ).css({ background: 'inherit' });

    var str = $( this ).find( '.recipe' ).html().replace( /\s+/g, " " );

    $( '#ingredients' ).val(str);
    $( '#dishName' ).val($( this ).find( "h3" ).text().replace( /&nbsp;/gi , ' '));
});
