let cart = [];

function saveCart() {
    localStorage.setItem('rdx_cart',JSON.stringify(cart))
    console.log('Cart saved to LocalStorage:', cart)
}

function loadCart() {
    const savedCart = localStorage.getItem('rdx_cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCart();
    }
}

function syncDB(action, product_id, quantity) {
    fetch('/RDX/includes/cart_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action, product_id, quantity })
    });
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

function addToCart(name, price, image, product_id) {
    
    // Check if item already exists (same name AND price)
    const existing = cart.find(item => item.product_id == product_id);
    
    if (existing) {
        existing.quantity++;
        syncDB('update', product_id, existing.quantity);
    } else {
        cart.push({ 
            product_id, 
            name, 
            price, 
            image, 
            quantity: 1 
        });
        syncDB('add', product_id, 1);
    }

    saveCart();
    updateCart();
    openCart();
}

function updateQuantity(product_id, change) {
    const item = cart.find(item => item.product_id == product_id);
    if (item) {
        item.quantity = Math.max(1, item.quantity + change);
        syncDB('update', item.product_id, item.quantity);
        saveCart();
        updateCart();
    }
}

function removeFromCart(product_id) {
    const item = cart.find(item => item.product_id == product_id);
    if (item) syncDB('remove', item.product_id, 0);
    cart = cart.filter(item => item.product_id != product_id);
    saveCart();
    updateCart();
}

function goToCheckout() {
    if (cart.length === 0) return;
    // isLoggedIn is set by PHP in cart.php
    if (!isLoggedIn) {
        window.location.href = '/RDX/login.php?redirect=checkout-page.php';
        return;
    }
    window.location.href = '/RDX/checkout-page.php';
}

function updateCart() {
    const container = document.getElementById('cartItemsContainer');
    const cartFooter = document.getElementById('cartFooter');
    const cartBadge = document.getElementById('cartBadge');
    const itemCount = document.getElementById('itemCount');

    const totalItems = cart.reduce((sum, item) => sum + Number(item.quantity), 0);
    cartBadge.textContent = Number(totalItems);
    itemCount.textContent = Number(totalItems);

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
                            <button class="qty-btn" onclick="updateQuantity(${item.product_id}, -1)">-</button>
                            <span class="qty-display">${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQuantity(${item.product_id}, 1)">+</button>
                        </div>
                        <button class="remove-item" onclick="removeFromCart(${item.product_id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    const subtotal = cart.reduce((sum, item) => sum + (Number(item.price) * Number(item.quantity)), 0);
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