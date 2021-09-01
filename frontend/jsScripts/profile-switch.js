function getContent(){
    var content = window.location.search;
    const urlParams = new URLSearchParams(content);
    const page_type = urlParams.get('page');
    return page_type;
}
function changeContent(content) {
    if(content == "favourite") {
        changeToFav;
    }else if(content == "added") {
        changeToAdd;
    }
}

function changeToFav() {
    var id = getJSessionId();
    var link = 'https://s113.labagh.pl/backend/api/fpfti/read_user_fpfti.php?user_id=' + id + '';

    $.ajax({
    url: link,
    type: "GET",
    dataType : "text",
    })
    .done(function(json) {
        var tablica_json = JSON.parse(json);
        jQuery.each(tablica_json.data, function() {
            template(this.link, this.user_id, this.title, this.id, this.likes, ".fpfti-template");
        });
    })
    .fail(function(xhr, status, errorThrown) {
        alert("Data not found");
    });
}
function changeToAdd() {
    var id = getJSessionId();
    var link = 'https://s113.labagh.pl/backend/api/fpfti/read_user_fpfti.php?user_id=' + id + '';
    
    $.ajax({
    url: link,
    type: "GET",
    dataType : "text",
    })
    .done(function(json) {
        var tablica_json = JSON.parse(json);
        jQuery.each(tablica_json.data, function() {
            template(this.link, this.user_id, this.title, this.id, this.likes, ".fpfti-template");
        });
    })
    .fail(function(xhr, status, errorThrown) {
        alert("Data not found");
    });
}