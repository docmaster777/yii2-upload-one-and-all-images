$(document).ready(function(){
    // Прокрутка фона главной страницы
    //Based on the Scroller function from @sallar
    var $content = $('header .content')
        , $blur    = $('header .overlay')
        , wHeight  = $(window).height();

    $(window).on('resize', function(){
        wHeight = $(window).height();
    });

    window.requestAnimFrame = (function()
    {
        return  window.requestAnimationFrame       ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame    ||
            function( callback ){
                window.setTimeout(callback, 1000 / 60);
            };
    })();

    function Scroller()
    {
        this.latestKnownScrollY = 0;
        this.ticking            = false;
    }

    Scroller.prototype = {

        init: function() {
            window.addEventListener('scroll', this.onScroll.bind(this), false);
            $blur.css('background-image',$('header:first-of-type').css('background-image'));
        },


        onScroll: function() {
            this.latestKnownScrollY = window.scrollY;
            this.requestTick();
        },


        requestTick: function() {
            if( !this.ticking ) {
                window.requestAnimFrame(this.update.bind(this));
            }
            this.ticking = true;
        },

        update: function() {
            var currentScrollY = this.latestKnownScrollY;
            this.ticking       = false;


            var slowScroll = currentScrollY / 2
                , blurScroll = currentScrollY * 2
                , opaScroll = 1.4 - currentScrollY / 400;
            if(currentScrollY > wHeight)
                $('nav').css('position','fixed');
            else
                $('nav').css('position','absolute');

            $content.css({
                'transform'         : 'translateY(' + slowScroll + 'px)',
                '-moz-transform'    : 'translateY(' + slowScroll + 'px)',
                '-webkit-transform' : 'translateY(' + slowScroll + 'px)',
                'opacity' : opaScroll
            });

            $blur.css({
                'opacity' : blurScroll / wHeight
            });
        }
    };


    var scroller = new Scroller();
    scroller.init();

    // Слайлер на главной странице
    $('.sl').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        // vertical: true,
        autoplay: true,
        autoplaySpeed: 3000
    });

    // яндекс карта на главной
    ymaps.ready(init);
    var myMap,
        myPlacemark;

    function init(){
        myMap = new ymaps.Map("map", {
            center: [44.94952992, 34.08931350],
            zoom: 13

        });

        myMap.behaviors.disable(['scrollZoom']),

        myPlacemark = new ymaps.Placemark([44.94952992, 34.08931350], {
            hintContent: 'Наш офис!',
            balloonContent: 'улица Маяковского, 14Х'
        });

        myMap.geoObjects.add(myPlacemark);

    }
});