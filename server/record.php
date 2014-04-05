<?php
if(!isset($_GET['key'])) exit;
$key = $_GET['key'];
?>
<!doctype html>
<html>
<head>
    <script src="recorderjs/jquery-1.11.0.min.js"></script>
    <script src="recorderjs/recorder.js"></script>
    <script>
        window.AudioContext = window.AudioContext || window.webkitAudioContext;

        var key = '<?php print $key; ?>';
        var echoprintPHP = 'http://wts:8888/server/echoprint.php';

        var audioContext = new AudioContext();
        var audioInput = null,
            realAudioInput = null,
            inputPoint = null,
            audioRecorder = null;
        var rafID = null;
        var analyserContext = null;
        var canvasWidth, canvasHeight;
        var recIndex = 0;

        function saveAudio() {
            audioRecorder.exportWAV( doneEncoding );
        }

        function gotBuffers(buffer ) {

            // the ONLY time gotBuffers is called is right after a new recording is completed -
            // so here's where we should set up the download.
            audioRecorder.exportWAV( doneEncoding );
        }

        function doneEncoding( blob ) {
            Recorder.setupDownload( blob, key, echoprintPHP);
            recIndex++;
        }

        function recording( toggle ) {

            if (toggle) {

                // start recording
                if (!audioRecorder)
                    return;

                audioRecorder.clear();
                audioRecorder.record();

            } else {

                // stop recording
                audioRecorder.stop();
                audioRecorder.getBuffers( gotBuffers );
            }
        }

        function gotStream(stream) {

            window.location.href = 'spotify:app:project-03:record:<?php print $key; ?>';

            inputPoint = audioContext.createGain();

            // Create an AudioNode from the stream.
            realAudioInput = audioContext.createMediaStreamSource(stream);
            audioInput = realAudioInput;
            audioInput.connect(inputPoint);

            analyserNode = audioContext.createAnalyser();
            analyserNode.fftSize = 2048;
            inputPoint.connect( analyserNode );

            audioRecorder = new Recorder( inputPoint );

            zeroGain = audioContext.createGain();
            zeroGain.gain.value = 0.0;
            inputPoint.connect( zeroGain );
            zeroGain.connect( audioContext.destination );

            recording(true);
            console.log('recording');

            setTimeout(function()
            {
                recording(false);
                //saveAudio();
                console.log('done recording');

            }, 20000);
        }

        function initAudio() {
            if (!navigator.getUserMedia)
                navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
            if (!navigator.cancelAnimationFrame)
                navigator.cancelAnimationFrame = navigator.webkitCancelAnimationFrame || navigator.mozCancelAnimationFrame;
            if (!navigator.requestAnimationFrame)
                navigator.requestAnimationFrame = navigator.webkitRequestAnimationFrame || navigator.mozRequestAnimationFrame;

            navigator.getUserMedia({audio:true}, gotStream, function(e) {
                alert('Error getting audio');
                console.log(e);
            });
        }

        function hasGetUserMedia(){

            return !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
        }

        if (hasGetUserMedia()) {

            window.addEventListener('load', initAudio );

        } else {

            console.log('getUserMedia() is not supported in your browser');
        }
    </script>
</head>
<body>
</body>
</html>