<?php 
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';
?>
<body>


<!-- nav bar -->
<?php include 'includes/nav.php'; ?>

<section class="contact-hero">
    <h4>GET IN TOUCH</h4>
    <p>Whether you have a question about our products, your order, or anything else, our team is here to help.</p>
</section>  

<section class="contact-form-section">
    <div class="form-container">
        <div class="form-header">
            <h3>Send Us a Message</h3>
            <!-- <p>Fill out the form below and we'll get back to you as soon as possible</p> -->
        </div>
        
        <form class="contact-form" id="contactForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="inquiry-type">What is this regarding? <span class="required">*</span></label>
                    <select id="inquiry-type" name="inquiry-type" required>
                        <option value="">Select an option</option>
                        <option value="general">General Inquiry</option>
                        <option value="order">Order Status / Issue</option>
                        <option value="product">Product Question</option>
                        <option value="returns">Returns & Exchanges</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="subject">Subject <span class="required">*</span></label>
                <input type="text" id="subject" name="subject" required>
            </div>
            
            <div class="form-group">
                <label for="message">Your Message <span class="required">*</span></label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>
            
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</section>

<!-- <section class="social-hours-section">
    <div class="social-hours-container">
        
        <div class="social-card">
            <h5>Follow Our Journey</h5>
            <div class="social-links">
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
        
        <div class="hours-card">
            <h5>Store Hours</h5>
            <div class="hours-list">
                <div class="hours-row">
                    <span>Monday - Friday</span>
                    <span>9:00 AM - 6:00 PM</span>
                </div>
                <div class="hours-row">
                    <span>Saturday</span>
                    <span>10:00 AM - 4:00 PM</span>
                </div>
                <div class="hours-row">
                    <span>Sunday</span>
                    <span>Closed</span>
                </div>
            </div>
        </div>
        
    </div>
</section>

<section class="contact-info-cards">
    <div class="info-cards-container">
        
        <div class="info-card">
            <i class="fas fa-map-marker-alt"></i>
            <h5>Visit Our Store</h5>
            <p>123 Fashion Avenue<br>New York, NY 10001<br>United States</p>
        </div>
        
        <div class="info-card">
            <i class="fas fa-phone-alt"></i>
            <h5>Call Us</h5>
            <p><a href="tel:+15551234567">+1 (555) 123-4567</a><br>Monday - Friday<br>9:00 AM - 6:00 PM EST</p>
        </div>
        
        <div class="info-card">
            <i class="fas fa-envelope"></i>
            <h5>Email Us</h5>
            <p><a href="mailto:support@rdxclothing.com">support@rdxclothing.com</a><br><a href="mailto:info@rdxclothing.com">info@rdxclothing.com</a><br>We reply within 24 hours</p>
        </div>
        
    </div>
</section>
 -->

<section class="faq-section">
    <div class="faq-header">
        <h3>Frequently Asked Questions</h3>
        <p>Quick answers to questions you may have</p>
    </div>
    
    <div class="faq-container">
        
        <div class="faq-item">
            <div class="faq-question">
                <h5>How long does shipping take?</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Standard shipping typically takes 5-7 business days within the US. Express shipping options are available at checkout for 2-3 day delivery. International shipping times vary by location, typically 10-15 business days.</p>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                <h5>What is your return policy?</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>We offer a 30-day return policy on all unworn items with original tags attached. Returns are free and easy through our online portal. Simply log into your account, select your order, and follow the return instructions.</p>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                <h5>Do you offer international shipping?</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Yes, we ship to most countries worldwide. International shipping times vary by location, typically 10-15 business days. Customs fees and import taxes may apply depending on your country's regulations.</p>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                <h5>How can I track my order?</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Once your order ships, you'll receive a tracking number via email. You can also track your order status anytime by logging into your account dashboard and viewing your order history.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <h5>What payment methods do you accept?</h5>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>We accept all major credit cards (Visa, MasterCard, American Express, Discover), PayPal, Apple Pay, Google Pay, and Shop Pay. All transactions are secure and encrypted.</p>
            </div>
        </div>
        
    </div>
</section>










<!-- footer -->
<?php include __DIR__ . '/includes/footer-scripts.php'; ?>