$(document).ready(function()
{
    
    initLandingAnimate();
    initCaptureAnimate();
    initOtherUsers();
    
    function initLandingAnimate() 
    {
        $('h1').addClass('animated fadeInDown');
    }

    function initCaptureAnimate() 
    {
        $('button.record').click(function() {
            $('.progress-wrapper').css('display', 'block');

            setTimeout(function() {
                $('h1').removeClass('fadeInDown');
                $('h1').addClass('fadeOutUp');
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
})