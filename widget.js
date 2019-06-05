$(document).ready(function() {
    var d = document;

    var widgetDiv = d.getElementById("chat-widget");
    var widgetIframePanel = d.createElement("div");
    var widgetFormIframePanel = d.createElement("div");
    var widgetChatIframePanel = d.createElement("div");
    var style = d.createElement("link");



    a(cleedChat.widget.accessToken).then(function(response) {
        console.log(response);
        injectWidget();
    }).catch(function(err) {
        console.log(err);
        return false;
    })





    function a(token) {

        return new Promise((resolve, reject) => {
            var formdata = new FormData;
            formdata.append("accessToken", token);
            formdata.append("verifyToken", true);
            if (typeof(axios) !== "undefined") {
                axios({
                    method: "POST",
                    url: "http://localhost:444/CleedBackEnd/request/RequestVerifyToken.php",
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





    function ins(sr) {
        s = d.createElement("script");
        s.type = "text/javascript";
        s.defer = true;
        s.src = sr;
        t = d.getElementsByTagName("script")[0];
        t.parentNode.insertBefore(s, t);
    }

    function injectWidget() {


        //inject required scripts  
        ins("https://code.jquery.com/jquery-3.3.1.slim.min.js");
        ins("https://res.cloudinary.com/dp1lewjma/raw/upload/v1557439637/axios.js");



        widgetIframePanel.setAttribute("id", "chat-widget-frame");
        widgetIframePanel.setAttribute("class", "bottom right");
        widgetIframePanel.setAttribute("style", 'outline: none !important; visibility: visible !important; resize: none !important; overflow: visible !important; background: #000 transparent !important; opacity: 1 !important; position: fixed !important; border: 0px !important; padding: 0px !important; transition-property: none !important; z-index: 1000001 !important; cursor: auto !important; float: none !important; height: 100px !important; min-height: 60px !important; max-height: 100px !important; width: 80px !important; min-width: 60px !important; max-width: 80px !important; border-radius: 50% !important; transform: rotate(0deg) translateZ(0px) !important; transform-origin: 0px center !important; margin: 0px !important; top: auto !important; bottom: 10px !important; right: 30px !important; left: auto !important; display: block !important;');

        widgetFormIframePanel.setAttribute("id", "chat-widgetForm-frame");
        widgetFormIframePanel.setAttribute("class", "bottom right");
        widgetFormIframePanel.setAttribute("style", 'outline: none !important; visibility: hidden !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: transparent !important; opacity: 1 !important; position: fixed !important; border: 0px !important; padding: 0px !important; transition-property: none !important; cursor: auto !important; float: none !important; border-radius: unset !important; transform: rotate(0deg) translateZ(0px) !important; transform-origin: 0px center !important; bottom: 30px !important; top: 100px !important; right: auto !important; left: 75% !important; width: 300px !important; max-width: 300px !important; min-width: 124px !important; height: 700px !important; max-height: 800px !important; min-height: 95px !important; z-index: 999999 !important; margin: 0px !important; display:block !important');




        widgetChatIframePanel.setAttribute("id", "chat-widgetChat-frame");
        widgetChatIframePanel.setAttribute("class", "bottom right");
        widgetChatIframePanel.setAttribute("style", ' outline: none !important;visibility: hidden !important; resize: none !important; box-shadow: none !important; overflow: visible !important; background: transparent !important; opacity: 1 !important; position: fixed !important; border: 0px !important; padding: 0px !important; transition-property: none !important; cursor: auto !important; float: none !important; border-radius: unset !important; transform: rotate(0deg) translateZ(0px) !important; transform-origin: 0px center !important; bottom: 30px !important; top: 100px !important; right: 20px !important; left: auto !important; width: 300px !important; max-width: 300px !important; min-width: 124px !important; height: 400px !important; max-height: 400px !important; min-height: 95px !important; z-index: 999999 !important; margin: 0px !important; display: block !important;');

        var frameEl = window.frameElement;
        if (!frameEl) {
            // ...your append code here...
            widgetDiv.appendChild(widgetIframePanel);
            widgetDiv.appendChild(widgetFormIframePanel);
            widgetDiv.appendChild(widgetChatIframePanel);
            d.body.appendChild(widgetDiv);
        }
        var widgetIframe = d.getElementById('chat-widget-frame');
        var widgetFormIframe = d.getElementById('chat-widgetForm-frame');
        var widgetChatIframe = d.getElementById('chat-widgetChat-frame');

        head = d.getElementsByTagName("head")[0];
        style.rel = "stylesheet";
        style.href = "https://res.cloudinary.com/dp1lewjma/raw/upload/v1557436091/widget.css";
        style.crossorigin = "anonymous";
        head.appendChild(style);

        //properties for the widget icon
        widgetIcon = d.createElement("div");
        widgetIcon.setAttribute("class", "control");
        widgetIframe.appendChild(widgetIcon);

        $('.control').html('<div id="icon-close"></div>  <span id="icon-open"></span>');


        //properties for form

        widgetFormDiv = d.createElement("div");
        widgetFormDiv.setAttribute("class", "form");
        widgetFormDiv.setAttribute("id", "form");
        widgetFormIframe.appendChild(widgetFormDiv);
        $('.form').html('<form action=""> <div class="form-title"> <p>Have a chat with us &#128522; !!</p> </div> <div class="form-details"> <div class="input-group"> <div class="input"> <input id="formName" type="text" placeholder="Name"> </div> <div class="input"> <input id="formEmail" type="text" placeholder="Enter Email"> </div> <div class="input"> <textarea name="" id="formMessage" cols="30" rows="10" placeholder="Enter Message"></textarea> </div> <div class="input button"> <button type="button" id="startChat"> Start Chat</button> </div> </div> </div> </form>');


        //properties for chat
        widgetChatDiv = d.createElement("div");
        widgetChatDiv.setAttribute("class", "chatForm form");
        widgetChatDiv.setAttribute("id", "form");
        widgetChatIframe.appendChild(widgetChatDiv);
        $('.chatForm').html(' <div class="form-title"> <p> Online for a chat <button> Exit Chat</button></p> </div> <div class="widget-chat"> <div class="widget-chatBackground"> <table> <thead> <th></th> <th></th> </thead> <tbody></tbody> </table> </div> <div class="chat-input"> <div class="chat-textfield"> <ul> <li> <input type="text" id="mesage" placeholder="Enter Message" /></li> <li><button id="send">Send</button></li> </ul> </div> </div> </div> ');

        var openWidget = d.getElementById('icon-open');
        var closeWidget = d.getElementById('icon-close');

        var startchat = d.getElementById('startChat');
        var chatStart = false;

        openWidget.onclick = function() {
            openWidget.style.display = "none";
            closeWidget.style.display = "block";
            widgetFormIframe.style.visibility = 'visible';
            widgetChatIframe.style.visibility = 'hidden';
        }
        closeWidget.onclick = function() {
            openWidget.style.display = "block";
            closeWidget.style.display = "none";

            widgetFormIframe.style.visibility = 'hidden';
            widgetChatIframe.style.visibility = 'hidden';
        }
        startchat.onclick = function() {
            widgetFormIframe.style.visibility = 'hidden';
            startConversation().then(function(response) {
                widgetChatIframe.style.visibility = 'visible';
            }).catch(function(err) {
                console.log(err);
            });
        };
    } // end of injectWidget Class

    function startConversation() {

        return new Promise((resolve, reject) => {

            if ((formName.value != undefined || formName.value != "") &&
                (formEmail.value != undefined || formEmail.value != "") &&
                (formMessage.value != undefined || formMessage.value != "")) {


                var formdata = new FormData;
                formdata.append("formName", fromName.value);
                formdata.append("formEmail", fromEmail.value);
                formdata.append("formMessage", fromMessage.value);

                if (typeof(axios) !== "undefined") {
                    axios({
                        method: "POST",
                        url: "http://localhost:444/CleedBackEnd/request/RequestSubmitForm.php",
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
            }
        });
    }



});