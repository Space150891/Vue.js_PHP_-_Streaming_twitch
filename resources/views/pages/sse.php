<html>
  <head>
    <title>test API</title>
    <meta content="">
    <style></style>
  </head>
  <body>
    <a href="/twitch/redirect">twitch login</a>
  </body>
  <script>
    console.log('start');
    function login() {
      var formData = new FormData();
      // formData.append('email', 'agent150891@gmail.com');
      // formData.append('password', '1234567');

      formData.append('email', 'admin@admin.com');
      formData.append('password', 'password');

      fetch("http://127.0.0.1:8000/api/auth/login",
      {
          method: "POST",
          body: formData,
          credentials: 'omit',
          mode: 'cors',
      })
      .then(function(res){
        console.log(res);
        return res.json();
      })
      .then(function(data){
        document.cookie = "token=" + data.access_token;
        console.log(data.access_token);
        var source = new EventSource("http://localhost:8000/sse", { withCredentials: true });
        source.onmessage = function(event) {
            console.log(event.data);
        };
      });
    };

    login();

  </script>
</html>