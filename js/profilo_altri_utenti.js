function onJSON_info_utente(json)
{
    console.log(json);

    //Creo gli elementi
    let img=document.createElement("img");
    let div_usr=document.createElement("div");
    div_usr.classList.add("username");
   
    let div_picprofile = document.createElement("div");
    div_picprofile.classList.add("div_pic_profile");

    
    let a_profilo=document.createElement("a");
    
    a_profilo.href="../php/profilo_altri_utenti.php";
    

    img.src = "data:image/jpg;charset=utf8;base64," + json['picprofile'];

    
    div_usr.textContent=json['username'];
    
    //Ora appendo gli elementi
    let div_up = document.querySelector(".flex_container .flex_left .up");

    div_up.appendChild(div_picprofile);

    div_picprofile.appendChild(a_profilo);
    a_profilo.appendChild(img);
    div_up.appendChild(div_usr);

    
}

function onResponse(response)
{
    console.log("Risposta ricevuta");
    return response.json();
}

fetch("../php/info_altri_utenti_profilo.php").then(onResponse).then(onJSON_info_utente);

