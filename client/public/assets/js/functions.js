$(document).ready(function()
{
    
    initLandingAnimate();
    initCaptureAnimate();
    initOtherUsers();
    initToggles();
    
    function initLandingAnimate() 
    {
        $('h1').addClass('animated fadeInDown');
        $('.notice').addClass('animated fadeIn');
    }

    function initCaptureAnimate() 
    {
        $('button.record').click(function() {
            $('.progress-wrapper').css('display', 'block');

            setTimeout(function() {
                $('h1').removeClass('fadeInDown');
                $('.notice').removeClass('fadeIn');
                $('h1').addClass('fadeOutUp');
                $('.notice').addClass('fadeOut');
                $('.progress-wrapper').fadeOut('fast', function() {
                    $('button.record').addClass('animated flipOutY');
                })
            }, 10000);

        })
    }

    function initOtherUsers()
    {
        var songs = $(".song");
        var songsIndex = -1;
        
        function showNextSong() {
            ++songsIndex;
            songs.eq(songsIndex % songs.length)
                .addClass('animated fadeInUp')
                .css('display', 'block')
                .delay(5000)
                .hide(0,0,showNextSong);
        }
        
        showNextSong();
    }

    function initToggles()
    {
        $('button.play, span.player-controls').click(function(){
            $('.player-controls').toggleClass('pause');
        })
        $('.star').click(function(){
            $(this).toggleClass('active');
        })
    }
})