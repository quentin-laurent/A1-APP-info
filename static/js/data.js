const temperatureChartCanvas = document.getElementById('temperature-chart');
const humidityChartCanvas = document.getElementById('humidity-chart');
const co2ChartCanvas = document.getElementById('co2-chart');
const microparticlesChartCanvas = document.getElementById('microparticles-chart');
const bpmChartCanvas = document.getElementById('bpm-chart');
const soundChartCanvas = document.getElementById('sound-chart');

temperatureChart = new Chart(temperatureChartCanvas, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Température (°C)',
            data: [],
            borderWidth: 1,
            borderColor: 'rgb(217, 38, 38)',
            backgroundColor: 'rgb(185, 70, 70)'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

humidityChart = new Chart(humidityChartCanvas, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Taux d\'humidité (%)',
            data: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

co2Chart = new Chart(co2ChartCanvas, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Taux de CO2 (ppm)',
            data: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

microparticlesChart = new Chart(microparticlesChartCanvas, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Taux de microparticules (ppm)',
            data: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

bpmChart = new Chart(bpmChartCanvas, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Battements par minute (BPM)',
            data: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

soundChart = new Chart(soundChartCanvas, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Niveau sonore (dB)',
            data: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

charts = {temperatureChart: temperatureChart, humidityChart: humidityChart, co2Chart: co2Chart, microparticlesChart: microparticlesChart, bpmChart: bpmChart, soundChart: soundChart};

function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}

function removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    chart.update();
}

$(document).ready(function() {
    let metricTypes = ['temperature', 'humidity', 'co2', 'microparticles', 'bpm', 'sound'];
    metricTypes.forEach(metricType => {
        console.log('Fetching ' + metricType + ' data...');
        $.ajax({
            url:"data/fetchMetrics",
            type: "post",
            dataType: 'json',
            data: {metricType: metricType},
            success:function(result){
                let data = result['data'];
                let labels = result['labels'];
                let chartName = metricType + 'Chart';
                console.log('Current chart is: ' +chartName);
                for(let i = 0; i < data.length; i++) {
                    console.log('Pushing label:' + labels[i] + ' data: ' + data[i]);
                    addData(charts[chartName], labels[i], data[i]);
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + ' ' + textStatus + ' ' + errorThrown);
            }
        });
    })
});

const addButton = document.getElementById('addButton');
addButton.addEventListener('click', event => {
    addData(temperatureChart, '16:06', Math.round(Math.random()*100));
})

const ajaxButton = document.getElementById('ajaxButton');
ajaxButton.addEventListener('click', event => {
    $.ajax({
        url:"data/fetchMetrics",
        type: "post",
        dataType: 'json',
        data: {metricType: "humidity"},
        success:function(result){
            //console.log(result);
            let data = result['data'];
            let labels = result['labels'];
            console.log(data);
            console.log(labels);
            for(let i = 0; i < data.length; i++) {
                console.log('label:' + labels[i] + ' data: ' + data[i]);
                addData(humidityChart, labels[i], data[i]);
            }
        }
    });
});
