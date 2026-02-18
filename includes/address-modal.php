

<div class="modal-overlay" id="addModal">
    <div class="modal-box">

        <button onclick="closeModal('addModal')" class="modal-close">
            <i class="fas fa-times"></i>
        </button>

        <div class="modal-header">
            <h2>Add New Address</h2>
            <p>Fill in the details below</p>
        </div>

        <form method="POST" action="">
            
            <!-- Address Type -->
            <div class="form-group">
                <label>Address Type</label>
                <select name="address_type" required>
                    <option value="home">Home</option>
                    <option value="work">Work</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- Full Name + Phone side by side -->
            <div class="modal-row">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" placeholder="+1 (555) 123-4567" required>
                </div>
            </div>

            <!-- Address Line 1 -->
            <div class="form-group">
                <label>Address Line 1</label>
                <input type="text" name="address_line1" placeholder="123 Main Street" required>
            </div>

            <!-- Address Line 2 -->
            <div class="form-group">
                <label>Address Line 2 <span class="optional">(optional)</span></label>
                <input type="text" name="address_line2" placeholder="Apt, Suite, Floor…">
            </div>

            <!-- City + State side by side -->
            <div class="modal-row">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" placeholder="New York" required>
                </div>
                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" placeholder="NY" required>
                </div>
            </div>

            <!-- Zip + Country side by side -->
            <div class="modal-row">
                <div class="form-group">
                    <label>Zip Code</label>
                    <input type="text" name="zip_code" placeholder="10001" required>
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <select name="country" required>
                        <option value="United States">United States</option>
                        <option value="Canada">Canada</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Australia">Australia</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                    </select>
                </div>
            </div>

            <!-- Set as default toggle -->
            <div class="toggle-row">
                <label class="toggle">
                    <input type="checkbox" name="is_default" value="1">
                    <span class="toggle-slider"></span>
                </label>
                <span>Set as default address</span>
            </div>

            <!-- Cancel + Add buttons -->
            <div class="modal-actions">
                <button type="button" onclick="closeModal('addModal')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus"></i> Add Address
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ============================================================
     EDIT ADDRESS MODAL
     ============================================================ -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box">

        <button onclick="closeModal('editModal')" class="modal-close">
            <i class="fas fa-times"></i>
        </button>

        <div class="modal-header">
            <h2>Edit Address</h2>
            <p>Update your address details</p>
        </div>

        <!-- PHP: Set action to your PHP file that handles updating addresses -->
        <form method="POST" action="update_address.php">
            
            <!-- Hidden field for address ID - PHP will fill this -->
            <input type="text" name="address_id" id="editId" value="<?= $row['id'] ;?>">
            
            <!-- Address Type -->
            <div class="form-group">
                <label>Address Type</label>
                <select name="address_type" id="editType" required>
                    <option value="home" <?= ($row['address_type'] == "home") ? 'selected' : '' ; ?>>Home</option>
                    <option value="work" <?= ($row['address_type'] == "work") ? 'selected' : '' ; ?>>Work</option>
                    <option value="other" <?= ($row['address_type'] == "other") ? 'selected' : '' ; ?>>Other</option>
                </select>
            </div>

            <!-- Full Name + Phone -->
            <div class="modal-row">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" id="editName" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" id="editPhone" required>
                </div>
            </div>

            <!-- Address Line 1 -->
            <div class="form-group">
                <label>Address Line 1</label>
                <input type="text" name="address_line1" id="editLine1" required>
            </div>

            <!-- Address Line 2 -->
            <div class="form-group">
                <label>Address Line 2 <span class="optional">(optional)</span></label>
                <input type="text" name="address_line2" id="editLine2">
            </div>

            <!-- City + State -->
            <div class="modal-row">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" id="editCity" required>
                </div>
                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" id="editState" required>
                </div>
            </div>

            <!-- Zip + Country -->
            <div class="modal-row">
                <div class="form-group">
                    <label>Zip Code</label>
                    <input type="text" name="zip_code" id="editZip" required>
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <select name="country" id="editCountry" required>
                        <option value="United States">United States</option>
                        <option value="Canada">Canada</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Australia">Australia</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                    </select>
                </div>
            </div>

            <!-- Set as default toggle -->
            <div class="toggle-row">
                <label class="toggle">
                    <input type="checkbox" name="is_default" id="editDefault" value="1">
                    <span class="toggle-slider"></span>
                </label>
                <span>Set as default address</span>
            </div>

            <!-- Cancel + Save buttons -->
            <div class="modal-actions">
                <button type="button" onclick="closeModal('editModal')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
