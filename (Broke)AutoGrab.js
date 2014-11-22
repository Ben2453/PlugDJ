Grab = {};
Grab.check = function(e) {
    if (e === null) {
        API.chatLog("Autograb: There's no DJ", true);
        Grab.djname = null
    } else if (API.getDJ().username != API.getUser().username) {
        Grab.grab();
        Grab.djname = API.getDJ().username
    } else {
        if (Grab.djname != API.getUser().username) {
            API.chatLog("Autograb: You are now DJ", false);
            Grab.djname = API.getDJ().username
        }
    }
};
Grab.welcome = function() {
    API.chatLog("Autograb by @Sidewinder enabled!", true);
    API.chatLog("Coded for @APIBot!", true);
};
Grab.grab = function() {
    $(".icon-curate").click();
    $($(".curate").children(".menu").children().children()[0]).mousedown()
};
Grab.welcome();
Grab.check();
API.on(API.DJ_ADVANCE, Grab.check);
