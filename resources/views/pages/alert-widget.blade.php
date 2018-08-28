<html>
  <head>
    <title>alert widget page</title>
    <meta content="">
    <style>
        body {
            background: transparent;
        }
        #stream-widget {
            width: 100%;
        }
        #stream-widget img {
            width: 30%;
            display: block;
            margin: 100px auto 10px auto;
        }
        #stream-widget h1 {
            text-align: center;
            margin: 0;
            padding: 0;
            color: red;
        }
    </style>
  </head>
  <body>
    <main id="stream-widget">
    </main>
  </body>
  <script>
    var connect = new WebSocket('{{ env("WS") }}');
        var ws = connect;
        ws.onopen = function() {
            var mess = {
                role: 'streamer',
                token:  '{{ $token }}'
            }
            ws.send(JSON.stringify(mess));
            setInterval(() => {
                var data = {
                    role: 'streamer',
                    action: 'check'
                }
                ws.send(JSON.stringify(data));
            }, {{ env("WS_STREAM_ALERT_PERIOD") }} * 1000);
        };
        ws.onmessage = function(event) {
            console.log(event.data);
            var data = JSON.parse(event.data);
            if (data.action && data.action == 'win') {
                var html = `<img src='/storage/${data.image}' alt='prize'><h1>Viewer ${data.viewer} win prize ${data.prize}<h1>`;
                console.log(html);
                document.getElementById('stream-widget').innerHTML = html;
                setTimeout(() => {
                    document.getElementById('stream-widget').innerHTML = "";
                }, 4000); // two seconds
            }
        };
  </script>
</html>