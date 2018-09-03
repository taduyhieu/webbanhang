var myVideo = document.getElementById("video1");
var myVideo2 = document.getElementById("video2");
var myVideo3 = document.getElementById("video3");
function playPause() {
    if (myVideo.paused)
        myVideo.play();
    else
        myVideo.pause();
}
function playPause2() {
    if (myVideo2.paused)
        myVideo2.play();
    else
        myVideo2.pause();
}
function playPause3() {
    if (myVideo3.paused)
        myVideo3.play();
    else
        myVideo3.pause();
}
/*----------*/
$(document).ready(function () {
    $('#img-partner').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,

        responsive: {
            0: {
                items: 1
            },
            500: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            },

        }
    });
});