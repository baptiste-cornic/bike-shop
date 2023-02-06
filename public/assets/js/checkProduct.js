document.addEventListener("DOMContentLoaded", function (){
    document.querySelector('form').addEventListener('submit', checkProduct);
});

function checkProduct(e){
    e.preventDefault()

    let validForm = true;
    let name = document.querySelector('#product_name').value;
    let brand = document.querySelector("#product_brand").value;
    let price = document.querySelector("#product_price").value;
    let description = document.querySelector("#product_description").value;


    if ( !name || !brand || !price || !description )
        validForm = false

    if (validForm){
        document.querySelector('form').submit();
    }
    else{
        addFlash('error', 'Merci de remplir les champs correctement.');
        scroll(0,0);
    }
}