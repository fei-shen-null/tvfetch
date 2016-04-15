var detailFref;
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    //add affix to navbar
    // $(".navbar").affix({offset: {top: 0}});
    // Add scrollspy to <body>
    $('body').scrollspy({target: "#weekScrollspy", offset: 50});
    // Add smooth scrolling on all links inside the navbar
    $("#weekNavbar").find("a").on('click', function (event) {
        // Prevent default anchor click behavior
        event.preventDefault();

        // Store hash
        var hash = this.hash;

        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 800, function () {

            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
        });
    });
    //modal iframe
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('iframe').attr('src', detailFref);
    })
});