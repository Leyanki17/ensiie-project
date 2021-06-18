function getXmlHttpRequest(){
    let xhr;

    if(window.XMLHttpRequest || window.ActiveXObject){
        if(window.XMLHttpRequest){
            xhr = new XMLHttpRequest();
        }else{
            try{
                xhr = new ActiveXObject("Msxml2.XMLHTTP"); 
            }catch(e){
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
        return xhr;
    }else{
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }
}  

function managePlaylist(event){
    let op = event.target.getAttribute("op")
    if(op=="ajout"){
        addToplaylist()
    }else{
        removeFromPlaylist()
    }
}


function addToplaylist() {

    let div = document.getElementById("musicID");
    let liked = document.querySelector("#liked");
    let musicID = div.textContent;
    let xhr = getXmlHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            id=xhr.responseText;
            let btn = document.querySelector("#btn-ajax");
            if( id== "déja"){
                alert("Déja ajoutée à votre playlist");
                btn.innerHTML = "Rétirer de la playlist"
                btn.setAttribute("class","btn btn-dark")
                btn.setAttribute("op", "supprime")
            }else if(parseInt(id)> 0){
                alert("Bien ajoutée à votre playlist")
                btn.innerHTML = "Rétirer de la playlist"
                liked.innerHTML=parseInt(liked.innerHTML)+1+"";
                btn.setAttribute("class","btn btn-dark")
                btn.setAttribute("op", "supprime")
            }else{
                alert("Erreur lors ajout à votre playlist")
            }
        }
    }
    xhr.open("GET","/ajaxPlaylist?musicID="+musicID+"",true);
    xhr.send(xhr);
}



function removeFromPlaylist() {

    var div = document.getElementById("musicID");
    var musicID = div.textContent; 
    let xhr = getXmlHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            id=xhr.responseText;
            let btn = document.querySelector("#btn-ajax");
            if( id== "déja"){
                alert("Cette musique ne fait déja plus partie de votre playlist");
                btn.innerHTML = "Ajout à la playlist"
                
                btn.setAttribute("class","btn btn-green")
                btn.setAttribute("op", "ajout")
            }else if(parseInt(id)> 0){
                alert("Bien rétirer à votre playlist")
                btn.innerHTML = "Ajout à la playlist"
                liked.innerHTML = (parseInt(liked.innerHTML)-1)+"";
                btn.setAttribute("class","btn btn-green")
                btn.setAttribute("op", "ajout")
            }else{
                alert("Erreur lors ajout à votre playlist")
            }
        }
    }
    xhr.open("GET","/removePlaylist?musicID="+musicID+"",true);
    xhr.send(xhr);
}

