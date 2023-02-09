document.addEventListener("DOMContentLoaded", function (){
    document.querySelector('form').addEventListener('input', updateBikesList);
    document.querySelector('#search_minPrice').addEventListener('input', updateBikesList);
    document.querySelector('#search_maxPrice').addEventListener('input', updateBikesList);
    document.querySelector('#search_brand').addEventListener('input', updateBikesList);
    document.querySelector('.reset-btn').addEventListener('click', resetSearch);
    document.querySelector('#icon-sort').addEventListener('click', showHideSearch)
    window.addEventListener("resize", displaySearchResponsive);
});


function updateBikesList(){
    let word = document.querySelector('#search_search').value;
    let minPrice = document.querySelector('#search_minPrice').value;
    let maxPrice = document.querySelector('#search_maxPrice').value;
    let brand = document.querySelector('#search_brand').value;
    let div = document.querySelector('.bike-list');

    fetch('/search_bikes', {
        method: 'POST',
        body:  JSON.stringify({word, minPrice, maxPrice, brand}) ,
        headers: {
            'Content-Type': 'application/json'
        }})
        .then(function(response) {
            return response.json();
        }).then(function(jsonData) {

            div.innerHTML = '';
            let items = '';

            jsonData.forEach(function(element){
                items += `
                    <div class="cart">
                        <a href="/product/${element['id']}">
                            <div class="cart-img">
                                <img class="bike-list-img" src="/assets/img/${element['picture']}" alt="${element['name']}">
                            </div>
                            <div class="cart-info">
                                <h4>${element['name']}</h4>
                                <p>${element['brand']} / ${element['productType']}</p>
                                <p>${element['price']} €</p>
                            </div>
                        </a>
                    </div>
            `;
            })

        document.querySelector('.flash').innerHTML = '';
        if (!jsonData.length){
            items = `  <h3 class="text-center">Aucun vélo ne correspond à vos critères de recherche</h3>`;
            div.style.display = 'block';
        }else {
            div.style.display = 'flex';
        }
        div.innerHTML = items;

    })
}

function resetSearch(){
    document.querySelector('#search_search').value = "";
    document.querySelector('#search_minPrice').value = "";
    document.querySelector('#search_maxPrice').value = "";
    document.querySelector('#search_brand').value = "";

    updateBikesList();
}

function showHideSearch(){
    let form = document.querySelector('form');
    let btn = document.querySelector('.reset-btn')

    if (form.style.display === "none" || form.style.display === "" ) {
        form.style.display = "flex";
        btn.style.display = "inline-block"
    } else {
        form.style.display = "none";
        btn.style.display = "none";
    }
}

function displaySearchResponsive(){
    if (window.innerWidth > 960){
        document.querySelector('form').style.display = "flex";
        document.querySelector('.reset-btn').style.display = "inline-block";
    }else{
        document.querySelector('form').style.display = "none";
        document.querySelector('.reset-btn').style.display = "none";
    }
}