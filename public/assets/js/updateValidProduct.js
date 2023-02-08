document.addEventListener("DOMContentLoaded", (event) => {
    document.querySelector('tbody').addEventListener('click', updateValidProduct);
})

function updateValidProduct(e){
    if (e.target.className == 'update-valid-product'){

        let productId =   e.target.getAttribute('data-id');
        let httpRequest = new XMLHttpRequest();
        let url = '/update_valid_product';
        httpRequest.open('POST', url);
        httpRequest.send(productId);
        httpRequest.onload = function (){
            let parse_response = JSON.parse(httpRequest.response)
            if (parse_response.status == "success"){
                addFlash('success', 'Modification enregistrée')
            }else{
                addFlash('error', parse_response.message)
            }
        }
    }
}
