(function ($) {
    $(document).ready(function () {
        $('.flexslider').flexslider({
            slideshow: flexSliderAnimate,
            animation: flexSliderAnimation,
            animationLoop: flexSliderLoop,
            controlNav: true,
            directionNav: true,
            prevText: '',
            nextText: '',
            pauseOnAction: true,
            pauseOnHover: true,
            sync: flexSliderSync,
            start: function (slider) {
                $('body').removeClass('loading');
            },
            before: flexSliderBeforeCallback,
            after: flexSliderAfterCallback,
            slideshowSpeed: flexSliderSpeed
        });
    });
}(jQuery));