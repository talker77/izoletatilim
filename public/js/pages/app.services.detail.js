jQuery(document).ready(function($) {
    //set here the speed to change the slides in the carousel
    $('#myCarousel').carousel({
        interval: 5000
    });

//Loads the html to each slider. Write in the "div id="slide-content-x" what you want to show in each slide
    $('#carousel-text').html($('#slide-content-0').html());

    //Handles the carousel thumbnails
    $('[id^=carousel-selector-]').click( function(){
        var id = this.id.substr(this.id.lastIndexOf("-") + 1);
        var id = parseInt(id);
        $('#myCarousel').carousel(id);
    });


    // When the carousel slides, auto update the text
    $('#myCarousel').on('slid.bs.carousel', function (e) {
        var id = $('.item.active').data('slide-number');
        $('#carousel-text').html($('#slide-content-'+id).html());
    });
});
