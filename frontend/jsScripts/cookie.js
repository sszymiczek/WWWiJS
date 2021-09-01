function getJSessionId() {
    var jsId = document.cookie.match(/PHPSESSID=[^;]+/);
    if(jsId != null) {
        if (jsId instanceof Array)
            jsId = jsId[0].substring(10,12);
        else
            jsId = jsId.substring(10,12);
    }
    else
        console.log("oops");
    return jsId;
}