<script src="/RDX/js/admin.js"></script>

    <div id="deleteModal" class="delete-modal-overlay">
    <div class="delete-modal-box">
        <div class="delete-modal-icon">
            <i class="fas fa-trash"></i>
        </div>
        <h3 class="delete-modal-title">Are you sure?</h3>
        <p id="deleteMessage" class="delete-modal-message">This action cannot be undone.</p>
        <div class="delete-modal-actions">
            <button onclick="closeDeleteModal()" class="btn btn-secondary">Cancel</button>
            <a id="deleteConfirmBtn" href="#" class="btn-delete-confirm">
                <i class="fas fa-trash"></i> Delete
            </a>
        </div>
    </div>
</div>


<script>
    function confirmDelete(url, message) {
        document.getElementById('deleteMessage').textContent = message || 'This action cannot be undone.';
        document.getElementById('deleteConfirmBtn').href = url;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>

</body>
</html>