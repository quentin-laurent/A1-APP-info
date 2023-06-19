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
            borderWidth: 1,
            borderColor: 'rgb(179, 179, 179)',
            backgroundColor: 'rgb(115, 115, 115)'
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
            borderWidth: 1,
            borderColor: 'rgb(15, 15, 87)',
            backgroundColor: 'rgb(28, 28, 74)'
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
            borderWidth: 1,
            borderColor: 'rgb(217, 110, 38)',
            backgroundColor: 'rgb(185, 116, 70)'
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
            borderWidth: 1,
            borderColor: 'rgb(173, 31, 173)',
            backgroundColor: 'rgb(148, 56, 148)'
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
chartsArray = [temperatureChart, humidityChart, co2Chart, microparticlesChart, bpmChart, soundChart];

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

function replaceData(chart, labels, data) {
    chart.data.labels = labels;
    chart.data.datasets[0].data = data;
    chart.update();
}

function clearData(chart) {
    chart.data.labels = [];
    chart.data.datasets[0].data = [];
    chart.update();
}

const radioInputs = document.getElementsByName('scale');

/**
 * Returns the chart scale selected by the user (e.g. seconds, minutes, hours etc.)
 * @returns {String} The string representation of the selected scale.
 */
function getScale() {
    for(let i = 0; i < radioInputs.length; i++) {
        if(radioInputs[i].checked)
            return radioInputs[i].value;
    }
    return '';
}

function loadCharts() {
    let metricTypes = ['temperature', 'humidity', 'co2', 'microparticles', 'bpm', 'sound'];
    metricTypes.forEach(metricType => {
        //console.log('Fetching ' + metricType + ' data...');
        $.ajax({
            url:"data/fetchMetrics",
            type: "post",
            dataType: 'json',
            data: {metricType: metricType, scale: getScale()},
            success:function(result){
                let data = result['data'];
                let labels = result['labels'];
                let chartName = metricType + 'Chart';
                //console.log('Current chart is: ' +chartName);
                for(let i = 0; i < data.length; i++) {
                    //console.log('Pushing label:' + labels[i] + ' data: ' + data[i]);
                    addData(charts[chartName], labels[i], data[i]);
                }
            },
            error:function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + '\n' + textStatus + '\n' + errorThrown);
            }
        });
    })
}

$(document).ready(() => {
    loadCharts();
});

for(let i = 0; i < radioInputs.length; i++) {
    radioInputs[i].addEventListener('click', event => {
        for(let i = 0; i < chartsArray.length; i++) {
            clearData(chartsArray[i]);
        }
        loadCharts();
    });
}

function fetchLatestMetrics() {
    let metricTypes = ['temperature', 'humidity', 'co2', 'microparticles', 'bpm', 'sound'];
    let date = new Date();
    let startDate = `${date.getFullYear()}-${('0' + (date.getMonth()+1)).slice(-2)}-${('0' + date.getDate()).slice(-2)} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
    metricTypes.forEach(metricType => {
        //console.log('Fetching latest ' + metricType + ' data...');
        $.ajax({
            url:"data/fetchMetrics",
            type: "post",
            dataType: 'json',
            data: {metricType: metricType, scale: getScale(), startDate: startDate},
            success:function(result){
                let data = result['data'];
                let labels = result['labels'];
                let chartName = metricType + 'Chart';
                replaceData(charts[chartName], labels, data);
            },
            error:function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + '\n' + textStatus + '\n' + errorThrown);
            }
        });
    })
}

const checkboxUpdate = document.getElementById('update');

function injectRandomData() {
    let date = new Date();
    let currentDate = `${date.getFullYear()}-${('0' + (date.getMonth()+1)).slice(-2)}-${('0' + date.getDate()).slice(-2)} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
    let randomMetricValue = (Math.random() * (70 - 30 + 1) + 30).toFixed(2);
    $.ajax({
        url:"data/inject",
        type: "post",
        dataType: 'json',
        data: {metricType: 'humidity', metricValue: randomMetricValue, metricDate: currentDate},
        error:function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR + '\n' + textStatus + '\n' + errorThrown);
        }
    });
}

function updateMetrics() {
    $.ajax({
        url:"data/update",
        type: "post",
        dataType: 'json',
        data: {},
        error:function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR + '\n' + textStatus + '\n' + errorThrown);
        }
    });
}

$(document).ready(function () {
    var intervalId = window.setInterval(function(){

        if(checkboxUpdate.checked) {
            //injectRandomData();
            updateMetrics();
            fetchLatestMetrics()
        }
    }, 1000);
})

// Turn the LED ON/OFF if the checkbox is checked/unchecked
checkboxUpdate.addEventListener('click', event => {
    if(checkboxUpdate.checked) {
        $.ajax({
            url:"data/updateLedStatus",
            type: "post",
            dataType: 'json',
            data: {ledStatus: 'on'},
            error:function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + '\n' + textStatus + '\n' + errorThrown);
            }
        });
    }
    else if (!checkboxUpdate.checked) {
        $.ajax({
            url:"data/updateLedStatus",
            type: "post",
            dataType: 'json',
            data: {ledStatus: 'off'},
            error:function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + '\n' + textStatus + '\n' + errorThrown);
            }
        });
    }
})
