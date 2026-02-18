<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/customer_only.php';


include __DIR__ . '/includes/header.php';
?>


<body>
    <?php include 'includes/nav.php'; ?>
    <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    ✓ <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    ✗ <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

    <div class="edit-address-page">
        <div class="page-header">
            <h1>Add New Address</h1>
            <p>Enter your address details</p>
        </div>

        


        <!-- Edit Form -->
        <div class="edit-form-container">
            <form id="editForm" method="post" action="/RDX/includes/add_address_process.php">
                
                <div class="form-section">
                    <h3 class="form-section-title">Address Type</h3>
                    
                    <div class="form-group">
                        <label>Type</label>
                        <select name="address_type" required >
                            <option value="home" >Home</option>
                            <option value="office" >Office</option>
                            <option value="other" >Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Contact Information</h3>
                    
                    <div class="modal-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" value="" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" name="phone" value="" required placeholder="+1 (555) 123-4567">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Address Details</h3>
                    
                    <div class="form-group">
                        <label>Address Line 1</label>
                        <input type="text" name="address_line1" value="" placeholder="901 Financial District" required>
                    </div>

                    <div class="form-group">
                        <label>Address Line 2 <span class="optional">(optional)</span></label>
                        <input type="text" name="address_line2" value="" placeholder="Apartment 4B, Building C">
                    </div>

                    <div class="modal-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" value=""  placeholder="New York" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" value="" required placeholder="NY">
                        </div>
                    </div>

                    <div class="modal-row">
                        <div class="form-group">
                            <label>Zip Code</label>
                            <input type="text" name="zip_code" value="" required placeholder="10001">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select name="country" required>
                                <option value="United States" >United States</option>
                                <option value="Canada" >Canada</option>
                                <option value="United Kingdom" >United Kingdom</option>
                                <option value="Australia" >Australia</option>
                                <option value="Sri Lanka" >Sri Lanka</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="toggle-row">
                        <label class="toggle">
                            <input type="checkbox" name="is_default" value="" >
                            <span class="toggle-slider"></span>
                        </label>
                        <span>Set as default address</span>
                    </div>
                </div>

                <div class="modal-actions">
                    <a href="my-account.php?section=addresses" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <input type="hidden" name="edit_id" value="<?= $id ?>">
                    <button type="submit" class="btn-primary" name="editAdd">
                        <i class="fas fa-save"></i> Add Address
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script >
        document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 300); 
        }, 3000); 
    });
});
    </script>