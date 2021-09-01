function activeColor (){
    var fav = document.getElementsByClassName('fav');
    for(var i; i < fav.length; i++){
        fav[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
    }  
}

function actionButtons(){
    var fav = document.getElementsByClassName('fav');
    for (var i = 0; i < fav.length; i++) {
        if(fav[i].id == "favourite"){
            fav[i].addEventListener("click", funFav);
        }
        else {
            fav[i].addEventListener("click", funAdd);
        }        
    } 
}

function funFav(){
    window.location.href="https://s113.labagh.pl/index.html?page=profile&content=favourite";
    
}
function funAdd(){
    window.location.href="https://s113.labagh.pl/index.html?page=profile&content=added";
    
}