window.onload = function(){
    //document.getElementById("pic").innerHTML = "<p>Siia tuleb pilt</p> \n";
    setRandomPic();
    document.getElementById("pic").addEventListener("click", setRandomPic); // Get a new pic on click
};

function setRandomPic() {
    // AJAX
    let req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Do something with the server response
            document.getElementById("pic").innerHTML = this.responseText; // in this case insert the text
        }
    };
    // Make a request with URL and parameters
    req.open("GET", "randompic.php", true);
    req.send();
}
