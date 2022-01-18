class Item {
    constructor(id, state, cart, name, quantity, price, discountedPrice) {
        this.id = id;
        this.state = state;
        this.cart = cart;
        this.name = name;
        this.quantity = quantity;
        this.price = price;
        this.discountedPrice = discountedPrice;
    }
}

class Items {

    constructor(){
        this.items = []
    }
    // create a new player and save it in the collection
    newItem(id, state, cart,  name, quantity, price, discountedPrice){
        let item = new Item(id, state, cart, name, quantity, price, discountedPrice)
        this.items.push(item)
        return item
    }
    get allItems(){
        return this.items
    }
    get numberOfItems(){
        return this.items.length
    }
}

function storeData() {
    let supermart = new Items();
    console.log(supermart);
    //beverages
    supermart.newItem(1, 'unchecked', false, 'juice', '450ml', 350.00, 0);
    supermart.newItem(2, 'unchecked', false, 'ginger', '200ml', 380.00, 340.00);
    supermart.newItem(3, 'unchecked', false, 'cola', '1L', 150.00, 0);
    supermart.newItem(4, 'unchecked', false, 'wine', '350ml', 1000.00, 900.00);
    supermart.newItem(5, 'unchecked', false, 'water', '300ml', 110.00, 0);
    supermart.newItem(6, 'unchecked', false, 'coffee', '450ml', 420.00, 390.00);
    // Fruits and veggies
    supermart.newItem(7, 'unchecked', false, 'avocado', '250g', 300.00, 0);
    supermart.newItem(8, 'unchecked', false, 'bellpepper', '250g', 450.00, 390.00);
    supermart.newItem(9, 'unchecked', false, 'blueberry', '100g', 1450.00, 0);
    supermart.newItem(10, 'unchecked', false, 'lemon', '250g', 550.00, 490.00);
    supermart.newItem(11, 'unchecked', false, 'strawberry', '200g', 700.00, 0);
    supermart.newItem(12, 'unchecked', false, 'tomato', '250g', 200.00, 150.00);
    //beauty products
    supermart.newItem(13, 'unchecked', false, 'perfume', '30ml', 4000.00, 0);
    supermart.newItem(14, 'unchecked', false, 'soap', '200g', 150.00, 0);
    supermart.newItem(15, 'unchecked', false, 'moisturiser', '25ml', 540.00, 0);
    supermart.newItem(16, 'unchecked', false, 'shampoo', '30oz', 900.00, 850.00);
    supermart.newItem(17, 'unchecked', false, 'shavinggel', '60ml', 400.00, 0);
    supermart.newItem(18, 'unchecked', false, 'cream', '18g', 300.00, 280.00);
    //homewear items
    supermart.newItem(19, 'unchecked', false, 'knife', '5pc', 2000.00, 0);
    supermart.newItem(20, 'unchecked', false, 'cleaner', '250ml', 300.00, 250.00);
    supermart.newItem(21, 'unchecked', false, 'bulb', '26W', 200.00, 0);
    supermart.newItem(22, 'unchecked', false, 'pan', '', 2500.00, 2320.00);
    supermart.newItem(23, 'unchecked', false, 'toiletpaper', '100sheets', 200.00, 0);
    supermart.newItem(24, 'unchecked', false, 'bowl', '3 pc', 2000.00, 1500.00);
    //meat and poultry
    supermart.newItem(25, 'unchecked', false, 'beef', '500g', 1500.00, 0);
    supermart.newItem(26, 'unchecked', false, 'steak', '1Kg', 1500.00, 0);
    supermart.newItem(27, 'unchecked', false, 'chicken', '500g', 420.00, 0);
    supermart.newItem(28, 'unchecked', false, 'Sausages', '200g', 360.00, 330.00);
    supermart.newItem(29, 'unchecked', false, 'lamb', '600g', 3500.00, 0);
    supermart.newItem(30, 'unchecked', false, 'mutton', '1Kg', 3950.00, 3500.00);
    //snacks
    supermart.newItem(31, 'unchecked', false, 'cashew', '1kg', 2000.00, 0);
    supermart.newItem(32, 'unchecked', false, 'cornflakes', '', 600.00, 0);
    supermart.newItem(33, 'unchecked', false, 'olives', '160g', 600.00, 590.00);
    supermart.newItem(34, 'unchecked', false, 'chips', '200g', 200.00, 0);
    supermart.newItem(35, 'unchecked', false, 'pringles', '400g', 850.00, 0);
    supermart.newItem(36, 'unchecked', false, 'cassava', '100g', 140.00, 120.00);

    supermart.allItems.forEach(player => console.log(player));

    setCookie('supermart', JSON.stringify(supermart));
}
try {
    let favourite = JSON.parse(getCookie('supermart'));
} catch (err) {
    storeData();
}
window.onload = function checkCookie() {
    console.log('test');
    if (getCookie('supermart') == null) {
        storeData();
    } else  {

    }
}
window.onload = function checkFavourites() {
    console.log(document.cookie);
    try {
        let favourite = JSON.parse(getCookie('supermart'));
        let favouriteList = favourite.items;
        console.log(favouriteList);
        favouriteList.forEach(fav => {
            console.log('hello');
            console.log(fav);
            if (fav.state === 'checked') {
                document.getElementById(fav.name).checked = true;
            }
            if (fav.cart === true) {
                document.getElementById(fav.id).checked = true;
            }
        })
    }
    catch(err) {
        console.log(err);
        let favourite = JSON.parse(getCookie('supermart'));
        console.log(favourite);
        favourite.forEach(fav => {
            console.log('hello');
            console.log(fav);
            if (fav.state === 'checked') {
                document.getElementById(fav.name).checked = true;
            }
            if (fav.cart === true) {
                document.getElementById(fav.id).checked = true;
            }
        })
        changeCartItemState();
    }
}



