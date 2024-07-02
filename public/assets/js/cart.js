// let listProductHTML = document.querySelector('.listProduct');
// let listCartHTML = document.querySelector('.listCart');
// let iconCart = document.querySelector('.icon-cart');
// let iconCartSpan = document.querySelector('.icon-cart span');
// let body = document.querySelector('body');
// let closeCart = document.querySelector('.close');
// let totalPriceElement = document.querySelector('.totalPrice');
// let cart = [];

// iconCart.addEventListener('click', () => {
//     body.classList.toggle('showCart');
// });
// closeCart.addEventListener('click', () => {
//     body.classList.toggle('showCart');
// });

// const addToCart = (product_id, product_name, product_size, product_price, product_stok) => {
//     let positionThisProductInCart = cart.findIndex((value) => value.product_id == product_id);
//     if (positionThisProductInCart < 0) {
//         cart.push({
//             product_id: product_id,
//             product_name: product_name,
//             product_size: product_size,
//             product_price: product_price,
//             quantity: 1,
//             max_quantity: product_stok
//         });
//     } else {
//         if (cart[positionThisProductInCart].quantity < cart[positionThisProductInCart].max_quantity) {
//             cart[positionThisProductInCart].quantity += 1;
//         } else {
//             alert('Stok Habis');
//         }
//     }
//     addCartToHTML();
//     addCartToMemory();
// };

// const addCartToMemory = () => {
//     localStorage.setItem('cart', JSON.stringify(cart));
// };

// const addCartToHTML = () => {
//     listCartHTML.innerHTML = '';
//     let totalQuantity = 0;
//     let totalPrice = 0;
//     if (cart.length > 0) {
//         cart.forEach(item => {
//             totalQuantity += item.quantity;
//             let newItem = document.createElement('div');
//             newItem.classList.add('item');
//             newItem.dataset.id = item.product_id;

//             // Ambil data produk dari array products
//             let product = products.find(p => p.id == item.product_id);
//             let productName = product.nama_baju;
//             let productSize = item.product_size;
//             let productPrice = product.harga_sewa_perhari;
//             let productStok = product.stok;
//             let productImageSrc = product.gambar_baju ? `{{ asset('storage/${product.gambar_baju}') }}` : `{{ asset('assets/img/baju-kosong.png') }}`;

//             totalPrice += productPrice * item.quantity;

//             newItem.innerHTML = `
//                 <div class="image">
//                     <img src="${productImageSrc}">
//                 </div>
//                 <div class="details">
//                     <div class="name">${productName} (${productSize})</div>
//                     <div class="totalPrice">Rp${(productPrice * item.quantity).toLocaleString('id-ID')}</div>
//                     <div class="quantity">
//                         <span class="minus"><i class="tf-icons bx bx-minus"></i></span>
//                         <span>${item.quantity}</span>
//                         <span class="plus ${item.quantity >= productStok ? 'disabled' : ''}"><i class="tf-icons bx bx-plus"></i></span>
//                         ${item.quantity >= productStok ? '<span class="text-danger">Stok Habis</span>' : ''}
//                     </div>
//                 </div>
//             `;
//             listCartHTML.appendChild(newItem);
//         });
//     }
//     iconCartSpan.innerText = totalQuantity;
//     totalPriceElement.innerText = `Rp${totalPrice.toLocaleString('id-ID')}`;
// };

// listCartHTML.addEventListener('click', (event) => {
//     let positionClick = event.target;
//     if (positionClick.classList.contains('bx-minus') || positionClick.classList.contains('bx-plus')) {
//         let product_id = positionClick.closest('.item').dataset.id;
//         let type = positionClick.classList.contains('bx-plus') ? 'plus' : 'minus';
//         changeQuantityCart(product_id, type);
//     }
// });

// const changeQuantityCart = (product_id, type) => {
//     let positionItemInCart = cart.findIndex((value) => value.product_id == product_id);
//     if (positionItemInCart >= 0) {
//         let info = cart[positionItemInCart];
//         switch (type) {
//             case 'plus':
//                 if (info.quantity < info.max_quantity) {
//                     cart[positionItemInCart].quantity += 1;
//                 } else {
//                     alert('Stok Habis');
//                 }
//                 break;
//             case 'minus':
//                 let changeQuantity = cart[positionItemInCart].quantity - 1;
//                 if (changeQuantity > 0) {
//                     cart[positionItemInCart].quantity = changeQuantity;
//                 } else {
//                     cart.splice(positionItemInCart, 1);
//                 }
//                 break;
//         }
//     }
//     addCartToHTML();
//     addCartToMemory();
// };

// const initApp = () => {
//     if (localStorage.getItem('cart')) {
//         cart = JSON.parse(localStorage.getItem('cart'));
//         addCartToHTML();
//     }
// };

