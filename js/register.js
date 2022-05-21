function clean_error()
{
    if(document.querySelectorAll(".error").length > 0){
        let error=document.querySelector(".error");
        error.parentNode.removeChild(error);
    }
}


function check(event)
{
    
    //Elimino gli errpro precedenti        
    clean_error();

    //Verifo che i campi non siano vuoti
    if(form.nome.value.length == 0 || form.cognome.value.length == 0
        || form.username.value.length == 0 || form.email.value.length == 0 
        || form.pass.value.length == 0 || form.conf_pass.value.length == 0)
    {

        let p=document.createElement("p");
        p.textContent= "Alcuni campi risultano vuoti";
        p.classList.add("error")
        form.appendChild(p);
        
        //Avviso utente
        console.log("Alcuni campi risultano vuoti");
        event.preventDefault();    
    }
}

//aggiungiamo l'event listener al form
const form = document.forms['register_form'];
form.addEventListener('submit', check);

