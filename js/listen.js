/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license BSD
 */
"use strict";

const fs = require("fs");
const login = require("facebook-chat-api");
const exec = require('child_process').exec;

module.exports = {
    "listen": function (fb) {
        fb = JSON.parse(fb);
        login({appState: JSON.parse(fs.readFileSync('storage/state/appstate.json', 'utf8'))}, (err, api) => {
            if(err) return console.error(err);
            console.log(fb);

            // debug only
            // api.setOptions({
            //     selfListen: true,
            //     logLevel: "silent"
            // });

            api.listen((err, message) => {
                if(err) return console.error(err);
                if (
                    (fb["listen_to"].indexOf(message.threadID) != -1 ||
                         fb["listen_to"][0] === "*") && 
                    message.senderID != fb["bot_user_id"]
                ) {
                    var child = exec('php js_bridge.php "'+encodeURIComponent(JSON.stringify(message))+'"',
                        function (error, stdout, stderr) {
                            try {
                                var s = JSON.parse(decodeURIComponent(stdout));
                                console.log(s);
                                if (s["send"] == true) {
                                    api.sendMessage(s["text"], s["thread_id"]);
                                }
                            } catch (e) {
                                console.log(stdout, stderr);
                                console.log("There was an error: " + e.message);
                                api.sendMessage(e.message, message.threadID);
                            }
                    });
                }
            });
        });
    }
};
