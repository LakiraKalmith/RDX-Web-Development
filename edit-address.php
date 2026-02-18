<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/customer_only.php';



$user_id = (int)$_SESSION['user_id'];

$id = (int)$_GET['id'];

$sql = "SELECT * FROM addresses WHERE id = '$id' and user_id = '$user_id'";
$result = $conn->query($sql);
$address = mysqli_fetch_assoc($result);

include __DIR__ . '/includes/header.php';
?>


<body>

    <div class="edit-address-page">
        <div class="page-header">
            <h1>Edit Address</h1>
            <p>Update your address details</p>
        </div>

        <!-- Success Message (hidden by default) -->
        <!-- <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle"></i>
            <span>Address updated successfully!</span>
        </div> -->

        <!-- Edit Form -->
        <div class="edit-form-container">
            <form id="editForm" method="post" action="/RDX/includes/edit_address_process.php">
                
                <div class="form-section">
                    <h3 class="form-section-title">Address Type</h3>
                    
                    <div class="form-group">
                        <label>Type</label>
                        <select name="address_type" required >
                            <option value="home"  <?= ($address['address_type'] == 'home') ? 'selected' : '' ; ?>>Home</option>
                            <option value="office" <?= ($address['address_type'] == 'office') ? 'selected' : '' ; ?>>Office</option>
                            <option value="other" <?= ($address['address_type'] == 'other') ? 'selected' : '' ; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Contact Information</h3>
                    
                    <div class="modal-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" value="<?= $address['full_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" name="phone" value="<?= $address['phone']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Address Details</h3>
                    
                    <div class="form-group">
                        <label>Address Line 1</label>
                        <input type="text" name="address_line1" value="<?= $address['address_line1']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Address Line 2 <span class="optional">(optional)</span></label>
                        <input type="text" name="address_line2" value="<?= $address['address_line2']; ?>">
                    </div>

                    <div class="modal-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" value="<?= $address['city']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" value="<?= $address['state']; ?>" required>
                        </div>
                    </div>

                    <div class="modal-row">
                        <div class="form-group">
                            <label>Zip Code</label>
                            <input type="text" name="zip_code" value="<?= $address['zip_code']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select name="country" required>
                                <option value="United States" <?= ($address['country'] == 'United States') ? 'selected' : '' ; ?>>United States</option>
                                <option value="Canada" <?= ($address['country'] == 'Canada') ? 'selected' : '' ; ?>>Canada</option>
                                <option value="United Kingdom" <?= ($address['country'] == 'United Kingdom') ? 'selected' : '' ; ?>>United Kingdom</option>
                                <option value="Australia" <?= ($address['country'] == 'Australia') ? 'selected' : '' ; ?>>Australia</option>
                                <option value="Sri Lanka" <?= ($address['country'] == 'Sri Lanka') ? 'selected' : '' ; ?>>Sri Lanka</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="toggle-row">
                        <label class="toggle">
                            <input type="checkbox" name="is_default" value="<?= $address['is_default']; ?>" <?= ($address['is_default'] == '1') ? 'checked' : '' ; ?>>
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
                        <i class="fas fa-save"></i> Save Changes
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