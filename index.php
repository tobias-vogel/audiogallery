<?php
error_reporting(E_ALL);

define('AUDIO_DIRECTORY', 'audio');
define('IMAGE_DIRECTORY', 'audio');


function loadFiles() {
  $audioFiles = loadAudioFiles();
  $cachedImageFiles = loadImageFilesFromDisk();
  $result = array();
  foreach ($audioFiles as $audioFile) {
    $imageFile = loadImageFileForAudioFile($audioFile, $cachedImageFiles);
    $result[$audioFile] = $imageFile;
  }
  return $result;
}

function loadAudioFiles() {
  $mp3Files = readFilteredDirectoryContents(AUDIO_DIRECTORY);
  return $mp3Files;
}

function loadImageFilesFromDisk() {
  $imageFiles = readFilteredDirectoryContents(IMAGE_DIRECTORY);
  return $imageFiles;
}

function readFilteredDirectoryContents($directory) {
  $elementsToRemove = array('.', '..', '.gitignore');
  $files = scandir($directory);
  $files = array_diff($files, $elementsToRemove);
  return $files; 
}

function loadImageFileForAudioFile($audioFile, $cachedImageFiles) {
  return null;
  /*
  pseudo code ahead
  $audioFile.removeExtension();
  $targetImageFile = $audioFile . '.jpg';
  if ($targetImageFile in $cachedImageFiles) {
    return $targetImageFile;
  }
  else {
    return null;
    //$imageFile = retrieveImageFileFromWeb($audioFile);
    //saveImageFile($imageFile);
  }
  */
}

$files = loadFiles();
?>
<html>
  <head>
    <title>♫ ♩ ♪♬ 🎹 🎻 🎷 🎺 🎸 🎵 🎶 🎼 </title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" sizes="152x152" href="favicon152.png"> </-- taken from https://pixabay.com/de/vogel-zwitschern-gesang-melodie-1295782/ with added #7acaf4 background -->
    <link rel="icon" href="favicon32.png" type="image/x-icon">
    <style>
      body {
        background-color: lightgoldenrodyellow;
        padding-top: 20px;
      }

      div.audiofile {
        background-color: gray;
        display: inline-flex;
        height: 100px;
        width: 200px;
        margin-bottom: 10px;
        margin-right: 5px;
        padding: 10px;
        border-color: white;
        border-style: solid;
      }

      div.audiofile.playing {
        border-color: red;
        border-style: solid;
      }
    </style>
    <script>
      function togglePlay(audioId) {
        audio = document.getElementById(audioId);
        if (audio.paused) {
          pauseAndRewindAllAudiosExcept(audio);
          play(audio);
        }
        else {
          pause(audio);
        }
      }

      function pauseAndRewindAllAudiosExcept(clickedAudio) {
        audios = Array.from(document.getElementsByTagName('audio'));
        audios.forEach(function(audio) {
          if (audio != clickedAudio) {
            pause(audio);
            audio.currentTime = 0;
          }
        });
      }

      function play(audio) {
        audio.play();
        audio.parentElement.classList.add('playing');
      }

      function pause(audio) {
        audio.pause();
        audio.parentElement.classList.remove('playing');
      }
    </script> 
  </head>
  <body>
<?php
  foreach ($files as $audio => $image) {
    echo '<div class="audiofile" onclick="togglePlay(\'' . $audio . '\');">' . $audio . ' ' . $image . "\n";
    echo '  <audio id="' . $audio . '" src="' . AUDIO_DIRECTORY . '/' . $audio . '" type="audio/mp3"></audio>' . "\n";
    echo '</div>' . "\n";
  }
?>
  </body>
</html>

