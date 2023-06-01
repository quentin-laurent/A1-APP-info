<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Mes données</title>
    <link rel="stylesheet" href="../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
    <script src="../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../static/css/data.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js "></script>
    <script src="../static/js/data.js" defer></script>
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<h1>Mes données</h1>
<hr>

<?php
if(isset($_SESSION['successMessage']))
{
    echo "<p id=success-message>{$_SESSION['successMessage']}</p>";
    unset($_SESSION['successMessage']);
}
if(isset($_SESSION['errorMessage'])) {
    echo "<p id=error-message>{$_SESSION['errorMessage']}</p>";
    unset($_SESSION['errorMessage']);
}
if(is_null($user) || is_null($product))
    exit;
?>
<h2>Appareil P<span class="green">o</span>rtAn #<?php echo "{$product->getId()}" ?></h2>
<div id="options">
    <div class="checkbox-input-group">
        <label for="update">Rafraîchissement automatique</label>
        <input id="update" type="checkbox" name="update">
    </div>
</div>
<div id="radio-buttons">
    <div class="radio-input-group">
        <label for="seconds">Secondes</label>
        <input id="seconds" type="radio" name="scale" value="seconds" checked>
    </div>
    <div class="radio-input-group">
        <label for="minutes">Minutes</label>
        <input id="minutes" type="radio" name="scale" value="minutes">
    </div>
    <div class="radio-input-group">
        <label for="hours">Heures</label>
        <input id="hours" type="radio" name="scale" value="hours">
    </div>
</div>

<div id="grid">
    <div class="sensor">
        <div class="sensor-header">
            <img class="sensor-image" src="../static/img/temperature.png">
            <h3 class="sensor-title">Température</h3>
        </div>
        <canvas id="temperature-chart"></canvas>
    </div>
    <div class="sensor">
        <div class="sensor-header">
            <img class="sensor-image" src="../static/img/humidity.png">
            <h3 class="sensor-title">Humidité</h3>
        </div>
        <canvas id="humidity-chart"></canvas>
    </div>
    <div class="sensor">
        <div class="sensor-header">
            <img class="sensor-image" src="../static/img/co2.png">
            <h3 class="sensor-title">CO2</h3>
        </div>
        <canvas id="co2-chart"></canvas>
    </div>
    <div class="sensor">
        <div class="sensor-header">
            <img class="sensor-image" src="../static/img/microparticles.png">
            <h3 class="sensor-title">Microparticules</h3>
        </div>
        <canvas id="microparticles-chart"></canvas>
    </div>
    <div class="sensor">
        <div class="sensor-header">
            <img class="sensor-image" src="../static/img/bpm.png">
            <h3 class="sensor-title">Rythme cardiaque</h3>
        </div>
        <canvas id="bpm-chart"></canvas>
    </div>
    <div class="sensor">
        <div class="sensor-header">
            <img class="sensor-image" src="../static/img/sound.png">
            <h3 class="sensor-title">Son ambient</h3>
        </div>
        <canvas id="sound-chart"></canvas>
    </div>
</div>
</body>
</html>
