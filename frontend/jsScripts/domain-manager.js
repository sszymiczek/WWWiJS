function findGetParameter(parameterName) {
    var result = null;
        tmp = [];
    location.search.substr(1).split("&").forEach(function (item) {
        tmp = item.split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    });
    return result;
}

$(function(){
    check_session().then(function(session) {
        var result = findGetParameter("page"); 
        if (session === 0) {
            if (result === null || result === "main") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/main.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/login.html");
                $("#aside-second").load("https://s113.labagh.pl/frontend/aside-subdomains/registration.html");
            } else if (result === "top") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/top.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/login.html");
                $("#aside-second").load("https://s113.labagh.pl/frontend/aside-subdomains/registration.html");
            } else if (result === "fpfti") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/fpfti.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/login.html");
                $("#aside-second").load("https://s113.labagh.pl/frontend/aside-subdomains/registration.html");
            } else if (result === "search") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/search.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/login.html");
                $("#aside-second").load("https://s113.labagh.pl/frontend/aside-subdomains/registration.html");
            } else {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/oops.html");
            }
        }
        if (session === 1 || session === 2) {
            if (result === null || result === "main") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/main.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/sleeping-reaper.html");
            } else if (result === "top") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/top.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/sleeping-reaper.html");
            } else if (result === "fpfti") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/fpfti.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/sleeping-reaper.html");
            } else if (result === "waiting") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/waiting.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/sleeping-reaper.html");
            } else if (result === "profile") {
                var res = findGetParameter("content");
                if (res === null || res === "added") {
                    $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/profile.html");
                } else if (res === "favourite") {
                    $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/favourite.html");
                }
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/information.html");
                $("#aside-second").load("https://s113.labagh.pl/frontend/aside-subdomains/add-fpfti.html");
            } else if (result === "settings") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/settings.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/information-settings.html");
            } else if (result === "search") {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/search.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/sleeping-reaper.html");
            } else if (result === "admin" && session === 2) {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/admin.html");
                $("#aside-first").load("https://s113.labagh.pl/frontend/aside-subdomains/remove.html");
                $("#aside-second").load("https://s113.labagh.pl/frontend/aside-subdomains/deadly-reaper.html");
            } else {
                $("#main-content").load("https://s113.labagh.pl/frontend/main-subdomains/oops.html");
            }
        }
    }).catch(function(err) {
        console.log(err)
    });  

    result = findGetParameter("mess");
    if (result === "uploadsuccess") {
        window.alert("Your FPftI was uploaded successfully!");
    } else if (result === "notitle") {
        window.alert("Your FPftI must have the title");
    } else if (result === "nofpfti") {
        window.alert("Your FPftI must include the FPftI");
    } else if (result === "wrongext") {
        window.alert("Extension of your FPftI in not allowed");
    } else if (result === "nofpfti") {
        window.alert("Your FPftI must include the FPftI");
    } else if (result === "uploaderror") {
        window.alert("Some error has occured during the upload");
    } else if (result === "toobig") {
        window.alert("Your FPftI is greater than 10MB. We don't have enough money for this kind of luxury");
    } else if (result === "registrationsuccess") {
        window.alert("Your account was registered successfully. Now try to login in!");
    } else if (result === "passwordthesame") {
        window.alert("Repeat password doesn't match to Password");
    } else if (result === "formnotfilled") {
        window.alert("Too less information provided");
    } else if (result === "tooshort") {
        window.alert("Provided login or password is too short");
    } else if (result === "wronglogpass") {
        window.alert("Provided login or password is wrong");
    } else if (result === "tagtoolong") {
        window.alert("Tags must be shorter than or equql to 64 characters (including '#')");
    } else if (result === "wrongtag") {
        window.alert("One or more provided tags have incorrect format");
    } else if (result === "fpftideleted") {
        window.alert("FPftI of given Id was deleted successfully");
    } else if (result === "accessdeny") {
        window.alert("You are not allowed to do that!");
    } else if (result === "error") {
        window.alert("Some other error has occured");
    } else if (result === "commentadded") {
        window.alert("Comment added successfully");
    } else if (result === "commentdeleted") {
        window.alert("Comment deleted successfully");
    } else if (result === "adminadded") {
        window.alert("The administrator's position was granted successfully");
    } else if (result === "admindeleted") {
        window.alert("The administrator's position was revoked successfully");
    } else if (result === "nosuchuser") {
        window.alert("No such user exists");
    } else if (result === "userdeleted") {
        window.alert("User was deleted successfully");
    } else if (result === "nosuchuser") {
        window.alert("No such user exists");
    } else if (result === "notloggedin") {
        window.alert("You must be signed in to do that");
    } else if (result === "nosuchfpfti") {
        window.alert("This FPftI doesn't exist");
    } else if (result === "fpftiaccepted") {
        window.alert("Acceptance was done successfully");
    } else if (result === "emptycomment") {
        window.alert("Your comment must contain comment");
    } else if (result === "nofpftiremove") {
        window.alert("FPftI with this Id doesn't exist");
    } else if (result === "nosuchcomment") {
        window.alert("Comment with this Id doesn't exist");
    } else if (result === "loginistaken") {
        window.alert("This login is already taken");
    } else if (result === "settingschanged") {
        window.alert("Your information was changed successfully");
    }
});