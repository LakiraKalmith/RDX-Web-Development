<section class="login" <?= isset($_GET['login']) ? 'active' : '' ?>>
        <div class="modal-content">

            <!-- Left Decorative Side -->
            <div class="modal-left">
                <div class="brand-logo"><img src="/RDX/images/logo.png" width="100px"></div>
                <div class="brand-tagline">Dress Like You Mean It</div>
                <div class="decorative-line"></div>
                <p class="brand-description">
                    Join the exclusive club of those who understand that fashion is not just clothing—it's a statement, a lifestyle, an identity.
                </p>
            </div>

            <!-- Right Forms Side -->
            <div class="modal-right">
                <span class="close-btn" onclick="closeLogin()">
                    <i class="fa-solid fa-xmark"></i>
                </span>

                <div class="forms-container">

                    <!-- Sign In Form -->
                    <div class="form-wrapper sign-in">
                        <h2 class="form-title">Welcome Back</h2>
                        <p class="form-subtitle">Enter your credentials to continue</p> 

                        <form id="signinForm" method="post" action="login_process.php">
                            <div class="input-group">
                                <input type="text" name="email" required placeholder=" ">
                                <label>Email</label>
                            </div>

                            <div class="input-group">
                                <input type="password" name="password" required placeholder=" " class="password"><div class="password-toggle"><i class="fa-solid fa-eye showPassword"></i></div>
                                <label>Password</label>
                            </div>

                            <div style="text-align: right; margin: -10px 0 20px 0;">
                                <a href="#" style="color: #888; font-size: 13px; text-decoration: none; transition: color 0.3s;" 
                                   onmouseover="this.style.color='#c5ab80'" 
                                   onmouseout="this.style.color='#888'">Forgot Password?</a>
                            </div>

                            <button type="submit" class="submit-btn">Sign In</button>

                            <div class="toggle-link">
                                <p>New to RDX? <a class="show-signup">Create an account</a></p>
                            </div>
                        </form>
                    </div>

                     <!-- Sign Up Form -->
                    <div class="form-wrapper sign-up">
                        <h2 class="form-title">Join RDX</h2>
                        <p class="form-subtitle">Create your account to get started</p>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-error" style="margin-bottom: 20px; padding: 12px; background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; border-radius: 6px; color: #ef4444; font-size: 14px;">
                                ✗ <?= $_SESSION['error']; ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <form id="signupForm" method="post" action="register_process.php">
                            <div class="input-row">
                                <div class="input-group">
                                    <input type="text" name="first_name" required placeholder=" ">
                                    <label>First Name</label>
                                </div>

                                <div class="input-group">
                                    <input type="text" name="last_name" required placeholder=" ">
                                    <label>Last Name</label>
                                </div>
                            </div>

                            <div class="input-group">
                                <input type="email" name="email" required placeholder=" ">
                                <label>Email Address</label>
                            </div>

                            <div class="input-group">
                                <input type="password" name="password" required placeholder=" " class="password"><div class="password-toggle"><i class="fa-solid fa-eye showPassword"></i></div>
                                <label>Password</label>
                            </div>

                            <div class="checkbox-group">
                                <input type="checkbox" id="terms" required>
                                <label for="terms">I agree to the Terms & Conditions</label>
                            </div>

                            <button type="submit" class="submit-btn">Create Account</button>

                             <div class="toggle-link">
                                <p>Already have an account? <a class="show-signin">Sign in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
</section>