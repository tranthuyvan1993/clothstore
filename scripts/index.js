var brandButton = document.getElementById('brandButton');
var brandMenuContainer = document.getElementById('brandMenuContainer');
var brandMenu = document.getElementById('brandMenu');
var brandMenuCloseButton = document.getElementById('brandMenuCloseButton');

function initMap() {
    graciousGarments = {lat: 21.01937000000007, lng: 105.80871845823378};
    map = new google.maps.Map(document.getElementById('gmaps'), {
        zoom: 15,
        center: graciousGarments,
    });
    marker = new google.maps.Marker({
        position: graciousGarments,
        map: map,
    });
}

function toggleBrandMenu() {
    if (brandMenuContainer.style.width == '100%') {
        closeBrandMenu();
    } else {
        openBrandMenu();
    }
}

function clickLocation(event) {
    var clickX = event.clientX;

    if (clickX > 480) {
        closeBrandMenu();
    }
}

brandMenuContainer.addEventListener('click', clickLocation);

function openBrandMenu() {
    brandButton.classList.add('navbar__link--is-active');
    brandMenuContainer.style.width = '100%';
    brandMenuContainer.style.left = '0';
}

function closeBrandMenu() {
    brandButton.classList.remove('navbar__link--is-active');
    brandMenuContainer.style.width = '0';
    brandMenuContainer.style.left = '-1600px'
}

function add2Cart(IDPRODUCTS, num){
    $.post('phps/api/api_cart.php',{
    'action': 'cart',
    'IDPRODUCTS': IDPRODUCTS,
    'num': num
    }, function(data){
    location.reload()
    })
}

function toggleCompareForm() {
    var compareForm = document.getElementById('compareForm');

    

    if (compareForm.style.opacity == '1') {
        compareForm.style.opacity = '0';
    } else {
        compareForm.style.opacity = '1';
        window.scrollTo(0, document.body.scrollHeight);
    }
}
function showSelectedProduct() {
    var combobox1 = document.getElementById('combobox1');
    var combobox2 = document.getElementById('combobox2');
    var value1 = combobox1.selectedOptions[0].value;
    var value2 = combobox2.selectedOptions[0].value;
    var compareArea = document.getElementById('compareArea');
    var xmlhttp = new XMLHttpRequest();

    if (value2 == '') {
        compareArea.innerHTML = 'Please choose the second product to compare';
    } else {
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                compareArea.innerHTML = this.responseText;
            }
        };
        xmlhttp.open('GET', 'compare.php?id1=' + value1 + '&id2=' + value2, true);
        xmlhttp.send();
    }
}