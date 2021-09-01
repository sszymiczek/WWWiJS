function check_session() {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: 'https://s113.labagh.pl/backend/sessioncheck.php',
            dataType: 'text',
            success: function(result) {
                result = parseInt(result);
                resolve(result);
            },
            error: function(err) {
                reject(err);
            }
        });
    });
}

function insert_navigation() {
    check_session().then(function(session) {
        if (session === 1 || session === 2) {
            $("#navigation").append('' +
                '<li class="nav-item">' +
                    '<a class="nav-link" href="./index.html?page=waiting">Waiting</a>' +
                '</li>' +
                '<li class="nav-item">' +
                    '<a class="nav-link" href="./index.html?page=profile">Profile</a>' +
                '</li>');
            $("#navbarSupportedContent").append('' + 
                '<form action="../../backend/logout.php" id="logout-form" method="POST">' +
                    '<button class="btn btn-danger" name="logoutbutton" type="submit">SignOut</button>' + 
                '</form>');
            if (session === 2) {
                $("#navigation").append('' +
                '<li class="nav-item">' +
                    '<a class="nav-link" href="./index.html?page=admin">AdminPanel</a>' +
                '</li>');
            }
        }
    }).catch(function(err) {
        console.log(err)
    });
}