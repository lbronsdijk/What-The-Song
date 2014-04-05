What The Song
=============

What The Song - Spotify App

##### FFMPEG

Echoprint Codegen vereist FFMPEG voor de conversie van audio. Indien je MAMP gebruikt en FFMPEG geïnstalleerd hebt via HomeBrew, kan het zijn dat PHP de extensie niet kan vinden. Dit probleem kan worden opgelost met de volgende fix:

* Bepaal de locatie van FFMPEG. De meest voor de hand liggende locatie is: `/usr/local/Cellar/ffmpeg/1.2.4/bin/ffmpeg` of `/usr/local/Cellar/ffmpeg/2.2/bin/ffmpeg`
* Maak vervolgens een symlink (alias) aan binnen de library van mamp. Open hiervoor je terminal.
    * Navigeer naar de MAMP directory: `cd /Applications/MAMP/Library/bin`
    * Maak de symlink aan: `ln -s /usr/local/Cellar/ffmpeg/1.2.4/bin/ffmpeg ffmpeg` of `ln -s /usr/local/Cellar/ffmpeg/2.2/bin/ffmpeg ffmpeg`.
* Restart MAMP
* Test of het PHP script geen errors terug geeft als "could not decode".