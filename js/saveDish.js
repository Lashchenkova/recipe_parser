"use strict";

$( ".dish_img" ).click(function() {
    $( this ).css({
        width: '30%',
        opacity: 1
    });

    $( ".dish_img" ).not( this ).css({
        width: '23%',
        opacity: 0.4
    });

    $( '#dish_photoPath' ).val($( this ).attr( 'src' ));//pass to input parsed image src
});

$( ".dish" ).click(function() {
    $( this ).css({ background: 'WhiteSmoke' });//change color of parsed ingredients
    $( ".dish" ).not( this ).css({ background: 'inherit' });

    var str = $( this ).find( '.recipe' ).html().replace( /\s+/g, " " );

    $( '#ingredients' ).val(str);//pass to input parsed ingredients
    $( '#dishName' ).val($( this ).find( "h3" ).text().replace( /&nbsp;/gi , ' '));//pass to input parsed Dish name
});
