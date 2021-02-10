
function read_config()
{
    url = `${window.location.protocol}//${window.location.host}/config/read`;
    console.log(url)
    fetch(url)
    .then(res => res.json())
    .then((res)=>{
        user_config = res;
        fetchAPI()
        setInterval(fetchAPI,5000);
        apichart()
    });
}

let getAPIURL = ()=> `${window.location.protocol}//${window.location.host}/proxy`;


function fetchAPI(){

    if (user_config !== null){
        url = getAPIURL()
        fetch(url)
        .then(res => res.json())
        .then((data)=>{
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
    apiInfo.innerHTML = "";
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
    if (capteur.Nom.indexOf("int") != -1) capteur.mode = "int";
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
    if (typeof capteurs == "undefined") return 0;
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

if ('serviceWorker' in navigator){
    navigator.serviceWorker.register("/service-worker.js", {
        scope: "/"
    }).then(function (registration)
    {
      console.log('Service worker registered successfully');
    }).catch(function (e)
    {
      console.error('Error during service worker registration:', e);
    });;
} else {
    console.log("No Service worker in navigator");
}

read_config();