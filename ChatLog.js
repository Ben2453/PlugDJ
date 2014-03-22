 // Logs all messages & Commands into console.
  API.chatLog('ChatLog Now Running -Sidewinders Script')
  API.on (API.CHAT, function (data) {
    	console.log(data);
             var a = data.message.toLowerCase();
              if (a.indexOf('!') > -1)
              {
				
              }
              else if (a.indexOf(' ') > -1)
              {
				
              }
          })
