var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var users = [];

app.use(function(req, res, next) {
    res.header('Access-Control-Allow-Origin', "*");
    res.header('Access-Control-Allow-Methods','*');
    res.header('Access-Control-Allow-Headers', '*');
    next();
})

http.listen(3000, function () {
    console.log('Listening to port 3000');
    // console.log(app)
    // console.log(http)
    // console.log(io)
});

io.on('connection', function (socket) {
    console.log("connect")
    socket.on("user_connected", function (user_id) {
        users[user_id] = user_id;
        io.emit('updateUserStatus', users);
        console.log("user connected "+ user_id);
    });
    socket.on("message",function(message){
        console.log("message")
        console.log(message)
        io.emit("newMessage",message)
    })
    socket.on('disconnect', function() {
        var i = users.indexOf(socket.id);
        users.splice(i, 1, 0);
        io.emit('updateUserStatus', users);
        console.log(users);
    });
});
