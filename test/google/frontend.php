<html>
    <head>
        <title>Google API Test</title>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="811519910005-mgi1lgkvpjfr7mk2gbqmh7i10e49sckj.apps.googleusercontent.com">
    </head>
    <body>
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
        <div id="datagoogle"></div>
        <script>
            function onSignIn(googleUser) {
              var profile = googleUser.getBasicProfile();
              var id_token = googleUser.getAuthResponse().id_token;
              console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
              console.log('Name: ' + profile.getFamilyName());
              console.log('Image URL: ' + profile.getImageUrl());
              console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
              var xhr = new XMLHttpRequest();
                xhr.open('POST', 'backend.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                  document.getElementById("datagoogle").innerHTML = xhr.responseText;
                };
                xhr.send('idtoken=' + id_token);
                }
        </script>
    </body>
</html>