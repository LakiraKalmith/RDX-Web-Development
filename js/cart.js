let cart = [];

function saveCart() {
    localStorage.setItem('rdx_cart',JSON.stringify(cart))
    console.log('Cart saved to LocalStorage:', cart)
}

function loadCart() {
    const savedCart = localStorage.getItem('rdx_cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        console.log('Cart loaded from LocalStorage:', cart);
        updateCart();
    }
}

function openCart() {
    document.getElementById('cartOverlay').classList.add('active');
    document.getElementById('sideCart').classList.add('active');
    document.body.classList.add('cart-open');
}

function closeCart() {
    document.getElementById('cartOverlay').classList.remove('active');
    document.getElementById('sideCart').classList.remove('active');
    document.body.classList.remove('cart-open');
}

function addToCart(name, price, image) {
    console.log('Adding to cart:', name, price, image); // DEBUG
    
    // Check if item already exists (same name AND price)
    const existingItem = cart.find(item => item.name === name && item.price === price);
    
    if (existingItem) {
        // Item exists, just increase quantity
        existingItem.quantity++;
        console.log('Item already in cart, increased quantity to:', existingItem.quantity);
    } else {
        // New item, add to cart
        cart.push({
            id: Date.now() + Math.random(),
            product_id: productId,  
            name: name,
            price: price,
            image: image,
            quantity: 1
        });
        console.log('New item added to cart');
    }
    
    console.log('Cart now has:', cart); // DEBUG
    
    saveCart();
    updateCart();
    openCart();
}

function updateQuantity(id, change) {
    const item = cart.find(item => item.id === id);
    if (item) {
        item.quantity = Math.max(1, item.quantity + change);
        saveCart();
        updateCart();
    }
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    saveCart();
    updateCart();
}

function updateCart() {
    const container = document.getElementById('cartItemsContainer');
    const cartFooter = document.getElementById('cartFooter');
    const cartBadge = document.getElementById('cartBadge');
    const itemCount = document.getElementById('itemCount');

    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartBadge.textContent = totalItems;
    itemCount.textContent = totalItems;

    if (cart.length === 0) {
        // Show empty state
        cartFooter.style.display = 'none';
        container.innerHTML = `
            <div class="empty-cart" id="emptyCart">
                <i class="fas fa-shopping-bag"></i>
                <h3>YOUR CART IS EMPTY</h3>
                <p>Start adding luxury items</p>
            </div>
        `;
    } else {
        // Show cart items
        cartFooter.style.display = 'block';
        
        container.innerHTML = cart.map(item => `
            <div class="cart-item">
                <div class="cart-item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="cart-item-details">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-meta">Size: L | Color: Black</div>
                    <div class="cart-item-price">$${item.price}</div>
                    <div class="cart-item-controls">
                        <div class="quantity-controls">
                            <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                            <span class="qty-display">${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                        </div>
                        <button class="remove-item" onclick="removeFromCart(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('subtotalValue').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('totalValue').textContent = `$${subtotal.toFixed(2)}`;
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeCart();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    console.log('Page Loaded, cart restored!');
});