var timeOut = 20000;

/**
 * Initializes the 'landing'
 *
 */
function initLanding(models, key)
{
    addElements();

    // trigger record
    $('button.record').click(recordButtonClick);

    // When arguments change, run pages function
    models.application.addEventListener('arguments', function(){

        var args = models.application.arguments;

        if(args[0] == 'record' && args[1] == key){

            $('button.record').unbind("click");
            startCountdown();
        }
    });

    function recordButtonClick(e){

        e.preventDefault();

        window.location.href = recordPHP + "?key=123456";
    }

    /**
     * Adds all animated elements
     *
     */
    function addElements()
    {
        $('.landing').removeClass('hide');
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

                    initLoader();
                })
            })
        }, timeOut);

    }
}

function initLoader(){

    addElements();

    function addElements(){

        var loader = $('.loader');
        loader.removeClass('hide');

        var node = '<h1 class=\"shadow-text animated fadeInDown\">Just a sec, I\'m <strong>thinking</strong>.</h1> <div class=\"spinner\"> <div class=\"bounce1\"></div><div class=\"bounce2\"></div> <div class=\"bounce3\"></div></div>';

        loader.append(node);

        setTimeout(function()
        {

            $('.loader').fadeOut('fast', function() {
                $('.loader').detach();
                $('.result').removeClass('hide');

                initResult();
            })

        }, 3000);
    }
}

/**
 * Initializes the results
 *
 */
function initResult()
{
    addElements();

    /**
     * Adds all animated elements
     *
     */
    function addElements()
    {
        $('h1').addClass('fadeInDown');
        $('.musicbox').addClass('animated flipInY');
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

function fbLogin(auth, fb, sHandler, eHandler){

    auth.authenticateWithFacebook(
            //APP ID
            '221631931359668',
            //Permissions
            ['user_about_me', 'user_checkins']
        ).done(function(params){

            if (params.accessToken){

                var user, friends;
                var accessToken = params.accessToken;
                var session = fb.session;

                facebookUser(accessToken, function(data){

                    user = data;

                    facebookFriends(accessToken,function(data){

                        friends = data;

                        sHandler({user: user, friends: friends, accessToken: accessToken, session: session});
                    });
                });

            } else {

                eHandler('No access token returned');

            }}).fail(function(request, error) {

            eHandler('The Authentication request ' + request + ' failed with error: ' + error);

        }
    );
}