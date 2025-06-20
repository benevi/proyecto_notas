const divNombre= document.getElementById("nombre");
const divEmail= document.getElementById("email");
const divPassword = document.getElementById("password");
const divConfirmPass = document.getElementById("confirm_password");
const divError = document.getElementById("error");
const divSuccess = document.getElementById("success");
const formularioEl = document.getElementById("registerForm"); 


document.addEventListener('DOMContentLoaded',function(){
    googleMessages();
});

function validar(event){
    event.preventDefault();
     const exprReg = /^[a-zA-Z0-9_.+%!#$&'*=?^{}|$~-]+@[a-zA-Z0-9_.+%!#$&'*=?^{}|$~-]+\.[a-zA-Z]{2,}$/

     if(divNombre.value.length<3){
        divError.innerText="Nombre usuario debe contener 3 letras mínimo";
        divError.style.display ="block";
     }
     else if(!divEmail.value.match(exprReg)){
        divError.innerText="El email es incorrecto";
        divError.style.display ="block";
     }
     else if(divPassword.value.length < 6){
        divError.innerText="La contraseña es incorrecta";
        divError.style.display ="block";
     }
     else if(divPassword.value !== divConfirmPass.value){
        divError.innerText="Las contraseñas no coinciden";
        divError.style.display ="block";
     }
     else{
       validate();
     }
}

formularioEl.addEventListener("submit",validar);

async function validate(){
    let nombre = divNombre.value;
    let email = divEmail.value;
    let password = divPassword.value;

    const url = "../src/validate_register.php";
    try{
        const formData = new FormData();
        formData.append('nombre',nombre);
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
            divSuccess.innerText = json.message;
            divSuccess.style.display ="block";
            setTimeout(function(){
                location.assign="../public/login.php";
            },3000);
        }

    }catch(err){
        console.log(err);
    }
}