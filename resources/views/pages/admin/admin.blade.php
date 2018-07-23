<html>
  <head>
    <title>Admin page</title>
    <meta content="">
    <style></style>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    <div id="admin-app">
      <main>
        <router-view></router-view>
      </main>
    </div>
  </body>
  <script src="{{ mix('/js/admin-app.js') }}"></script>
</html>