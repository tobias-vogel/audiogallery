<?php
error_reporting(E_ALL);

define('AUDIO_DIRECTORY', 'audio');
define('IMAGE_DIRECTORY', 'images');

define('AUDIOFILE', 'audiofile');
define('IMAGEFILE', 'imagefile');
define('BACKGROUND_COLOR', 'background-color');

function loadEntries() {
  /*return array(
    "a" => array(AUDIOFILE => "a.mp3", IMAGEFILE => "a.jpg", BACKGROUND_COLOR => md5("a")),
    "b" => array(AUDIOFILE => "b.mp3", IMAGEFILE => "b.jpg", BACKGROUND_COLOR => md5("b")),
    "c" => array(AUDIOFILE => "c.mp3", IMAGEFILE => "c.jpg", BACKGROUND_COLOR => md5("c"))
  );*/
  $audioFiles = readFilteredDirectoryContents(AUDIO_DIRECTORY);
  $cachedImageFiles = readFilteredDirectoryContents(IMAGE_DIRECTORY);
  $entries = array();
  foreach ($audioFiles as $audioFile) {
    $entry = array();
    $entry[AUDIOFILE] = $audioFile;
    $baseFilename = removeExtension($audioFile);
    $entry[BACKGROUND_COLOR] = substr(md5($baseFilename), 0, 6);
    $imageFile = loadImageFileForAudioFile($baseFilename, $cachedImageFiles);
    if ($imageFile != null) {
      $entry[IMAGEFILE] = $imageFile;
    }
    $entries[$baseFilename] = $entry;
  }
  return $entries;
}

function removeExtension($filename) {
  return preg_replace('/\.[^.]*$/', '', $filename);
}

function readFilteredDirectoryContents($directory) {
  $elementsToRemove = array('.', '..', '.gitignore');
  $files = scandir($directory);
  $files = array_diff($files, $elementsToRemove);
  return $files; 
}

function loadImageFileForAudioFile($baseFilename, $cachedImageFiles) {
  return null;
  /*
  pseudo code ahead
  map image filenames to their basenames, then match against input
  $targetImageFile = $baseFilename . '.jpg';
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

$entries = loadEntries();
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
  foreach ($entries as $id => $entry) {
    echo '<div class="audiofile" onclick="togglePlay(\'' . $id . '\');" style="background-color: ' . $entry[BACKGROUND_COLOR] . (array_key_exists(IMAGEFILE, $entry) ? '; background-image: img(' . $entry[IMAGEFILE] . ');' : '') . '">' . $id . "\n";
    echo '  <audio id="' . $id . '" src="' . AUDIO_DIRECTORY . '/' . $entry[AUDIOFILE] . '" type="audio/mp3"></audio>' . "\n";
    echo '</div>' . "\n";
  }
?>
  </body>
</html>

