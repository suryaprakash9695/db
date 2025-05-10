<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/thrive_logo_small.png" type="image/x-icon">
    <meta name="description" content="">


    <title>WeCare</title>
    <link rel="stylesheet" href="styles/homepage.css">
    <link rel="stylesheet" href="styles/meditate.css">
    <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="assets/tether/tether.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/dropdown/css/style.css">
    <link rel="stylesheet" href="assets/socicon/css/styles.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Source+Serif+Pro:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="app">
      <div class="vid-container">
        <video loop>
          <source src="assets/video/rain.mp4" type="video/mp4" video="./assets/video/rain.mp4">
        </video>
      </div>
      <div class="time-select">
        <button data-time="120">2 Minutes</button>
        <button data-time="300" class="medium-mins">5 Minutes</button>
        <button data-time="600" class="long-mins">10 Minutes</button>
      </div>
      <div class="player-container">
        <audio class="song">
          <source src="./assets/sounds/rain.mp3" />
        </audio>
        <img src="assets/svg/play.svg" width="45" height="45" class="play" style="width: 25px;"></img>
        <svg class="track-outline" width="453" height="453" viewBox="0 0 453 453" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="226.5" cy="226.5" r="216.5" stroke="white" stroke-width="20"/>
        </svg>
        <svg class="moving-outline" width="453" height="453" viewBox="0 0 453 453" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="226.5" cy="226.5" r="216.5" stroke="#018EBA" stroke-width="20"/>
        </svg>
        <img src="assets/svg/replay.svg" width="45" height="45" class="replay" style="width: 25px;"></img>
        <h3 class="time-display">0:00</h3>      
      </div>
      <div class="sound-picker">
        <button data-sound="./assets/sounds/rain.mp3" data-video="./assets/video/rain.mp4"><img src="./assets/svg/rain.svg" alt=""></button>
        <button data-sound="./assets/sounds/beach.mp3" data-video="./assets/video/beach.mp4"><img src="./assets/svg/beach.svg" alt=""></button>
      </div>
    </div>
    
    <a href="https://mobirise.site/e"></a>
    
<?php include 'includes/footer.php'; ?>

</body>

</html>