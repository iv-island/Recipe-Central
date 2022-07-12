$(document).ready(function() {
    // When the user scrolls down 30px from the top of the document, show the button
    $(window).scroll(function (){
        if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
            $("#btn-back-to-top").fadeIn();
        }
        else {
            $("#btn-back-to-top").fadeOut();
        }
    });

    $("#btn-back-to-top").click(function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    })
});
