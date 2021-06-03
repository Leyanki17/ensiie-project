    

  


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


function addToplaylist(event) {

    let elt = event.target

    
    let xhr = getXmlHttpRequest();
    console.log(xhr);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            alert(xhr.responseText);
        }
    }
    xhr.open("GET",elt.getAttribute("lien")+"/",true);
    xhr.send(xhr);
}