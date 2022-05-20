function onJSON_cerca_film(json)
{

    //Cerco il div_right
    let right = document.querySelector("article .flex_container .flex_right .bottom");

    //libero l'elemento se è presente qualcosa
    right.innerHTML="";

    console.log(json);

    if(Object.keys(json).length != 1)
    {
        let div_box = document.createElement("div");
        div_box.classList.add("bottom");
        //let title = document.createElement("p");
        let poster = document.createElement("img");
        let anno = document.createElement("p");
        let durata = document.createElement("p");
        let regista = document.createElement("p");
        let genere = document.createElement("p");
        let actors = document.createElement("p");
        let plot = document.createElement("p");
        let premi = document.createElement("p");
        let voto = document.createElement("p");

        //Inserisco il contenuto
        poster.src=json.Poster;

        //title.innerText = "Titolo:\n" + json.Title;
        anno.innerText = "Anno:\n" + json.Year;
        durata.innerText = "Durata:\n" + json.Runtime;
        regista.innerText = "Regista:\n" + json.Director;
        genere.innerText = "Genere:\n" + json.Genre;
        actors.innerText = "Attori:\n" + json.Actors;
        plot.innerText = "Trama:\n" + json.Plot;
        premi.innerText = "Premi:\n" + json.Awards;
        voto.innerText = "Voto Imdb:\n" + json.Ratings[0].Value;

        console.log(premi.textContent);

        //appendo gli elementi

        right.appendChild(div_box);
        //div_box.appendChild(title);
        div_box.appendChild(poster);
        div_box.appendChild(anno);
        div_box.appendChild(durata);
        div_box.appendChild(genere);
        div_box.appendChild(regista);
        div_box.appendChild(actors);
        div_box.appendChild(plot);
        div_box.appendChild(premi);
        div_box.appendChild(voto);

    }
    else
    {
        let tmp = document.querySelector(".flex_right .up form .left");
        tmp.value = json.success;
            
    }
    

}

function onResponse(response)
{
    console.log("Risposta Ricevuta");
    return response.json();
}
function cerca_film(event)
{


        if(form2.nome_film.value.length == 0)
        {
            form2.nome_film.placeholder="Deve pur aver un titolo!";
            
            event.preventDefault();    
        }
        else
        {
            event.preventDefault();
    
            let data = {
                nome_film: form2.nome_film.value,
            };
             
    
            fetch("../php/OMDBapi_cerca_film.php",
            {
                method: "POST",
                body: JSON.stringify(data),
                header: {
                    "Content-type": "application/json"
                        }
    
            }).then(onResponse).then(onJSON_cerca_film);
        }
}

//Aggiungo l'event listener per cercare un film e ottenere tutte le info
const form2 = document.forms['ricerca_film_form'];

form2.addEventListener('submit', cerca_film);


