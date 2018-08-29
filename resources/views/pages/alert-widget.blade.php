<html>
  <head>
    <title>alert widget page</title>
    <meta content="">
    <style>
        body {
            background: transparent;
        }
        #stream-widget {
            width: 300px;
            margin: 0 auto;
        }

        .container-flip {
            width: 300px;
            height: 400px;
            position: relative;
            perspective: 800px;
            border-radius: 4px;
            background: #fff;
        }

        .card-flip{
            width: 100%;
            height: 100%;
            position: absolute;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
            transition: -webkit-transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275), -webkit-transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 6px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }

        .front-flip {
            padding: 20px;
        }

        .flip-prize-image {
            width: 100px;
            display: block;
            margin: 0 auto;
        }

        .flip-logo {
            display:block;
            margin: 0 auto;
        }

        .card-flip >div {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 6px;
            background: #fff;
            /* display: flex; */
            justify-content: center;
            align-items: center;
            font: 16px/1.5 "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-smoothing: antialiased;
            color: #47525D;
        }

        .card-flip >div >div {
            text-align: center;
        }

        .back-flip {
            transform: rotateY(180deg);
        }

        .flipped {
            transform: rotateY(180deg);
        }

        .flip-avatar{
            width:100px;
        }
        
        .flip-viewer {
            font-size: 20px;
        }

        .flip-gamecard {
            width: 217px;
            height: 312px;
            border: none;
            border-radius: 5px; 
            position: relative;
            margin: 0 auto
        }

        .flip-hero{
            width: 132px;
            height: 170px;
            border-radius: 50%;
            position: absolute;
            top: 20px;
            left: 40px;
        }

        .flip-frame {
            width: 217px; height: 312px; border: none; border-radius: 5px; position: absolute; top: 0px; left: 0px;
        }

        .flip-ach {
            position: absolute; top: 205px; width: 217px; margin: 0px; padding: 0px 40px; color: rgb(255, 255, 255);
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
            }, {{ $prize_alert }} * 1000);
        };
        ws.onmessage = function(event) {
            console.log(event.data);
            var data = JSON.parse(event.data);
            if (data.action && data.action == 'win') {
                var card = 'no card';
                var prize = '';
                if (data.card) {
                    card = `<div class="flip-gamecard"> \
                        <img src="/storage/${data.card.hero}" alt="hero" class="flip-hero"> \
                        <img src="/storage/${data.card.frame}" alt="frame" class="flip-frame"> \
                        <p class="flip-ach"> \
                        ${data.card.ach} \
                        </p></div>`;
                }
                var prizeImg = `<img src="/storage/${data.prize.icon}" alt="prize" class="flip-prize-image">`;
                if (data.prize.price > 0) {
                    prize = `<div><h5>${data.prize.price} USD </h5>${prizeImg}</div>`;
                } else {
                    prize = `<div>${prizeImg}</div>`;
                }
                var html = `<div class="container-flip"> \
                                <div class="card-flip"> \
                                    <div class="front-flip"> \
                                        <div> \
                                            <img src="${data.viewer.avatar}" alt="avatar" class="flip-avatar"> \
                                            <strong class="flip-viewer">${data.viewer.name}</strong> \
                                        </div> \
                                        <div> \
                                            <img src="/images/logo.png" class="flip-logo"> \
                                        </div> \
                                        ${prize} \
                                    </div> \
                                    <div class="back-flip"> \
                                        ${card} \
                                    </div> \
                                </div> \
                            </div>`;
                document.getElementById('stream-widget').innerHTML = html;
                setTimeout(() => {
                    document.querySelector('.card-flip').classList.add("flipped");
                }, 2000); // 2 seconds
                setTimeout(() => {
                    document.getElementById('stream-widget').innerHTML = "";
                }, 4000); // two seconds

            }
        };
  </script>
</html>