<!doctype html>
<html>
    <head>
        <title>Notification</title>
        <script>
            if ("Notification" in window) {
                let ask = Notification.requestPermission();
                ask.then(permission => {
                    if (permission == "granted") {
                        let msg = new Notification("Title", {
                            body: "Hello world",
                            icon: ""
                        });
                        msg.addEventListener("click", event => {
                            alert("Click Received");
                        });
                    }
                })
            }
        </script>
    </head>
    <body>
    </body>
</html>