// initApp();




let listProductHTML = document.querySelector('.listProduct');
let listCartHTML = document.querySelector('.listCart');
let iconCart = document.querySelector('.icon-cart');
let iconCartSpan = document.querySelector('.icon-cart span');
let body = document.querySelector('body');
let closeCart = document.querySelector('.close');
let totalPriceElement = document.querySelector('.totalPrice');
let cart = [];

iconCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
});
closeCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
});

const addToCart = (product_id, product_name, product_size, product_price) => {
    let positionThisProductInCart = cart.findIndex((value) => value.product_id == product_id);
    if (positionThisProductInCart < 0) {
        fetch(`/check-stock/${product_id}`)
            .then(response => response.json())
            .then(data => {
                if (data.stok > 0) {
                    cart.push({
                        product_id: product_id,
                        product_name: product_name,
                        product_size: product_size,
                        product_price: product_price,
                        quantity: 1,
                        stok: data.stok
                    });
                    addCartToHTML();
                    addCartToMemory();
                } else {
                    alert('Stok Habis');
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        if (cart[positionThisProductInCart].quantity < cart[positionThisProductInCart].stok) {
            cart[positionThisProductInCart].quantity += 1;
            addCartToHTML();
            addCartToMemory();
        } else {
            alert('Stok Habis');
        }
    }
};

const addCartToMemory = () => {
    localStorage.setItem('cart', JSON.stringify(cart));
};

const addCartToHTML = () => {
    listCartHTML.innerHTML = '';
    let totalQuantity = 0;
    let totalPrice = 0;
    if (cart.length > 0) {
        cart.forEach(item => {
            totalQuantity += item.quantity;
            let newItem = document.createElement('div');
            newItem.classList.add('item');
            newItem.dataset.id = item.product_id;

            // Ambil data produk dari array products
            let product = products.find(p => p.id == item.product_id);
            let productName = product.nama_baju;
            let productSize = item.product_size;
            let productPrice = product.harga_sewa_perhari;
            // let productImageSrc = product.gambar_baju ? `{{ asset('storage/${product.gambar_baju}') }}` : `{{ asset('assets/img/baju-kosong.png') }}`;
            let productImageSrc = product.gambar_baju ? `${window.location.origin}/storage/${product.gambar_baju}` : `${window.location.origin}/assets/img/baju-kosong.png`;


            totalPrice += productPrice * item.quantity;

            newItem.innerHTML = `
                <div class="image">
                    <img src="${productImageSrc}">
                </div>
                <div class="details">
                    <div class="name">${productName} (${productSize})</div>
                    <div class="totalPrice">Rp${(productPrice * item.quantity).toLocaleString('id-ID')}</div>
                    <div class="quantity">
                        <span class="minus"><i class="tf-icons bx bx-minus"></i></span>
                        <span>${item.quantity}</span>
                        <span class="plus ${item.quantity >= item.stok ? 'disabled' : ''}"><i class="tf-icons bx bx-plus"></i></span>
                        ${item.quantity >= item.stok ? '<span class="text-danger">Stok Habis</span>' : ''}
                    </div>
                </div>
            `;
            listCartHTML.appendChild(newItem);
        });
    }
    iconCartSpan.innerText = totalQuantity;
    totalPriceElement.innerText = `Rp${totalPrice.toLocaleString('id-ID')}`;
};

listCartHTML.addEventListener('click', (event) => {
    let positionClick = event.target;
    if (positionClick.classList.contains('bx-minus') || positionClick.classList.contains('bx-plus')) {
        let product_id = positionClick.closest('.item').dataset.id;
        let type = positionClick.classList.contains('bx-plus') ? 'plus' : 'minus';
        changeQuantityCart(product_id, type);
    }
});

const changeQuantityCart = (product_id, type) => {
    let positionItemInCart = cart.findIndex((value) => value.product_id == product_id);
    if (positionItemInCart >= 0) {
        let info = cart[positionItemInCart];
        switch (type) {
            case 'plus':
                if (info.quantity < info.stok) {
                    cart[positionItemInCart].quantity += 1;
                } else {
                    alert('Stok Habis');
                }
                break;
            case 'minus':
                let changeQuantity = cart[positionItemInCart].quantity - 1;
                if (changeQuantity > 0) {
                    cart[positionItemInCart].quantity = changeQuantity;
                } else {
                    cart.splice(positionItemInCart, 1);
                }
                break;
        }
    }
    addCartToHTML();
    addCartToMemory();
};

const initApp = () => {
    if (localStorage.getItem('cart')) {
        cart = JSON.parse(localStorage.getItem('cart'));
        addCartToHTML();
    }
};

initApp();
