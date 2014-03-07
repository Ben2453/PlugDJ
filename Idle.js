//paste this code in your console screen to get the idle status.
$.ajax({ type: 'POST', url: 'http://plug.dj/_/gateway/user.set_status', contentType: 'application/json', data: '{ "service": "user.set_status", "body": ["4"] }' });
