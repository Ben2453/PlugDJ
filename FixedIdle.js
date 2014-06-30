//Created by sidewinder
//paste this code in your console screen to get the idle status.
$.ajax({ type: 'POST', url: 'http://plug.dj/_/gateway/user.set_status_1', contentType: 'application/json', data: '{ "service": "user.set_status_1", "body": ["4"] }' });
