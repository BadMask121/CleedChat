/**
 * Minified by jsDelivr using Terser v3.14.1.
 * Original file: /npm/js-cookie@2.2.0/src/js.cookie.js
 * 
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
! function(e) {
    var n = !1;
    if ("function" == typeof define && define.amd && (define(e), n = !0), "object" == typeof exports && (module.exports = e(), n = !0), !n) {
        var o = window.Cookies,
            t = window.Cookies = e();
        t.noConflict = function() {
            return window.Cookies = o, t
        }
    }
}(function() {
    function e() {
        for (var e = 0, n = {}; e < arguments.length; e++) {
            var o = arguments[e];
            for (var t in o) n[t] = o[t]
        }
        return n
    }
    return function n(o) {
        function t(n, r, i) {
            var c;
            if ("undefined" != typeof document) {
                if (arguments.length > 1) {
                    if ("number" == typeof(i = e({
                            path: "/"
                        }, t.defaults, i)).expires) {
                        var a = new Date;
                        a.setMilliseconds(a.getMilliseconds() + 864e5 * i.expires), i.expires = a
                    }
                    i.expires = i.expires ? i.expires.toUTCString() : "";
                    try {
                        c = JSON.stringify(r), /^[\{\[]/.test(c) && (r = c)
                    } catch (e) {}
                    r = o.write ? o.write(r, n) : encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent), n = (n = (n = encodeURIComponent(String(n))).replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent)).replace(/[\(\)]/g, escape);
                    var s = "";
                    for (var f in i) i[f] && (s += "; " + f, !0 !== i[f] && (s += "=" + i[f]));
                    return document.cookie = n + "=" + r + s
                }
                n || (c = {});
                for (var p = document.cookie ? document.cookie.split("; ") : [], d = /(%[0-9A-Z]{2})+/g, u = 0; u < p.length; u++) {
                    var l = p[u].split("="),
                        C = l.slice(1).join("=");
                    this.json || '"' !== C.charAt(0) || (C = C.slice(1, -1));
                    try {
                        var g = l[0].replace(d, decodeURIComponent);
                        if (C = o.read ? o.read(C, g) : o(C, g) || C.replace(d, decodeURIComponent), this.json) try {
                            C = JSON.parse(C)
                        } catch (e) {}
                        if (n === g) {
                            c = C;
                            break
                        }
                        n || (c[g] = C)
                    } catch (e) {}
                }
                return c
            }
        }
        return t.set = t, t.get = function(e) {
            return t.call(t, e)
        }, t.getJSON = function() {
            return t.apply({
                json: !0
            }, [].slice.call(arguments))
        }, t.defaults = {}, t.remove = function(n, o) {
            t(n, "", e(o, {
                expires: -1
            }))
        }, t.withConverter = n, t
    }(function() {})
});
//# sourceMappingURL=/sm/203d9606ffea7a776ef56994ac4d4a1ab0a18611bf5f22fd2f82e9b682eea54f.map


var fileName = location.pathname.split("/").slice(-1);
var CONFIG = JSON.parse(ConfigData);
//assign our requestURL global variable to reduce redundancy 
var SIGNUP_SCRIPT_URL = CONFIG.SIGNUP_SCRIPT_URL;
var LOGIN_SCRIPT_URL = CONFIG.LOGIN_SCRIPT_URL;
var LOGOUT_SCRIPT_URL = CONFIG.LOGOUT_SCRIPT_URL;
var CLIENT_PRIVATE_KEY = CONFIG.FRONT_END_PRIVATE_KEY;
var CHECK_SESSION_SCRIPT_URL = CONFIG.CHECK_SESSION_SCRIPT_URL;
var GET_ID_SCRIPT_URL = CONFIG.GET_ID_SCRIPT_URL;
var UPDATE_SESSION_SCRIPT_URL = CONFIG.UPDATE_SESSION_SCRIPT_URL;

var sessionexpire = new Date(new Date().getTime() + 60 * 170 * 60 * 1000);



$(document).ready(function() {

    /**
     * 
     * @method sessionAlive 
     * checks if user session if still set
     */
    var sessionAlive = function() {

        return new Promise((resolve, reject) => {

            var sessionID = getCookies("sessionID");
            if (sessionID == undefined) {
                reject(sessionID);
            }

            var formdata = new FormData

            if (typeof(axios) !== 'undefinded') {
                formdata.append("checkSession", true);
                formdata.append("sessionID", sessionID);
                axios({
                    method: "POST",
                    url: CHECK_SESSION_SCRIPT_URL,
                    crossdomain: true,
                    data: formdata
                }).then(function(response) {
                    console.log(response.data);
                    if (response.data['status'] == "success") {
                        resolve(response.data['status']);
                    } else if (response.data['status'] == "failed") {
                        reject(response.data['status']);
                    }
                }).catch(function(err) {
                    console.log(err);
                    reject(err);
                });

            }

        });
    }


    sessionAlive().then(function(res) {
        if (typeof(loginBtn) !== 'undefined') {
            loginBtn.style.background = "#ddd";
            loginBtn.style.color = "#113327";
            loginBtn.innerHTML = "Go to Dashboard";
            loginBtn.style.width = "auto";
            loginBtn.style.marginLeft = "-60px";
            loginBtn.setAttribute("href", "/dashboard/index.html");
        }
        if (fileName == "login.html") {
            window.open("/dashboard/index.html", "_self");
        }

    }).catch(function(err) {
        setCookies("sessionID", null);
        if (fileName == "login.html" || fileName == "app.html")
            return false;
        window.open("/account/login.html?loggedout=true", "_self");
    });


    setInterval(() => {
        sessionAlive().then(function(res) {
            if (typeof(loginBtn) !== 'undefined') {
                loginBtn.style.background = "#ddd";
                loginBtn.style.color = "#113327";
                loginBtn.innerHTML = "Go to Dashboard";
                loginBtn.style.width = "auto";
                loginBtn.style.marginLeft = "-60px";
                loginBtn.setAttribute("href", "/dashboard/index.html");
            }
            if (fileName == "login.html") {
                window.open("/dashboard/index.html", "_self");
            }

        }).catch(function(err) {
            console.log(err);
            setCookies("sessionID");
            if (fileName == "login.html" || fileName == "app.html")
                return false;
            window.open("/account/login.html?loggedout=true", "_self");
        });

    }, 30000);

    (typeof(signupbtn) !== 'undefined') ? signupbtn.onclick = function() {
        signup();
    }: null;

    (typeof(login_btn) !== 'undefined') ? login_btn.onclick = function() {
        login();
    }: null;



    (typeof(email) !== 'undefined') ? email.onkeyup = function(event) {
        if (!validateEmail(email.value)) {
            errorMessage.innerHTML = "Please enter a valid email";
            return false;
        } else {
            errorMessage.innerHTML = "";
        }
    }: null;

    $('#signup-form.form-body input').keyup(function(event) {

        switch (event.which || event.keycode) {
            case 13:
                signup();
                break;
            default:
                break;
        }
    });

    (typeof(newPassword) !== 'undefined') ? newPassword.onkeyup = function() {
        if (newPassword.value.length < 6) {
            errorMessage.innerHTML = "Password must be 6 characters higher";
            return false;
        } else {
            errorMessage.innerHTML = "";
        }

    }: null;

    (typeof(confirmPassword) !== 'undefined') ? confirmPassword.onkeyup = function() {
        if (newPassword.value !== confirmPassword.value) {
            errorMessage.innerHTML = "Please confirm your password";
            return false;
        } else {
            errorMessage.innerHTML = "";
        }

    }: null;




    /**
     * 
     * 
     * 
     * 
     * login function for interacting with server side code 
     */
    function login() {
        if (
            (email.value != undefined || email.value != "") &&
            (newPassword.value != undefined || newPassword.value != "")
        ) {
            errorMessage.innerHTML = "";
            if (!validateEmail(email.value)) {
                errorMessage.innerHTML = "Please enter a valid email";
                return false;
            }

            if (newPassword.value.length < 6) {
                errorMessage.innerHTML = "Password must be 6 characters higher";
                return false;
            }


            var formdata = new FormData;
            formdata.append("email", email.value);
            formdata.append("password", newPassword.value);
            deactiveSignUpField();
            errorMessage.innerHTML = "Verifying Please wait...";
            if (typeof(axios) !== 'undefinded') {
                axios({
                    method: "POST",
                    crossdomain: true,
                    url: LOGIN_SCRIPT_URL,
                    data: formdata
                }).
                then(function(response) {
                    if (response.data == "errorEmail") {
                        errorMessage.innerHTML = "Please enter a valid email";
                        activeSignUpField();
                        return false;
                    }
                    if (response.data == "errorPassword") {
                        errorMessage.innerHTML = "Password must be 6 characters higher";
                        activeSignUpField();
                        return false;
                    }

                    console.log(response.data);
                    if (response.data == "success") {
                        getUserID(email.value).then(function(res) {
                            updateSession(res).then(function(result) {
                                errorMessage.style.color = "green";
                                errorMessage.innerHTML = "Welcome " + email.value + " You'll Signed In Shortly";

                                setTimeout(() => {
                                    window.open("/dashboard/index.html", "_self");
                                }, 3000);
                                return;

                            }).catch(function(err) {
                                errorMessage.style.color = "red";
                                errorMessage.innerHTML = err;
                                activeSignUpField();
                            });

                        }).catch(function(err) {
                            errorMessage.style.color = "red";
                            errorMessage.innerHTML = err;
                            activeSignUpField();
                        });


                    } else if (response.data == "failed") {
                        errorMessage.innerHTML = "Invalid Credentials";
                        activeSignUpField();
                        return false;
                    } else {
                        errorMessage.innerHTML = "Error: Please try again or contact customer support";
                        activeSignUpField();
                        return false;
                    }
                }).catch(function(error) {
                    console.log(error);
                });
            }

        } else {
            errorMessage.innerHTML = "one or more fields empty";
            return false;
        }
    }


    /**
     * 
     * @method signup function for any app calling
     */
    function signup() {

        if (
            (fullName.value != undefined && fullName.value != "") &&
            (email.value != undefined && email.value != "") &&
            (newPassword.value != undefined && newPassword.value != "") &&
            (confirmPassword.value != undefined && confirmPassword.value != "")
        ) {
            errorMessage.innerHTML = "";
            if (!validateEmail(email.value)) {
                errorMessage.innerHTML = "Please enter a valid email";
                return false;
            }

            if (newPassword.value.length < 6) {
                errorMessage.innerHTML = "Password must be 6 characters higher";
                return false;
            }

            if (newPassword.value !== confirmPassword.value) {
                errorMessage.innerHTML = "Please confirm your password";
                return false;
            }

            // encConPassword =confirmPassword;
            var formdata = new FormData;
            formdata.append("fullname", fullName.value);
            formdata.append("email", email.value);
            formdata.append("password", confirmPassword.value);


            deactiveSignUpField();
            errorMessage.innerHTML = "Signing Up Please wait...";


            if (typeof(axios) !== 'undefinded') {
                axios({
                    method: "POST",
                    url: SIGNUP_SCRIPT_URL,
                    crossdomain: true,
                    data: formdata
                }).then((response) => {

                    if (response.data == "errorEmail") {
                        errorMessage.innerHTML = "Please enter a valid email";
                        activeSignUpField();
                        return false;
                    }
                    if (response.data == "errorPassword") {
                        errorMessage.innerHTML = "Password must be 6 characters higher";
                        activeSignUpField();
                        return false;
                    }

                    if (response.data == "errorRegistered") {
                        errorMessage.innerHTML = "Account already exists";
                        activeSignUpField();
                        return false;
                    }


                    if (response.data == "success") {

                        getUserID(email.value).then(function(res) {
                            updateSession(res).then(function(result) {

                                errorMessage.style.color = "green";
                                errorMessage.innerHTML = "Sign Up Successful !!!";
                                setTimeout(() => {
                                    window.open("/dashboard/index.html", "_self");
                                }, 3000);
                                return;

                            }).catch(function(err) {
                                errorMessage.style.color = "red";
                                errorMessage.innerHTML = err;
                                activeSignUpField();
                            });

                        }).catch(function(err) {
                            errorMessage.style.color = "red";
                            errorMessage.innerHTML = err;
                            activeSignUpField();
                        });

                        return true;
                    } else if (response.data == "failed") {
                        errorMessage.innerHTML = "Error: Account cant be created now";
                        setTimeout(() => {
                            errorMessage.innerHTML = "";
                        }, 2000);
                        activeSignUpField();
                        return false;
                    }
                }).catch((error) => {
                    console.log(error);
                });
            }

        } else {
            errorMessage.innerHTML = "one or more fields empty";
            return false;
        }
    }


    function deactiveSignUpField() {
        (typeof(fullName) !== 'undefined') ? fullName.disabled = true: null;
        (typeof(email) !== 'undefined') ? email.disabled = true: null;
        (typeof(newPassword) !== 'undefined') ? newPassword.disabled = true: null;
        (typeof(confirmPassword) !== 'undefined') ? confirmPassword.disabled = true: null;
        (typeof(login_btn) !== 'undefined') ? login_btn.disabled = true: null;
        (typeof(signupbtn) !== 'undefined') ? signupbtn.disabled = true: null;
    }

    function activeSignUpField() {
        (typeof(fullName) !== 'undefined') ? fullName.disabled = false: null;
        (typeof(email) !== 'undefined') ? email.disabled = false: null;
        (typeof(newPassword) !== 'undefined') ? newPassword.disabled = false: null;
        (typeof(confirmPassword) !== 'undefined') ? confirmPassword.disabled = false: null;
        (typeof(login_btn) !== 'undefined') ? login_btn.disabled = false: null;
        (typeof(signupbtn) !== 'undefined') ? signupbtn.disabled = false: null;
    }


    //returns userID from database
    function getUserID(value) {


        return new Promise((resolve, reject) => {

            if (value == null || value == "")
                return null;



            var formdata = new FormData;
            formdata.append("requestID", true);
            formdata.append("email", value);
            if (typeof(axios) !== 'undefinded') {
                axios({
                    method: "POST",
                    crossdomain: true,
                    url: GET_ID_SCRIPT_URL,
                    data: formdata
                }).then(function(response) {
                    resolve(response.data.id);
                }).catch(function(error) {
                    reject(error);
                });
            }
        });
    }
    //updates userSession on server
    function updateSession(userId) {


        return new Promise((resolve, reject) => {
            if (userId === null)
                return false;

            var sessionID = setCookies("sessionID", email.value, {
                path: '/',
                expires: sessionexpire
            });


            var formdata = new FormData;
            formdata.append("sessionID", sessionID);
            formdata.append("userID", userId);

            if (typeof(axios) !== 'undefinded') {
                axios({
                    method: "POST",
                    crossdomain: true,
                    url: UPDATE_SESSION_SCRIPT_URL,
                    data: formdata
                }).then(function(response) {
                    if (response.data["status"] == "success") {
                        resolve(response.data["status"]);
                    } else if (response.data["status"] = "failed") {
                        reject(response.data["status"]);
                    }
                }).catch(function(error) {
                    reject(error);
                });
            }
            // reject(false);
        });

    }










    /**
     * 
     * @param {*} email
     * email validattino 
     */
    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }



}());


