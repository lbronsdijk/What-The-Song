$(document).ready(function()
{
    
	initLandingAnimate();
    initCaptureAnimate();
    
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
})