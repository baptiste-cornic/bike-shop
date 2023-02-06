
document.addEventListener("DOMContentLoaded", function (){
    document.querySelector('.flash').addEventListener('click', removeFlash);
    document.querySelector('.icon-div').addEventListener('click', showMenu);
})

function addFlash(type, msg){
    let flash = document.querySelector('.flash');
    let icon;

    switch (type){
        case 'success':
            icon = 'fa-check';
            break;
        case 'error':
            icon = 'fa-triangle-exclamation';
            break;
    }

    let div = `<div class="alert alert-${type}">
                    <span><i class="fa-solid ${icon}"></i> ${msg}</span>
                    <button type="button" class="close-flash">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>`;

    flash.insertAdjacentHTML('afterbegin', div);
}

function removeFlash(e){
    if (e.target.className == "close-flash" || e.target.className == "fa-solid fa-xmark"){
        let parent = e.target.parentNode
        if (e.target.className == "fa-solid fa-xmark" ){
            parent = parent.parentNode
        }
        parent.style.display = "none";
    }
}

function showMenu(){
    let myTopnav = document.getElementById("myTopnav");
    if (myTopnav.className === "topnav") {
        myTopnav.className += " responsive";
    } else {
        myTopnav.className = "topnav";
    }
}