function encrypt(data) {
    if (CLIENT_PRIVATE_KEY != null ||
        CLIENT_PRIVATE_KEY !== undefined &
        typeof(CryptoJS) !== 'undefined' &&
        typeof(salt) !== 'undefined') {
        return CryptoJS.AES.encrypt(data, CLIENT_PRIVATE_KEY).toString();
    }
    return null;
}

function decrypt(data) {
    if (CLIENT_PRIVATE_KEY != null ||
        CLIENT_PRIVATE_KEY !== undefined &
        typeof(CryptoJS) !== 'undefined' &&
        typeof(salt) !== 'undefined') {
        a = CryptoJS.AES.decrypt(data, CLIENT_PRIVATE_KEY);
        return a.toString(CryptoJS.enc.Utf8);
    }
    return null;
}

function setCookies(key, value, properties = null) {

    /* setCookies() funtion takes three arguments arg1 = cookie_key
    arg2 = cookie_value, arg3 =json object of properties for cookies (optional) , arg4 = privatekey for encrypting Cookies

    privatekey is needed to decrypt getCookies

    Encrytion is done using Cryto.js javascript lib AES cryption algorithim
    */
    if (key === null)
        return key;


    if (properties == null) {
        properties = {
            path: '/'
        };
    }

    if (value != undefined || value != "")
        value = encrypt(value);
    Cookies.set(key, value, properties);

    return value;
}


