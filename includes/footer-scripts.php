    <!-- again footer from includes folder -->
        <?php include 'footer.php'; ?>

    <!-- hidden includes until needed -->
    <?php include 'login-modal.php'; ?>
    <?php include 'cart.php'; ?>

    <!-- Customer Delete Modal -->
<div id="deleteModal" class="customer-modal-overlay">
    <div class="customer-modal-box">
        <div class="customer-modal-icon">
            <i class="fas fa-trash"></i>
        </div>
        <h3 class="customer-modal-title">Delete Address</h3>
        <p class="customer-modal-message">Are you sure you want to delete this address? This action cannot be undone.</p>
        <div class="customer-modal-actions">
            <button onclick="closeDeleteModal()" class="customer-modal-cancel">Cancel</button>
            <a id="deleteConfirmBtn" href="#" class="customer-modal-confirm">
                <i class="fas fa-trash"></i> Delete
            </a>
        </div>
    </div>
</div>
    <script src="/RDX/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
    <script src="/RDX/js/auth.js"></script>
    <script src="/RDX/js/cart.js"></script>
</body>
</html>