function setCookie(cName, cValue, expDays) {
    let date = new Date();
    date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
}

let cartId;
function getCartId(clicked_id)
{
    cartId = clicked_id;
    console.log('cart id is' + cartId);
}

console.log(cartId);

let id;
function getIdName(clicked_id)
{
    id = clicked_id;
    console.log('id is' + id);
}

console.log()

function checkCartItem() {

    let data = JSON.parse(getCookie('supermart'));

    try {
        const array = data.map( item => {
            console.log('cart item check function ')
            
            if (item.id == cartId) {
                console.log(cartId);
                console.log(item.id);
                if (item.cart===true) {
                    console.log(item.cart);
                    return {...item, cart:false};
                } else if (item.cart===false) {
                    console.log(item.state);
                    return {...item, cart:true};
                }
                console.log('hello' + item);
            }
            return item;
        })

        console.log(array);

        setCookie('supermart', JSON.stringify(array), 30);
    }
    catch(err) {
        console.log(err);
        let storedAry = data.items;
        const array = storedAry.map( item => {
            console.log(item)
            if (item.id == cartId) {
                if (item.cart===true) {
                    console.log(item.state);
                    return {...item, cart:false};
                } else if (item.cart === false) {
                    console.log(item.cart);
                    return {...item, cart:true};
                }
                console.log('hello' + item);
            }
            return item;
        })

        console.log('array');
        console.log(array);

        setCookie('supermart', JSON.stringify(array), 30);
    }

}

function checkItem() {

    let data = JSON.parse(getCookie('supermart'));

    try {
        const array = data.map( item => {
            console.log(item)
            if (item.name === id) {
                if (item.state==='checked') {
                    console.log(item.state);
                    return {...item, state:'unchecked'};
                } else if (item.state ==='unchecked') {
                    console.log(item.state);
                    return {...item, state:'checked'}
                }
                console.log('hello' + item);
            }
            return item;
        })

        console.log('array');
        console.log(array);

        setCookie('supermart', JSON.stringify(array), 30);
    }
    catch(err) {
        console.log(err);
        let storedAry = data.items;
        const array = storedAry.map( item => {
            console.log(item)
            if (item.name === id) {
                if (item.state==='checked') {
                    console.log(item.state);
                    return {...item, state:'unchecked'};
                } else if (item.state ==='unchecked') {
                    console.log(item.state);
                    return {...item, state:'checked'}
                }
                console.log('hello' + item);
            }
            return item;
        })

        console.log('array');
        console.log(array);

        setCookie('supermart', JSON.stringify(array), 30);
    }

}


function getCookie(cName) {
    const name = cName + "=";
    const cDecoded = decodeURIComponent(document.cookie); //to be careful
    const cArr = cDecoded.split('; ');
    let res;
    cArr.forEach(val => {
        if (val.indexOf(name) === 0) res = val.substring(name.length);
    })
    return res
}
