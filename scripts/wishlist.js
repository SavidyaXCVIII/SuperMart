function checkItem(clicked) {
    let id = clicked;
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
