function elimina_post(event)
{
    
    let id_post = event.currentTarget.parentNode.parentNode.dataset.id;

    console.log("elimino il post id: "+ id_post);

    let data = {
        id: id_post,
    };

    fetch("../php/elimina_post.php", { 
        method: "POST",
        body: JSON.stringify(data),
        header: {
            "Content-type": "application/json"
                }    
    });

    
    event.currentTarget.parentNode.parentNode.remove();

}

//Creo le funzioni per gestire il file json
function onResponse(response)
{
    console.log('Risposta ricevuta');
    return response.json();
}

function onJSON_upload_post(json){

    console.log(json);

    let len;
    let is_array = Array.isArray(json);
    let post;

    console.log(is_array);
    if(!is_array)
    {
        len = 1;
    }
    else
    {
        
        len = json.length;
    }
    

    for(let i=0; i<len; i++)
    {

    console.log("ciao");
    if(!is_array)
    {
        post=json;
    }
    else
    {
        post=json[i];
    }

    //Questo sarà il div che li contine tutti
    let div = document.createElement("div");

    //Questi sono gli elementi non immagini del post
    let desc = document.createElement("p");
    let title = document.createElement("h1");
    let poster = document.createElement("img");
    let year = document.createElement("p");
    let runtime = document.createElement("p");

    let like = document.createElement("p");
    let img_like = document.createElement("img");

    //Separo la parte scritta con l'immagine
    let div_left = document.createElement("div");
    let div_right = document.createElement("div");


    //creo il tasto per eliminare i post 
    let elimina = document.createElement("button");
    elimina.textContent="Elimina post";
    elimina.addEventListener("click", elimina_post);

    //cerco la bacheca nel flex center della homepage.php

    let center = document.querySelector(".flex_center .bacheca");
    desc.textContent = post.descrizione;
    title.textContent = post.titolo;
    poster.src = post.url_poster;
    year.textContent = "Anno: " + post.anno;
    runtime.textContent = "Durata: " + post.durata;

    div.setAttribute("data-id", post.id);


    like.textContent = post.nlike;

    if(post.like=="unliked") 
    {
        img_like.src="https://cdn.pixabay.com/photo/2017/06/26/20/33/icon-2445095_960_720.png";
        //Aggiungo il giusto event_listener
        img_like.addEventListener("click", liked);
        
    }
    else
    {
        img_like.src="https://banner2.cleanpng.com/20180614/vtr/kisspng-movie-icons-cinema-film-clapperboard-computer-icon-cinema-theatre-5b22a53d311771.5401763115289971812011.jpg";
        //Aggiungo il giusto event_listener
        img_like.addEventListener("click", unliked);
        
    }
    
    center.appendChild(div);
    //Randomizziano la pubblicazione sinistra/destra dei post
    if(Math.floor( Math.random()*2)==0)
    {
        div.appendChild(div_left);
        div.appendChild(div_right);

    }
    else
    {
        div.appendChild(div_right);
        div.appendChild(div_left);

    }
    
    div_left.appendChild(title);
    div_left.appendChild(year);
    div_left.appendChild(runtime);
    div_left.appendChild(desc);

    div_left.appendChild(like);
    like.appendChild(img_like);

    div_left.appendChild(elimina);
    

    div_right.appendChild(poster);

    div.classList.add("post");
    div_left.classList.add("post_left");
    div_right.classList.add("post_right");



    }

}

//creo la funzione che richiama il file php per eseguire l'api
/*function crea_post(event){

    if(form.text_area.value.length == 0 || form.nome_film.value.length == 0)
    {
        if(form.text_area.value.length == 0)
            form.text_area.placeholder="Sei di poche parole!";
        
        if(form.nome_film.value.length == 0)
            form.nome_film.placeholder="Tutto bello, ma il nome del film?";
        event.preventDefault();    
    }
    else
    {
        event.preventDefault();

        let data = {
            nome_film: form.nome_film.value,
            descrizione: form.text_area.value,
        };
         

        fetch("OMDBapi.php",
        {
            method: "POST",
            body: JSON.stringify(data),
            header: {
                "Content-type": "application/json"
                    }

        }).then(onResponse).then(onJSON_upload_post);
    }



}
*/
function unliked(event)
{
    let p = event.currentTarget.parentNode;
    let nlike = parseInt(p.textContent) - 1;
    
    p.textContent = String(nlike);
    
    let img = document.createElement("img");
    p.appendChild(img);
    img.src="https://cdn.pixabay.com/photo/2017/06/26/20/33/icon-2445095_960_720.png"

    img.addEventListener('click', liked);

    //Prendo 
    console.log(p.parentNode.parentNode.dataset.id);
    let id_post = p.parentNode.parentNode.dataset.id;

    let data = {
        id: id_post,
    };

    fetch("../php/unliked.php", { 
        method: "POST",
        body: JSON.stringify(data),
        header: {
            "Content-type": "application/json"
                }    
    });
}

//Funzioni per il mi piace ai post
function liked(event)
{
    let p = event.currentTarget.parentNode;
    let nlike = parseInt(p.textContent) + 1;
    
    p.textContent = String(nlike);
    
    let img = document.createElement("img");
    p.appendChild(img);
    img.src="https://banner2.cleanpng.com/20180614/vtr/kisspng-movie-icons-cinema-film-clapperboard-computer-icon-cinema-theatre-5b22a53d311771.5401763115289971812011.jpg"

    img.addEventListener('click', unliked);

    
    //Prendo 
    console.log(p.parentNode.parentNode.dataset.id);

    let id_post = p.parentNode.parentNode.dataset.id;

    let data = {
        id: id_post,
    };

    fetch("../php/liked.php", { 
        method: "POST",
        body: JSON.stringify(data),
        header: {
            "Content-type": "application/json"
                }    
    });
}


//Aggiungo l'event listener al submit per la creazione dei post

//const form = document.forms['creazione_form'];
//form.addEventListener('submit', crea_post);

//aggiun l'event listener per la funzione like
//const like = document.querySelectorAll(".bacheca .post .post_left p img");

/*for(let i=0; i<like.length; i++)
{
    like[i].addEventListener('click', liked);
}
*/

//Upload_post in bacheca
fetch("../php/upload_post_profilo.php").then(onResponse).then(onJSON_upload_post);