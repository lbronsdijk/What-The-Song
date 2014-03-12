/**
 * function.js
 * 
 * @copyright   Copyright (c) 2013 Luc Bronsdijk (http://www.lucbronsdijk.nl)
 */

$(document).ready(function()
{

    var timeOut = 20000;

    // initialize functions
    initLanding();
    initUserSearches();
    initToggles();
    
    /**
     * Initializes the 'landing'
     * 
     */
    function initLanding() 
    {
        addElements();

        // trigger record
        $('button.record').click(function() 
        {   
            // start countdown
            startCountdown();
        })

        /**
         * Adds all animated elements 
         * 
         */
        function addElements()
        {
            $('h1').addClass('animated fadeInDown');
            $('.notice').addClass('animated fadeIn');
        }

        /**
         * Handles the countdown 
         * 
         */
        function startCountdown()
        {
            $('.progress-wrapper').css('display', 'block');
            $('button.record').addClass('active');
            $('.notice').addClass('fadeOut');

            // sets waiting timeout for 'timeOut' sec
            setTimeout(function() 
            {
                $('h1').removeClass('fadeInDown');
                $('.notice').removeClass('fadeIn');

                $('h1').addClass('fadeOutUp');

                $('.progress-wrapper').fadeOut('fast', function() {

                    $('button.record').addClass('animated flipOutY');

                    $('.landing').delay(1000).hide(0, function() {

                        $('h1').removeClass('fadeOutUp');
                        $('.landing').detach();

                        initResult();
                    })
                })
            }, timeOut);
            
        }
    }

    /**
     * Initializes the results
     * 
     */
    function initResult() 
    {
        addElements();
        loader();

        // if(loader()) {
        //     console.log('derp');
        //     $('.result').css('display', 'block');
        // }


        /**
         * Adds all animated elements 
         * 
         */
        function addElements()
        {
            $('h1').addClass('fadeInDown');
            $('.musicbox').addClass('animated flipInY');
        }

        function loader()
        {
            var node = '<h1 class=\"shadow-text animated fadeInDown\">Just a sec, I\'m <strong>thinking</strong>.</h1> <div class=\"spinner\"> <div class=\"bounce1\"></div><div class=\"bounce2\"></div> <div class=\"bounce3\"></div></div>';

            $('.loader').append(node);

            setTimeout(function() 
            {

                $('.loader').fadeOut('fast', function() {
                    $('.loader').detach();
                    $('.result').css('display', 'block');
                })

            }, 3000);
        }
    }

    /**
     * Loops trough every user search
     * 
     */
    function initUserSearches()
    {
        var songs = $(".song");
        var songsIndex = -1;
        
        function nextSong() 
        {
            ++songsIndex;
            songs.eq(songsIndex % songs.length)
                .addClass('animated fadeInUp')
                .css('display', 'block')
                .delay(5000)
                .hide(0,0,nextSong);
        }
        
        nextSong();
    }

    /**
     * Sets button toggles
     * 
     */
    function initToggles()
    {
        $('button.play').click(function()
        {
            $('.player-controls').toggleClass('pause');
        })
        $('.star').click(function()
        {
            $(this).toggleClass('active');
        })
    }
})