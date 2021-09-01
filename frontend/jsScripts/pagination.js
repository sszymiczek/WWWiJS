function findGetParameter(parameterName) {
    var result = null;
        tmp = [];
    location.search.substr(1).split("&").forEach(function (item) {
        tmp = item.split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    });
    return result;
}

function insert_pagination() {
    var page = findGetParameter('page');
    if (page === null) {
        page = "main";
    }
    var pag = findGetParameter('pag');
    if (pag <= 0 || pag === null || pag === NaN) {
        pag = 1;
    } else {
        pag = parseInt(pag);
    }

    var def_link = "https://s113.labagh.pl/index.html?page=" + page + "&pag=";
    var pag_prev = pag >= 2 ? pag-1 : pag;
    var pag_next = pag+1;
    var prev_link = def_link + pag_prev;
    var next_link =  def_link + pag_next;

    var pagination = '' +
        '<li class="page-item">' +
            '<a class="page-link" href="' + prev_link + '">Prev</a>' + 
        '</li>' +
        '<li class="pag-item">' +
            '<form class="d-flex page-item" action="https://s113.labagh.pl/index.html" method="GET">' +
                '<input type="hidden" name="page" value="' + page + '">' +
                '<input class="page-link" style="width: 60px !important;" type="number" name="pag" value="' + pag + '">' +
                '<button class="page-link" type="submit">Go</button>' +
            '</form>' +
        '</li>' +
        '<li class="page-item">' + 
            '<a class="page-link" href="' + next_link + '">Next</a>' +
        '</li>';
    $('.pagination').append(pagination);
      
    var link = "https://s113.labagh.pl/backend/api/fpfti/read_" + page + ".php?page=" + pag;
    $.ajax({
        url: link,
        type: "GET",
        dataType : "text",
    })
    .done(function(json) {
        var tablica_json = JSON.parse(json);
        jQuery.each(tablica_json.data, function() {
            var purpose;
            if (page === 'admin') {
                purpose = "admin"
            } else {
                purpose = "";
            }
            template(this.link, this.user_id, this.title, this.id, this.likes, ".fpfti-template", purpose);
        });
    })
    .fail(function(xhr, status, errorThrown) {
        alert("Data not found");
    });
}