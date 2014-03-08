$(document).ready(function()
{
    initCaptureAnimate();

    function initCaptureAnimate() 
    {
		$('button.record').click(function() {
			$('.progress-wrapper').css('display', 'block');
		})
    }
})