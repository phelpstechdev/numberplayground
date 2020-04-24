<?php 
    session_start();
    session_unset();
    session_destroy();
?>
<html>
    <head>
        <meta name="google-signin-client_id" content="811519910005-mgi1lgkvpjfr7mk2gbqmh7i10e49sckj.apps.googleusercontent.com">
    </head>
    <body>
        <script src="https://apis.google.com/js/platform.js?onload=onLoadCallback" async defer></script>
        <script>
            window.onLoadCallback = function(){
                gapi.load('auth2', function() {
                    gapi.auth2.init().then(function(){
                        var auth2 = gapi.auth2.getAuthInstance();
                        auth2.signOut().then(function () {
                            window.location.href = 'https://www.phelpstechdev.com/apps/numberplayground/';
                        });
                    });
                });
            };
        </script>
    </body>
</html>