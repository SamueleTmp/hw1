function cerca_utente(event)
{
    console.log(form3.nome_utente.value);
    if(form3.nome_utente.value.length == 0)
        {
            form3.nome_utente.placeholder="è senza nome?!";
            
            event.preventDefault();    
        }
        else
        {
            event.preventDefault();
    
            let data = {
                nome_utente: form3.nome_utente.value,
            };
             
    
            fetch("../php/upload_altri_utenti.php",
            {
                method: "POST",
                body: JSON.stringify(data),
                header: {
                    "Content-type": "application/json"
                        }
    
            }).then(onResponse).then(onJSON_upload_altri_utenti);
        }
}

function onJSON_upload_altri_utenti(json)
{
    console.log(json);

    let left = document.querySelector(".flex_container .flex_left .sub-bottom");
    
    left.innerHTML="";

    let img = document.createElement("img");
    let div_box = document.createElement("div")
    let div_usr = document.createElement("div");
    let a_profilo = document.createElement("a");
    
    
    img.src = "data:image/jpg;charset=utf8;base64," + json[1];
    div_usr.textContent=json[0];
    a_profilo.href="../php/profilo_altri_utenti.php";

    left.appendChild(div_box);
    div_box.appendChild(a_profilo);
    a_profilo.appendChild(img);
    div_box.appendChild(div_usr);



}

function onResponse(response)
{
    console.log("Risposta Ricevuta");
    return response.json();
}

const form3=document.forms['ricerca_utenti_form'];
form3.addEventListener('submit', cerca_utente);




