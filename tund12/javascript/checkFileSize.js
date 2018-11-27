window.onload = function(){
    document.getElementById("submitImage").disabled = true;
    document.getElementById("fileToUpload").addEventListener("change", checkSize);
};

function checkSize() {
    // It creates a list regardless of the amount of files, so we're taking the first file
    let fileToUpload = document.getElementById("fileToUpload").files[0];

    if (fileToUpload.size <= 2500000){
        document.getElementById("submitImage").disabled = false;
        document.getElementById("infoPlace").innerHTML = "";
    }
    else {
        document.getElementById("submitImage").disabled = true; // Make sure it is disabled again if file changed
        document.getElementById("infoPlace").innerHTML = "Fail on liiga suur.";
    }
}