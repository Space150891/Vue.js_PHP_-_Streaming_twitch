jQuery(document).ready(function() {
  var tick = new Audio('assets/media/tick.mp3');

  $('.easyWheel').easyWheel({
    items: [{
        id: '1',
        name: "10.000  <i class=icon-cube3 mr-2></i>",
        color: "rgb(231, 76, 60)",
        message: "You won 10.000 Credits!"
      },
      {
        id: '2',
        name: "1.000 <i class=icon-cube3 mr-2></i>",
        color: "rgb(231, 76, 60)",
        message: "#333"
      },
      {
        id: '3',
        name: "Card",
        color: "rgb(39, 174, 96)",
        message: "You won a Card!"
      },
      {
        id: '4',
        name: "1.000 <i class=icon-cube3 mr-2></i>",
        color: "rgb(241, 196, 15)",
        message: "You won 1.000 Credits!"
      },
      {
        id: '5',
        name: "Tier 1",
        color: "rgb(41, 128, 185)",
        message: "You won a Tier 1 Price!"
      },
      {
        id: '6',
        name: "Cover",
        color: "rgb(46, 204, 113)",
        message: "You won a Cover!"
      }
    ],
    duration: 15000,
    rotates: 7,
    frame: 1,
    easing: "easyWheel",
    rotateCenter: false,
    type: "spin",
    markerAnimation: true,

    width: 400,
    fontSize: 20,
    textOffset: 6,
    letterSpacing: 0,
    textLine: "v",
    textArc: false,
    shadowOpacity: 3,
    sliceLineWidth: 2,
    outerLineWidth: 5,
    centerWidth: 50,
    centerLineWidth: 4,
    centerImageWidth: 42,
    textColor: "rgb(255, 255, 255)",
    markerColor: "rgb(192, 57, 43)",
    centerLineColor: "#424242",
    centerBackground: "#333333",
    sliceLineColor: "#424242",
    outerLineColor: "#424242",
    shadow: "#000",
    selectedSliceColor: "#333",

    button: '.spin-button',
    centerImage: "assets/images/StreamCases/common.png",

    frame: 1,
    ajax: {
      url: 'http://localhost/wheel.php?scid=' + '123456', //Change http://localhost/ to your website name
      type: 'POST',
      nonce: true //enable Additional security
    },
    onStart: function(results, count, now) {
      $(".spin-button").fadeOut("slow", function() {
        $(".spin-button").remove();
      });

      $('.easyWheel-message').html("Good luck!");

    },
    onComplete: function(results, count, now) {
      $(".redeem-button").fadeIn("fast", function() {
        $(".redeem-button").fadeTo(100, 0.1).fadeTo(200, 1.0);

      });
      $('.easyWheel-message').html(results.message);
      console.log(results.message);

    },
    onStep: function(item, slicePercent, circlePercent) {
      if (typeof tick.currentTime !== 'undefined')
        tick.currentTime = 0;
      tick.play();
    },

  });
});