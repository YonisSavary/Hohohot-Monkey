
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
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Month'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value'
                }
            }]
        }
    }
};

let randomNumber = () => Math.floor(Math.random()*255);
let randomColor = () => "rgb(" + randomNumber()+","+ randomNumber()+","+ randomNumber()+")";


function fillchart(data)
{
    let dates = [];
    let capteurs = {};

    data.forEach( elem => {
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


