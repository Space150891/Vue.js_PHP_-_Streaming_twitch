<html>
  <head>
    <title>jwt</title>
    <meta content="">
    <style></style>
  </head>
  <body></body>
  <script>
  
  @if (isset($access_token))
    window.access_token = "{{($access_token)}}";
    console.log("{{($access_token)}}");
  @endif

  </script>
</html>