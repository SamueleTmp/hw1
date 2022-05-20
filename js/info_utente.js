

function onJSON_info_utente(json)
{
    console.log(json);

    //Creo gli elementi
    let h1=document.createElement("h1");
    let img=document.createElement("img");
    let p_usr=document.createElement("p");
    p_usr.classList.add("username");
   
    let div_post_pubblicati = document.createElement("div"); 
    let div_like_fatti = document.createElement("div");
    let div_like_ricevuti = document.createElement("div");
    let div_decoration = document.createElement("div");
    div_decoration.classList.add("decoration");
    let p=document.createElement("p");
    let a_logout=document.createElement("a");
    let a_profilo=document.createElement("a");
    
    a_profilo.href="../php/profilo.php";
    a_logout.href="../php/logout.php";


    //Gli riempio dei dati
    h1.textContent="Bentornato!"
    img.src = "data:image/jpg;charset=utf8;base64," + json['picprofile'];

    //Aggiungo l'event listener alla foto profilo per entrare nella pagina del profilo
    //img.addEventListener("click", apri_profilo);
    
    p_usr.textContent=json['username'];
    div_post_pubblicati.textContent="Post Pubblicati: "+json['post_pubblicati'];
    div_like_fatti.textContent="Like Effettuati: "+json['like_fatti'];
    if(json['like_ricevuti'] != null)
    {
        div_like_ricevuti.textContent="Like Ricevuti: "+json['like_ricevuti'];
    }
    else
        div_like_ricevuti.textContent="Like Ricevuti: 0";
    
    a_logout.textContent="Logout";

    //Ora appendo gli elementi
    let div_up = document.querySelector(".flex_container .flex_left .up");

    div_up.appendChild(h1);
    div_up.appendChild(a_profilo);
    a_profilo.appendChild(img);
    div_up.appendChild(p_usr);
    div_up.appendChild(div_post_pubblicati);
    div_up.appendChild(div_like_ricevuti);
    div_up.appendChild(div_like_fatti);
    div_up.appendChild(div_decoration);
    div_up.appendChild(p);
    p.appendChild(a_logout);
    
}

function onResponse(response)
{
    console.log("Risposta ricevuta");
    return response.json();
}

fetch("../php/info_utente.php").then(onResponse).then(onJSON_info_utente);