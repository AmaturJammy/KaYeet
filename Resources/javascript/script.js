//Music player
function playmusic() {
    // PLAYER VARIABLES
    var mp3snd = "/KaYeet/Resources/media/audio/sound.mp3";
    document.write('<audio autoplay="autoplay" id="musicplayer">');
    document.write('<source src="'+mp3snd+'" type="audio/mpeg">');
    document.write('<!--[if lt IE 9]>');
    document.write('<bgsound src="'+mp3snd+'" loop="1">');
    document.write('<![endif]-->');
    document.write('</audio>');
    document.getElementById("musicplayer").loop = true;
}

function toggleForm() {
    var x = document.getElementById("formDiv");
    if(x.style.display === "none") {
        x.style.display = "block";
    }else{
        x.style.display = "none";
    }
}

//