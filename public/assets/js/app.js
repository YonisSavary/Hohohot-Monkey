
function read_config()
{
    url = `${window.location.protocol}//${window.location.host}/config/read?token=${user_token}`;
    console.log(url)
    fetch(url)
    .then(res => res.json())
    .then((res)=>{
        console.log(res);
        user_config = res;
    });
}


function fetchAPI(){
    if (user_config !== null){
        fetch(user_config.api_url)
        .then(res => res.json())
        .then((data)=>{
            console.log(data);
            fillData(data);
        });
    }
}











/*
{"HotHotHot":"Api v1.0","capteurs":[
    {"type":"Thermique","Nom":"interieur","Valeur":"20.3","Timestamp":1612717650},
    {"type":"Thermique","Nom":"exterieur","Valeur":"7.3","Timestamp":1612717650}
]}

*/

function fillAPIInfo(meta)
{
    apiInfo.innerHTML = "Autres Informations Données par l'API | ";
    Object.keys(meta).forEach(key => {
        apiInfo.innerHTML += `${key} : ${meta[key]} | `;
    })
}


function getAlerte(t, mode)
{
    // EXT
    if (t > 35.0) return "Hot hot hot !";
    if (t < 0) return "Banquise en Vue";
    if (mode == "ext") return "Aucune Alerte";
    
    if (t > 22) return "Baissez le chauffage";
    if (t > 50) return "Appelez les pompiers ou arrêtez votre barbecue !";
    if (t < 12) return "Montez le chauffage ou mettez un gros pull !";
    if (t < 0) return "Canalisations gelées, appelez SOS plombier et mettez un bonnet";
    return "Aucune Alerte"
}

function getTempSection(capteur)
{
    capteur.mode = "ext";
    if (capteur.Nom.indexOf("int")) capteur.mode = "int";
    return `
    <section class="temp-section">
        <h1>${capteur[user_config.devices_value]}°</h1>
        <section class="temp-info">
            <h2>${capteur[user_config.devices_name]}</h2>
            <h3>${getAlerte(parseFloat(capteur.Valeur), capteur.mode)}</h3>
        </section>
    </section>`
}

function fillTemperature(capteurs)
{
    tempSlot.innerHTML = "";
    capteurs.forEach(c => {
        tempSlot.innerHTML += getTempSection(c);
    })
}

function fillData(data)
{
    let meta = {};
    let capteurs = {};
    Object.keys(data).forEach( key =>{
        if (key === user_config.devices_key) return ;
        meta[key] = data[key];
    });
    capteurs = data[user_config.devices_key];

    fillAPIInfo(meta);
    fillTemperature(capteurs);
}

let tempSlot = document.querySelector("#temp-slot");
let apiInfo = document.querySelector(".api-info");
let user_config = null;

let user_token = document.querySelector("#user_token");
if (typeof user_token === "undefined"){
    alert("Erreur interne, token manquant, reconnectez-vous")
} else {
    user_token = user_token.value
}

read_config();
setInterval(fetchAPI,5000);
fetchAPI();