// Sujina.js
// Author: Sujina
// Basic JS for homepage

$(document).ready(function () {

    // Highlight active nav link
    var page = window.location.pathname.split('/').pop();
    $('.nav-link').each(function () {
        if ($(this).attr('href') == page) {
            $(this).addClass('active');
        }
    });

});
