    <div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>

    <div class="side-cart" id="sideCart">
        <div class="cart-header">
            <div>
                <h2>YOUR CART</h2>
                <p class="cart-count"><span id="itemCount">0</span> items</p>
            </div>
            <button class="close-cart" onclick="closeCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="cart-items-container" id="cartItemsContainer">
            <div class="empty-cart" id="emptyCart">
                <i class="fas fa-shopping-bag"></i>
                <h3>YOUR CART IS EMPTY</h3>
                <p>Start adding items</p>
            </div>
        </div>
        
        <div class="cart-footer" id="cartFooter" style="display: none;">
        <div class="cart-subtotal">
            <span class="subtotal-label">Subtotal</span>
            <span class="subtotal-value" id="subtotalValue">$0</span>
        </div>
        <div class="cart-total">
            <span class="total-label">Total</span>
            <span class="total-value" id="totalValue">$0</span>
        </div>
            <button class="checkout-btn" onclick="window.location.href='/RDX/checkout-page.php'">Checkout</button>
            <button class="view-cart-btn" onclick="closeCart()">Continue Shopping</button>
        </div>
    </div>

<script>
        const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
</script>