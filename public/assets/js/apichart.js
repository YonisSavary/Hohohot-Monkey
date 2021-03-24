
var config = {
    type: 'line',
    data: {
        labels: [],
        datasets: []
    },
    options: {
        responsive: true,
        title: {
            display: true,
            fontColor: "#FFF",
            text: 'Résumé des 100 dernières mesures'
        },
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                ticks: {
                    fontColor: "#FFF"
                },
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Timestamp',
                    fontColor: "#FFF"
                }
            }],
            yAxes: [{
                ticks: {
                    fontColor: "#FFF"
                },
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Température',
                    fontColor: "#FFF"
                }
            }]
        },
        legend: {

        }
    }
};

let randomNumber = () => Math.floor(Math.random()*255);
let randomColor = () => "rgb("+ randomNumber()*.6 +","+ randomNumber() +","+ randomNumber()*.2 +")";


function unix_to_human_timestamp(unix_timestamp){
    // Create a new JavaScript Date object based on the timestamp
    // multiplied by 1000 so that the argument is in milliseconds, not seconds.
    var date = new Date(unix_timestamp * 1000);
    // Hours part from the timestamp
    var hours = date.getHours();
    var minutes = "0" + date.getMinutes();
    var seconds = "0" + date.getSeconds();
    
    var day = "0" + date.getDay();
    var month = "0" + date.getMonth();
    var year = date.getFullYear();
    
    // Will display time in 10:30:23 format
    var formattedTime = day.substr(-2) + "/" + month.substr(-2) + "/" + year + " "
    formattedTime += hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
    
    return formattedTime;
}

function fillchart(data)
{
    let dates = [];
    let capteurs = {};

    data.forEach( elem => {
        elem.date = unix_to_human_timestamp(elem.date);
        if (!config.data.labels.includes(elem.date)) config.data.labels.push(elem.date);
        if (!Object.keys(capteurs).includes(elem.nom)) capteurs[elem.nom] = [];
        capteurs[elem.nom].push(elem.temperature);
    });

    Object.keys(capteurs).forEach(c => {
        let rc = randomColor()
        config.data.datasets.push({
            label: c,
            backgroundColor: rc,
            borderColor: rc,
            data: capteurs[c],
            fill: false,
        });
    })




    var ctx = document.getElementById('tempChart').getContext('2d');
    window.myLine = new Chart(ctx, config);
}


function apichart()
{
    url = `${window.location.protocol}//${window.location.host}/histo`;
    console.log(url)
    fetch(url)
    .then(res => res.json())
    .then((res)=>{
        console.log(res);
        fillchart(res)
    });
}