function deleteCookie(a = null) {
    var attr = {
        path: '/',
        expires: sessionexpire
    }
    if (a !== null) {
        a = Cookies.get(a);
        Cookies.remove(a, attr);
        // window.location = '/?logged_out=true';
        return true;
    }

    Object.keys(Cookies.get()).forEach(function() {
        for (var i = 0; i < arguments.length; i++) {
            Cookies.remove(arguments[i], attr);
            return false;
        }
    });
    // window.location = '/?logged_out=true';
    return false;
}



/* getCookies() funtion takes two arguments arg1 = cookie_key
    arg2 = privatekey for encrypting Cookies

   same privatekey used for setCookie encryption is needed to decrypt getCookies
    */

/***
 * 
 * using cryptoJs lib to encrypt our data on client side ,
 * encryted data will still
 * be encryted on server side
 */


function getCookies(a, enc = false) {

    /* getCookies() funtion takes two arguments arg1 = cookie_key
        arg2 = privatekey used for encrypting {arg1}

        same encrytedkey and privatekey used
        for setCookie encryption is needed to decrypt getCookies
    */

    var e = Cookies.get(a);
    if (e != null && e !== undefined && enc === true) {
        try {
            e = decrypt(e);
            return e;
        } catch (error) {
            return error;
        }
    } else {
        return e;
    }
    return null;
}