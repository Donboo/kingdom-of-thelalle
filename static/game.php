var socket = io();

var movement = {
	up: false,
	down: false,
	left: false,
	right: false
}
document.addEventListener('keydown', function(event) {
	switch(event.keyCode) {
	case 65: // A
		movement.left = true;
		break;
	case 87: // W
		movement.up = true;
		break;
	case 68: // D
		movement.right = true;
		break;
	case 83: // S
		movement.down = true;
		break;
	}
});

socket.emit('new player');
setInterval(function() {
	socket.emit('movement', movement);
}, 1000 / 60);

//alert("gg");

$.ajax({
	url: "http://localhost/system/get_blocks.php"
}).done(function(blocksJSON) {
	
	var blocks = JSON.parse(blocksJSON);
	
	var maxHeight = 575;
	var maxWidth = 1000;
	
	var pPos = {x: 0, y: 0};
	
	var old_pos = {
		x: 0,
		y: 0
	};
	
	
	var asplit = document.cookie.split("; ");
	var usernameSplit = asplit[1].split("=");
	var username = usernameSplit[1];
	
	var canvas = document.getElementById('mCanvas');
	canvas.height = window.innerHeight;
	canvas.width = window.innerWidth;
	var context = canvas.getContext('2d');
	var menuActive = false;
	var apasatSpace = 0;
	var weaponId = 0;
	var msgShown = false;
	var msgShown2 =false;
	var upgradesMenu = false;
	var hasWeapon = false;
	var playerTookDownBlock = false;
	
	document.addEventListener('keydown', function(event) {
		switch (event.keyCode) {
			case 65: // A
			  movement.left = true;
			  break;
			case 87: // W
			  movement.up = false;
			  break;
			case 68: // D
			  movement.right = true;
			  break;
			case 83: // S
			  movement.down = false;
			  break;
			case 32:
				apasatSpace++;
				
				console.log(apasatSpace);
				if(apasatSpace > 50) {
					apasatSpace = 0;
					msgShown = true;
					context.font = "bold 45px Arial";
				
					context.fillText(username + " a spart un bloc! +25 xp", window.innerWidth/2-250, window.innerHeight/2-100);
					
					
					getResponse("http://localhost/system/update_xp.php?username=" + username, function(response) {
					});
					
					setTimeout(function() { msgShown = false; }, 3000);
					
				}
			break;
		}
	});
	
	document.addEventListener('keyup', function(event) {
	  switch (event.keyCode) {
		case 65: // A
		  movement.left = false;
		  break;
		case 87: // W
		  movement.up = false;
		  break;
		case 68: // D
		  movement.right = false;
		  break;
		case 83: // S
		  movement.down = false;
		  break;
	  case 27: // ESC
		  //meniu
		  if(menuActive == false && upgradesMenu == false) {
			  context.drawImage(document.getElementById("menu"), window.innerWidth/2-210, window.innerHeight/2-150);
			  menuActive = true;
		  }
		  else {
			menuActive = false;
			if(upgradesMenu) {
				upgradesMenu = false;
				$("#upgradesMenu").css("display", "none");
			}
		  }
		  break;
	  }
	});
	
	$("#upgrades").on("click", function(e) {
		$("#characters").css("display", "none");
		$("#upgrades").css("display", "none");
		menuActive = false;
		upgradesMenu = true;
		$("#upgradesMenu").css("display", "block");
		//
	});

	$("#buyBata").on("click", function(e) {
		getResponse("http://localhost/system/get_xp.php?username=" + username, function(response1) {
			var json1 = JSON.parse(response1);
			if(json1.experience >= 75) {
				getResponse("http://localhost/system/get_fightItem.php?username=" + username, function(response2) {
					var json2 = JSON.parse(response2);
					if(json2.weapon_upgrade == 1) {
						alert("Ai deja o bata!");
					} else {
						getResponse("http://localhost/system/set_fightItem.php?username=" + username + "&item=1", function(response3) { // mult prea vulnerabil...04:12
							var json3 = JSON.parse(response3);
							if(json3.ok == 1) {
								alert("Arma a fost upgradata!");
							} else {
								alert("Arma ta nu a putut fi upgradata!");
							}
						});
					}
				});
			} else {
				alert("Nu ai destula experienta!");
			}
		});
	});
	
	$("#buyTarnacop").on("click", function(e) {
		getResponse("http://localhost/system/get_xp.php?username=" + username, function(response1) {
			var json1 = JSON.parse(response1);
			if(json1.experience >= 150) {
				getResponse("http://localhost/system/get_fightItem.php?username=" + username, function(response2) {
					var json2 = JSON.parse(response2);
					if(json2.weapon_upgrade == 2) {
						alert("Ai deja un tarnacop!");
					} else {
						getResponse("http://localhost/system/set_fightItem.php?username=" + username + "&item=2", function(response3) { // mult prea vulnerabil...04:12
							var json3 = JSON.parse(response3);
							if(json3.ok == 1) {
								alert("Arma a fost upgradata!");
							} else {
								alert("Arma ta nu a putut fi upgradata!");
							}
						});
					}
				});
			} else {
				alert("Nu ai destula experienta!");
			}
		});
	});
	
	$("#buySabie").on("click", function(e) {
		getResponse("http://localhost/system/get_xp.php?username=" + username, function(response1) {
			var json1 = JSON.parse(response1);
			if(json1.experience >= 350) {
				getResponse("http://localhost/system/get_fightItem.php?username=" + username, function(response2) {
					var json2 = JSON.parse(response2);
					if(json2.weapon_upgrade == 3) {
						alert("Ai deja o sabie!");
					} else {
						getResponse("http://localhost/system/set_fightItem.php?username=" + username + "&item=3", function(response3) { // mult prea vulnerabil...04:12
							var json3 = JSON.parse(response3);
							if(json3.ok == 1) {
								alert("Arma a fost upgradata!");
							} else {
								alert("Arma ta nu a putut fi upgradata!");
							}
						});
					}
				});
			} else {
				alert("Nu ai destula experienta!");
			}
		});
	});
	
	var uniquenr = (parseInt((Math.random() * 100000)) % 5);
	
	setInterval(function() {
		$.ajax({
			url: "http://localhost/system/get_blocks" + uniquenr + ".php"
		}).done(function(rs) {
			blocks = JSON.parse(rs);
		});
	}, 1000);
	
	socket.on('state', function(players) {
		
		if(menuActive != false) return false;
		if(!hasWeapon) {
			getResponse("http://localhost/system/get_fightItem.php?username=" + username, function(response) {
				var json = JSON.parse(response);
				weaponId = json.weapon_upgrade;
				hasWeapon = true;
			});
		}
		context.clearRect(0, 0,  window.innerWidth,  window.innerHeight);
		
		if(msgShown) {
			
			var tp=players[socket.id];
			for(var i = 0; i < blocks.length; i++) {
				var block = blocks[i];

				if(block.pos_x == (Math.ceil(tp.x / 25) * 25)  && playerTookDownBlock == false) {
					$.ajax({
						url: "http://localhost/system/change_block_visibility.php?id=" + block.id
					}).done(function(response) {
						//var json = JSON.parse(response);
					});
					context.drawImage(document.getElementById("sky_small"), (Math.round(tp.x/25)*25)+25, 10);
					block.pos_x = -10000;
					block.pos_y = -10000;
					playerTookDownBlock = true;
					setTimeout(function(){ 			playerTookDownBlock = false; }, 3000);
				}
			}
			
			msgShown = false;
			msgShown2 = true;
			
		}
		
		if(msgShown2) {
			context.font = "bold 45px Arial";
			context.fillText(username + " a spart un bloc! +25 xp", window.innerWidth/2-250, window.innerHeight/2-100);
			setTimeout(function(){ 			msgShown2 = false; }, 3000);
		}
		
		var msgDie = false;
		
		for(var i = 0; i < blocks.length; i++) {
			var block = blocks[i];
			if(block.pos_x < 60*25 && block.pos_x != -10000 && block.visibility == 1) {
				context.drawImage(document.getElementById("block" + block.block_id), block.pos_x , (maxHeight - block.pos_y));
				
				/*
				if(block.pos_x == -100000) {
					var player = players[id];
					for(var i = 0; i < blocks.length; i++) {
						var block = blocks[i];
						if(block.was_pos == Math.round(player.x)) {
							player.y += 100; 
							msgDie = true;
						}
					}
				}
				*/
			}
		}
		
		/*
		if(msgDie) {
			context.font = "bold 45px Arial";
			context.fillText(username + " a murit! -25 xp", window.innerWidth/2-250, window.innerHeight/2-100);
			console.log("mortales");
		}
		*/
		
		//context.drawImage(document.getElementById("sky_small"), 0, 0);
		
		//pPos.x = players[socket.id].x;
		//pPos.y = players[socket.id].y;
		//alert("pana aici");
		for(var id in players) {
			var player = players[id];
			if(player.connected && player.x != "-1000000") {
				context.font = "bold 15px Arial";
				context.fillText(username, player.x, player.y);
				if(id == socket.id) {
					if(weaponId == 0) {
						if(movement.left) {
							context.drawImage(document.getElementById("characterImg4"), player.x, player.y);
						} else if(movement.right) {
							context.drawImage(document.getElementById("characterImg2"), player.x, player.y);
						} else {
							context.drawImage(document.getElementById("characterImg0"), player.x, player.y);
						}
					} else if(weaponId == 1) {
						if(movement.left) {
							context.drawImage(document.getElementById("characterImgc16"), player.x, player.y);
						} else if(movement.right) {
							context.drawImage(document.getElementById("characterImgc13"), player.x, player.y);
						} else {
							context.drawImage(document.getElementById("characterImgc15"), player.x, player.y);
						}
					} else if(weaponId == 2) {
						if(movement.left) {
							context.drawImage(document.getElementById("characterImgc28"), player.x, player.y);
						} else if(movement.right) {
							context.drawImage(document.getElementById("characterImgc25"), player.x, player.y);
						} else {
							context.drawImage(document.getElementById("characterImgc27"), player.x, player.y);
						}
					} else if(weaponId == 3) {
						if(movement.left) {
							context.drawImage(document.getElementById("characterImgc411"), player.x, player.y);
						} else if(movement.right) {
							context.drawImage(document.getElementById("characterImgc111"), player.x, player.y);
						} else {
							context.drawImage(document.getElementById("characterImgc311"), player.x, player.y);
						}
					}
				} else {
					context.drawImage(document.getElementById("characterImg0"), player.x, player.y);
				}
			}
			/*if(id == socket.id){
				context.drawImage(document.getElementById("characterImg" + pas), window.innerWidth/2, window.innerHeight/2);
			}*/
			
		}
	});
	//alert("am ajuns");
	
});

var loading = document.getElementById("loading");
		loading.classList.add("hidden");
		
		setTimeout(function() {
			loading.style.display = "none";
		}, 2000);

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

