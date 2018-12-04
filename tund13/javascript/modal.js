let modal;
let modalImg;
let captionText;
let closeBtn;
let photoDir = "../vp_pic_uploads/";
let modalId;

window.onload = function(){
    modal = document.getElementById("myModal");
    modalImg = document.getElementById("modalImg");
    captionText = document.getElementById("caption");
    closeBtn = document.getElementsByClassName("close")[0]; // Because several items may be a part of the class

    let allThumbs = document.getElementById("gallery")
                            .getElementsByTagName("img");

    let thumbCount = allThumbs.length;

    for(let i = 0; i < thumbCount; i++){
        allThumbs[i].addEventListener("click", openModal);
    }

    closeBtn.addEventListener("click", closeModal);
    modalImg.addEventListener("click", closeModal);
};

function openModal(evt) {
    modalImg.src = photoDir + evt.target.dataset.fn;
    modalId = evt.target.dataset.id;
    captionText.innerHTML = "<p>" + evt.target.alt + "</p>";
    modal.style.display = "block";
    document.getElementById("storerating").addEventListener("click", storeRating);
    getRating();
}

function storeRating(){
    rating = 0;
    for(let i = 1; i < 6; i++){
        if(document.getElementById("rating" + i).checked){
            rating = i;
        }
    }

    if(rating > 0){
        // AJAX
        let req = new XMLHttpRequest();
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Do something with the server response
                document.getElementById("avgRating").innerHTML = "Keskmine: " + this.responseText; // avg rating
            }
        };
        // Make a request with URL and parameters
        //storerating.php?id=6&rating=3
        req.open("GET", "storerating.php?id=" + modalId + "&rating=" + rating, true);
        req.send();
    }
}

function getRating(){ // Stupid way to get the rating - reuse the same function without parameters
    // AJAX
    let req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Do something with the server response
            document.getElementById("avgRating").innerHTML = "Keskmine: " + this.responseText; // avg rating
        }
    };
    req.open("GET", "storerating.php?id=" + modalId, true);
    req.send();
}

function closeModal() {
    modal.style.display = "none";
}

