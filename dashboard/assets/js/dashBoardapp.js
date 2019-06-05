$(document).ready(function() {


    (typeof(logOut) !== "undefined") ? logOut.onclick = function() {
        logout();
    }: null;


    function logout() {


        var sessionID = getCookies("sessionID");
        var formdata = new FormData

        formdata.append("logoutSession", true);
        formdata.append("sessionID", sessionID);
        if (typeof(axios) !== 'undefinded') {
            axios({
                method: "POST",
                url: LOGOUT_SCRIPT_URL,
                crossdomain: true,
                data: formdata
            }).then(function(response) {
                console.log(response);
                if (response.data['status'] == "success") {
                    window.open("/account/login.html?loggedout=true", "_self");
                    return true;
                } else
                if (response.data['status'] == "failed") {
                    alert("Error: Couldnt log Out please try again");
                    return false;
                }
            });
        }

    }
}());