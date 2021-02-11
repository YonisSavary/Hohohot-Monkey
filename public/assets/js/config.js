function save_config()
{
    let config = {
    api_url : document.querySelector("#api_url_input").value,
    devices_key : document.querySelector("#devices_key_input").value,
    devices_name : document.querySelector("#devices_name_input").value,
    devices_value : document.querySelector("#devices_value_input").value
    }

    url = `${window.location.protocol}//${window.location.host}/config/update?token=${user_token}&config=${JSON.stringify(config)}`;
    console.log(url)
    fetch (url)
    .then(res => res.json())
    .then((res)=>{
        console.log(res);
        if (res.status === "ok") alert("configuration enregistrée !");
    });
}

function read_config()
{
    url = `${window.location.protocol}//${window.location.host}/config/read?token=${user_token}`;
    console.log(url)
    fetch(url)
    .then(res => res.json())
    .then((user_config)=>{
        document.querySelector("#api_url_input").value = user_config.api_url;
        document.querySelector("#devices_key_input").value = user_config.devices_key;
        document.querySelector("#devices_name_input").value = user_config.devices_name;
        document.querySelector("#devices_value_input").value = user_config.devices_value;
    });
}

let user_token = document.querySelector("#user_token");
if (typeof user_token === "undefined"){
    alert("Erreur interne, token manquant, reconnectez-vous")
} else {
    user_token = user_token.value
}

let save_button = document.querySelector("#save_button");
save_button.addEventListener("click", save_config);

read_config();



p_input_message = document.querySelector("#p_input_message");
p_input_1 = document.querySelector("#p_input_1");
p_input_2 = document.querySelector("#p_input_2");
p_input_confirm = document.querySelector("#p_input_confirm");

function password_check(){
    return (p_input_1.value.match(/^[0-9A-Za-z]{8,}$/) && (
        p_input_1.value === p_input_2.value
    ))
}

p_input_2.addEventListener("keyup", ()=>{
    if (password_check() !== true){
        p_input_message.innerText = "Les mots de passe ne se correspondent pas"
    } else {
        p_input_message.innerText = "";
    }
})

p_input_confirm.addEventListener("click", ()=>{
    if (password_check() === true){
        fetch(`${window.location.protocol}//${window.location.host}/login/change_pass?token=${user_token}&password=${p_input_1.value}`)
        .then(res => res.json())
        .then(()=>{
            window.location.href = "/login";
        })
        
    }
})

let delete_confirm = document.querySelector("#delete_confirm");
delete_confirm.addEventListener("click", ()=>{
    if (confirm("êtes-vous sûr de vouloir supprimer votre compte ?")){
        window.location.href = `${window.location.protocol}//${window.location.host}/unregister?token=${user_token}&password=${p_input_1.value}`
    }
})

