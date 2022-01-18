function checkCartItem(clicked) {
    let cartId = clicked;

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
