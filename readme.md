Audio Gallery

# History and purpose
The initial problem was that when I played some songs from http://www.liederprojekt.org/lieder_galerie.html, my daughter constantly stopped the music unintentionally clicking on links on our iPad. Together with our storage of MP3 files, this inspired me to write this webapp.

So this webapp is meant to provide a single-page music box with a simple, colored user interface and less ado. There are just songs to play and not (much) more.

# Installation
Just put this index.php to some webspace and fill the audio directory with mp3s. Other files might work, too.

# Open issues
* Audio files should be cached in the browser.
* Audio files could be preloaded.
* There should be thumbnails instead of gray boxes found via the filename with an image search (https://pixabay.com/ is free without reference). Be careful to not get blacklisted. Maybe load images just upon request (clicking on them).
* Use colored boxes until images are there. The color could be derived from the filename.
* There is an autoplay option, for example, with a checkbox. Autoplaying plays a random song after one is finished (and some seconds silence in between). The currently playing song is highlighted and scrolled to. The autoplay version of the page (maybe with ?autoplay in the URI) is easily bookbarkable by a link that appears next to the checkbox that contains the current setting.
* Use smarty or similar for the HTML template. Install it with some PHP installer thingy.
* During mp3 load/buffering there should be an activity dial on the box.
* Support different image file formats.
* Make sure it looks reasonably good on an iPad.
* Use Apple touch favicons and use a full-screen-app and hide the status bar.

