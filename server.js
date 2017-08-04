
function getResponse(url, callback) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200) {
			callback(xhttp.responseText);
		}
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}

// Dependencies.
var express = require('express');
var http = require('http');
var path = require('path');
var socketIO = require('socket.io');

var app = express();
var server = http.Server(app);
var io = socketIO(server);

app.set('port', 5000);
app.use('/static', express.static(__dirname + '/static'));

// Routing
app.get('/', function(request, response) {
  response.sendFile(path.join(__dirname, 'index.html'));
});

server.listen(5000, function() {
  console.log('Starting server on port 5000');
});

var players = {};
io.on('connection', function(socket) {
  socket.on("disconnect", function() {
	  players[socket.id] = {
		  x: -1000000,
		  y: -1000000,
		  connected: false
	  };

  });
  
  socket.on('new player', function() {
    players[socket.id] = {
      x: 0,
      y: 430,
	  connected: true
    };
  });
  socket.on('movement', function(data) {
    var player = players[socket.id] || {};
	var oldy = player.y;
	var jumping = false;
    if (data.left) {
      player.x -= 3;
	  if(player.x < 0)
		  player.x = 0;
    }
    if (data.up) {
		var jump = setInterval(function() {
			player.y -= 3;
		}, 5);
		setTimeout(function() {
			clearInterval(jump);
			var jumpy = setInterval(function() {
				player.y += 3;
			}, 5);
			setTimeout(function() {
				clearInterval(jumpy);
			}, 15);
		}, 15);
		
    }
    if (data.right) {
      player.x += 3;
	   if(player.x > 1366 - 25)
		  player.x = 1366 - 25;
	  
	  
    }
    if (data.down) {
      //player.y += 5;
	   if(player.y > 638 - 25)
		  player.y = 638 - 25;
    }
  });
});

setInterval(function() {
  io.sockets.emit('state', players);
}, 1000 / 60);
