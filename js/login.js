const divEmail= document.getElementById("email");
const divPassword = document.getElementById("password");
const divError = document.getElementById("error");
const formularioEl = document.getElementById("loginForm"); 

function validar(event){
    event.preventDefault();
     const exprReg = /^[a-zA-Z0-9_.+%!#$&'*=?^{}|$~-]+@[a-zA-Z0-9_.+%!#$&'*=?^{}|$~-]+\.[a-zA-Z]{2,}$/

     if(!divEmail.value.match(exprReg)){
        divError.innerHTML="El email es incorrecto";
        divError.style.display ="block";
     }
     else if(divPassword.value.length < 6){
        divError.innerHTML="La contraseña es incorrecta";
        divError.style.display ="block";
     }

     else{
        validate();
     }
}


formularioEl.addEventListener("submit",validar);


async function validate(){
    let email = divEmail.value;
    let password = divPassword.value;

    const url = "../src/validate_login.php";
    try{
        const formData = new FormData();
        formData.append('email',email);
        formData.append('password',password);
        const res = await fetch(url, {
            method:'POST',
            body: formData
        });
        if(!res.ok){
            throw new Error(`Response stats: ${res.status}`);
        }
        const json = await res.json();
        if(json.code != 0){
            divError.innerText = json.message;
            divError.style.display ="block";
            divError.classList.add('errorFade');

            setTimeout(() => {
               divError.style.display="none"; 
            }, 3000);
        }
        else{
            location.assign("../public/dashboard.php");
        }

    }catch(err){
        console.log(err);
    }
}