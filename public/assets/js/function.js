
document.addEventListener("DOMContentLoaded", function (){
    document.querySelector('.flash').addEventListener('click', removeFlash)
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
                    <p><i class="fa-solid ${icon}"></i> ${msg}</p>
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