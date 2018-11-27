let modal;
let modalImg;
let captionText;
let closeBtn;
let photoDir = "../vp_pic_uploads/";

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
    captionText.innerHTML = "<p>" + evt.target.alt + "</p>";
    modal.style.display = "block";
}

function closeModal() {
    modal.style.display = "none";
}

