/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license BSD
 */
"use strict";

const fs = require("fs");
const login = require("facebook-chat-api");

module.exports = {
	"login": function (email, pass) {
		login({email: email, password: pass}, (err, api) => {
		    if(err) return console.error(err);
		    fs.writeFileSync('storage/state/appstate.json', JSON.stringify(api.getAppState()));
		});
	}
};
