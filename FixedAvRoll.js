/* 
	Avatar  Roller created by Sidewinder
*/

var rollTime = 1000; /* how long (in ms) is active one avatar */

var avatary = ["animal08", "animal05", "animal06", "animal02", "animal09", "animal01", "animal10", "animal11", "animal14", "animal13", "monster01", "monster04", "monster02", "monster05", "monster03", "animal07",  "animal04", "animal03", "animal12", "lucha01", "lucha02", "lucha04", "lucha07", "lucha08", "lucha05", "lucha03", "lucha06", "space01", "space02", "space03", "space06", "space04", "space05", "warrior01", "warrior02", "warrior03", "warrior04"];
function zmenitAvatar(){
	$.ajax({
	        url: "http://plug.dj/_/gateway/user.set_avatar_1",
	        type: 'POST',
	        data: JSON.stringify({
	          service: "user.set_avatar_1",
	          body: [
	            
	        	avatary[Math.floor(Math.random()*avatary.length)]
	            
	          ]
	        }),
	        async: this.async,
	        dataType: 'json',
	        contentType: 'application/json'
	      })

}

setInterval(zmenitAvatar, rollTime);
