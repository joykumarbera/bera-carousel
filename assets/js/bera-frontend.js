jQuery( document ).ready( function( $ ) {
    $(".owl-carousel").owlCarousel({
        items:6,
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:3,
                nav:false,
                loop:true
            },
            600:{
                items:4,
                nav:false,
                loop:true
            },
            1000:{
                items:6,
                nav:false,
                loop:true
            }
        }
    });
} );