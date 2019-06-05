var randomString = function(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

var pkey_maker = randomString(10) + "-" + randomString(6) + "-" + randomString(12) + "-" + randomString(3);
ConfigData = ' {"FRONT_END_PRIVATE_KEY": \"' + pkey_maker + '\"  , "SIGNUP_SCRIPT_URL" : "http://localhost:444/CleedBackEnd/request/RequestRegister.php","LOGIN_SCRIPT_URL":"http://localhost:444/CleedBackEnd/request/RequestLogin.php", "CHECK_SESSION_SCRIPT_URL" : "http://localhost:444/CleedBackEnd/request/RequestCheckLogin.php" , "LOGOUT_SCRIPT_URL" : "http://localhost:444/CleedBackEnd/request/RequestLogout.php","UPDATE_SESSION_SCRIPT_URL" : "http://localhost:444/CleedBackEnd/request/RequestUpdateSession.php","GET_ID_SCRIPT_URL" : "http://localhost:444/CleedBackEnd/request/RequestGetId.php" }';