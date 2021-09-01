function addLikeCount(likeCount) {
    if (likeCount > 0) {
        return '+' + likeCount;
    } else {
        return likeCount;
    }
}

function addButtons(purpose, id) {
    var hreff = document.location;
    if (purpose === "admin") {
        return '' +
        '<form action="https://s113.labagh.pl/backend/acceptfpfti.php" class="col-4 like-form" method="POST">' + 
            '<input type="hidden" name="fpfti-id" value="' + id + '">' +
            '<button class="btn btn-success w-100 h-100" name="accept-button" value="1" type="submit">Accept</button>' +
        '</form>'+
        '<form action="https://s113.labagh.pl/backend/denyfpfti.php" class="col-4 like-form" method="POST">' +
            '<input type="hidden" name="fpfti-id" value="' + id + '">' +
            '<button class="btn btn-danger w-100 h-100" name="deny-button" value="1" type="submit">Deny</button>' +
        '</form>';
    } else {
        return '' +
        '<form action="https://s113.labagh.pl/backend/handlelike.php" class="col-4 like-form" method="POST">' + 
            '<input type="hidden" name="header" value="' + hreff + '">' +
            '<input type="hidden" name="fpfti-id" value="' + id + '">' +
            '<button class="btn btn-success w-100 h-100" name="like-button" value="1" type="submit">Like</button>' +
        '</form>'+
        '<form action="https://s113.labagh.pl/backend/handledislike.php" class="col-4 like-form" method="POST">' +
            '<input type="hidden" name="header" value="' + hreff + '">' +
            '<input type="hidden" name="fpfti-id" value="' + id + '">' +
            '<button class="btn btn-danger w-100 h-100" name="dislike-button" value="1" type="submit">Dislike</button>' +
        '</form>';
    } 
}

function template(pic, op, title, id, likeCount, classs, purpose) {
    var link = '"https://s113.labagh.pl/index.html?page=fpfti&id=' + id + '">';
    var temp = 
        '<div class="card">' +
            '<a href=' + link +
                '<div class="card-header">' +
                    '<h5>' + title + '</h5>' +
                '</div>' +
            '</a>' +
            '<div class="card-body">' +
                '<div class="badge bg-light text-dark">' +
                    '<form action="https://s113.labagh.pl/index.html" class="d-flex" method="GET">' +
                        '<input type="hidden" name="page" value="search"></input>' +
                        '<input type="hidden" name="query" value="' + op + '"></input>' +
                        '<button class="search-button" type="submit">Author: ' + op + '</button>' +
                    '</form>' +
                '</div> ' +
                '<span class="badge bg-light text-dark test">' +
                    'Id: ' + id +
                '</span>' +
                '<a href=' + link +
                    '<div class="d-flex justify-content-evenly p-2">' +
                        '<img src="' + pic + '" class="img-fluid">' +
                    '</div>' +
                '</a>' + 
                '<div class="row fpfti-buttons">' +
                    addButtons(purpose, id) +
                    '<button class="btn btn-info col-4 disabled">' + addLikeCount(likeCount) + '</button>' +
                '</div>' +
            '</div>' +
        '</div>';

    $(classs).append(temp);
}

function template_id(id) {
    var api_link = "https://s113.labagh.pl/backend/api/fpfti/read_fpfti.php?fpfti_id=" + id;
    $.ajax({
        url: api_link,
        type: "GET",
        dataType : "text",
    })
    .done(function(json) {
        var tablica_json = JSON.parse(json);
        jQuery.each(tablica_json.data, function() {
            var classs = ".fpfti-template";
            var temp = '' +
            '<div class="card">' +
                '<div class="card-header">' +
                    '<h5>' + this.title + '</h5>' +
                '</div>' +
                '<div class="card-body">' +
                    '<div class="badge bg-light text-dark">' +
                        '<form action="https://s113.labagh.pl/index.html" class="d-flex" method="GET">' +
                            '<input type="hidden" name="page" value="search"></input>' +
                            '<input type="hidden" name="query" value="' + this.user_id + '"></input>' +
                            '<button class="search-button" type="submit">Author: ' + this.user_id + '</button>' +
                        '</form>' +
                    '</div> ' +
                    '<span class="badge bg-light text-dark test">' +
                        'Id: ' + this.id +
                    '</span>' +    
                    '<div class="d-flex justify-content-evenly p-2">' +
                        '<img src="' + this.link + '" class="img-fluid">' +
                    '</div>' +
                    '<div class="tags"></div>' + '</br>' + 
                    '<div class="row fpfti-buttons">' +
                        addButtons("", id) +
                        '<button class="btn btn-info col-4 disabled">' + addLikeCount(this.likes) + '</button>' +
                    '</div>' +
                '</div>' +
            '</div>';

            $(classs).append(temp);

            var tags_link = "https://s113.labagh.pl/backend/api/fpfti/read_fpfti_tags.php?fpfti_id=" + id;
            $.ajax({
                url: tags_link,
                type: "GET",
                dataType : "text",
            })
            .done(function(json) {
                var tablica_json = JSON.parse(json);
                jQuery.each(tablica_json.data, function() { 
                    $(".tags").append('' + 
                        '<div class="badge bg-light text-dark">' +
                        '<form action="https://s113.labagh.pl/index.html" class="d-flex" method="GET">' +
                            '<input type="hidden" name="page" value="search"></input>' +
                            '<input type="hidden" name="query" value="' + this.tag + '"></input>' +
                            '<button class="search-button" type="submit">' + this.tag + '</button>' +
                        '</form>' +
                        '</div>' + " ");
                });
            })
            .fail(function(xhr, status, errorThrown) {
                alert("Data not found");
            });
        });
    })
    .fail(function(xhr, status, errorThrown) {
        alert("Data not found");
    });
}