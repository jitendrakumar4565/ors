$(document).ready(function () {

    /* OWL slider */
    $('.owl-carousel').owlCarousel({
        loop: true,
        // margin:10,
        responsiveClass: true,
        nav: false,
        center: true,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 5
            }
        }
    });



});
