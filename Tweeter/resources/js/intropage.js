require('./app');
Vue.component('Root', require('./components/Root.vue').default);
const app = new Vue({
    el: '#welcome-page',
});


// initiate controller
var controller = new ScrollMagic.Controller();

var revealElements = document.getElementsByClassName("revealStats");
for (i = 0; i <= revealElements.length; i++) {
    new ScrollMagic.Scene({
            triggerElement: revealElements[i],
            triggerHook: 0.9, // show, when scrolled 10% into view
            duration: "90%",
            offset: 10,
        })
        .setClassToggle(revealElements[i], "visible") // add class to reveal
        .addTo(controller);
}

$(function() { // wait for document ready
    // init
    var controller = new ScrollMagic.Controller({
        globalSceneOptions: {
            triggerHook: 'onLeave',
            duration: "150%" // this works just fine with duration 0 as well
        }
    });

    // get all slides
    var slides = document.getElementsByClassName("panel");

    // create scene for every slide
    for (var i = 0; i < slides.length; i++) {
        new ScrollMagic.Scene({
                triggerElement: slides[i]
            })
            .setPin(slides[i], { pushFollowers: false })
            .addIndicators() // add indicators (requires plugin)
            .addTo(controller);
    }
});