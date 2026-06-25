<?php
// contact.php - Complete Rebranded Contact Page with Map
require_once 'config/db_config.php';
$conn = getDB();

$settings = getSettings();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $msg = sanitize($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($msg)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $conn = getDB();
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $ip = $_SERVER['REMOTE_ADDR'];
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $stmt->bind_param("sssssss", $name, $email, $phone, $subject, $msg, $ip, $ua);
        if ($stmt->execute()) {
            $message = 'Thank you! Your message has been sent. We will get back to you soon.';
        } else {
            $error = 'An error occurred. Please try again.';
        }
    }
}

include 'header.php';
?>

<style>
    /* ============================================================
    BRAND COLORS - From Logo Analysis
    ============================================================ */
    :root {
        --primary-blue: #2D6FB7;
        --primary-blue-dark: #1a4f8a;
        --secondary-turquoise: #12A9C6;
        --accent-green: #6CC04A;
        --gold: #D4AF37;
        --dark: #1F2937;
        --gray: #6B7280;
        --light-gray: #F8FAFC;
        --white: #FFFFFF;
        --brand-gradient: linear-gradient(135deg, #2D6FB7, #12A9C6);
        --gold-gradient: linear-gradient(135deg, #D4AF37, #f5d76e);
    }

    /* ============================================================
    CONTACT HERO - Brand Colors
    ============================================================ */
    .contact-hero {
        background: var(--brand-gradient);
        padding: 120px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .contact-hero .hero-badge {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        color: white;
        padding: 8px 24px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        margin-bottom: 1.5rem;
    }

    .contact-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .contact-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .contact-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .contact-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    CONTACT INFO CARDS - Brand Colors
    ============================================================ */
    .contact-info-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(45, 111, 183, 0.08);
        border-color: rgba(18, 169, 198, 0.15);
    }

    .contact-info-card .icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .contact-info-card:hover .icon {
        transform: scale(1.05);
    }

    .contact-info-card .icon.primary { background: rgba(45, 111, 183, 0.1); color: var(--primary-blue); }
    .contact-info-card .icon.turquoise { background: rgba(18, 169, 198, 0.1); color: var(--secondary-turquoise); }
    .contact-info-card .icon.gold { background: rgba(212, 175, 55, 0.1); color: var(--gold); }
    .contact-info-card .icon.green { background: rgba(108, 192, 74, 0.1); color: var(--accent-green); }

    .contact-info-card h4 {
        font-weight: 600;
        color: var(--dark);
        font-size: 0.95rem;
    }

    .contact-info-card p {
        color: var(--gray);
        font-size: 0.9rem;
        margin: 0;
    }

    .contact-info-card .social-links {
        display: flex;
        gap: 0.75rem;
        margin-top: 0.25rem;
    }

    .contact-info-card .social-links a {
        color: #9CA3AF;
        transition: all 0.3s ease;
        font-size: 1.2rem;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #E5E7EB;
    }

    .contact-info-card .social-links a:hover {
        background: var(--brand-gradient);
        color: white;
        border-color: transparent;
        transform: scale(1.1);
    }

    /* ============================================================
    CONTACT FORM - Brand Colors
    ============================================================ */
    .contact-form input,
    .contact-form textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #D1D5DB;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        background: var(--white);
        color: var(--dark);
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(45, 111, 183, 0.1);
    }

    .contact-form input::placeholder,
    .contact-form textarea::placeholder {
        color: #9CA3AF;
    }

    .contact-form label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .contact-form label .required {
        color: #EF4444;
        margin-left: 2px;
    }

    .contact-form .submit-btn {
        width: 100%;
        padding: 14px;
        font-size: 1.05rem;
        font-weight: 700;
        border-radius: 12px;
        background: var(--brand-gradient);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 20px rgba(45, 111, 183, 0.3);
    }

    .contact-form .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(45, 111, 183, 0.4);
    }

    .contact-form .submit-btn:active {
        transform: translateY(0);
    }

    /* ============================================================
    WORKING HOURS - Brand Colors
    ============================================================ */
    .working-hours {
        background: var(--light-gray);
        padding: 3rem 0;
    }

    .working-hours .hour-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .working-hours .hour-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(45, 111, 183, 0.06);
        border-color: rgba(18, 169, 198, 0.15);
    }

    .working-hours .hour-card .day {
        font-weight: 700;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
    }

    .working-hours .hour-card .time {
        color: var(--gray);
        font-size: 0.95rem;
        margin-top: 0.25rem;
    }

    .working-hours .hour-card .icon {
        font-size: 1.5rem;
        color: var(--secondary-turquoise);
        margin-bottom: 0.5rem;
    }

    .working-hours .hour-card.closed .icon {
        color: #EF4444;
    }

    .working-hours .hour-card.closed .time {
        color: #EF4444;
        font-weight: 500;
    }

    /* ============================================================
    MAP CONTAINER - Brand Colors
    ============================================================ */
    .map-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 2px solid rgba(45, 111, 183, 0.05);
        transition: all 0.3s ease;
    }

    .map-container:hover {
        border-color: rgba(45, 111, 183, 0.15);
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    .map-container iframe {
        display: block;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .contact-hero h1 { font-size: 2.5rem; }
        .contact-hero p { font-size: 1rem; }
        .contact-info-card { padding: 1rem; }
        .contact-info-card .icon { width: 40px; height: 40px; font-size: 1rem; }
        .contact-form input, .contact-form textarea { font-size: 0.9rem; }
        .working-hours .hour-card { padding: 1rem; }
    }

    @media (max-width: 480px) {
        .contact-hero h1 { font-size: 2rem; }
        .contact-hero { padding: 100px 0 40px; }
        .contact-info-card { flex-direction: column; text-align: center; }
        .contact-info-card .social-links { justify-content: center; }
        .working-hours .hour-card .day { font-size: 0.95rem; }
        .working-hours .hour-card .time { font-size: 0.85rem; }
    }

    /* Section title override */
    .section-title .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-badge {
        display: inline-block;
        background: rgba(18, 169, 198, 0.1);
        color: var(--secondary-turquoise);
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
    }

    /* Alert styles */
    .alert-success {
        background: #D1FAE5;
        border: 1px solid #A7F3D0;
        color: #065F46;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-success i {
        color: var(--accent-green);
        font-size: 1.2rem;
    }

    .alert-error {
        background: #FEE2E2;
        border: 1px solid #FCA5A5;
        color: #991B1B;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-error i {
        color: #EF4444;
        font-size: 1.2rem;
    }
</style>

<!-- ========================================== -->
<!-- CONTACT HERO - REBRANDED -->
<!-- ========================================== -->
<section class="contact-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-envelope"></i>Get in Touch
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            Contact <span class="highlight">Us</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Get in touch with us for all your manpower requirements
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- CONTACT SECTION - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div data-aos="fade-right">
                <span class="section-badge">Send a Message</span>
                <h2 class="text-2xl md:text-3xl font-bold text-dark mb-2 font-poppins">
                    We'd Love to <span class="highlight">Hear From You</span>
                </h2>
                <p class="text-gray-600 mb-6">Fill in the form below and we'll get back to you as soon as possible.</p>

                <?php if ($message): ?>
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $message; ?>
                </div>
                <?php endif; ?>

                <?php if ($error): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="" class="contact-form space-y-4">
                    <div>
                        <label>Your Name <span class="required">*</span></label>
                        <input type="text" name="name" required placeholder="Enter your full name">
                    </div>
                    <div>
                        <label>Email Address <span class="required">*</span></label>
                        <input type="email" name="email" required placeholder="your@email.com">
                    </div>
                    <div>
                        <label>Phone Number</label>
                        <input type="tel" name="phone" placeholder="+251 9XX XXX XXX">
                    </div>
                    <div>
                        <label>Subject</label>
                        <input type="text" name="subject" placeholder="How can we help?">
                    </div>
                    <div>
                        <label>Message <span class="required">*</span></label>
                        <textarea name="message" rows="5" required placeholder="Tell us about your requirements..."></textarea>
                    </div>
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i>Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div data-aos="fade-left">
                <span class="section-badge">Contact Info</span>
                <h2 class="text-2xl md:text-3xl font-bold text-dark mb-2 font-poppins">
                    Get in <span class="highlight">Touch</span>
                </h2>
                <p class="text-gray-600 mb-6">Reach out to us through any of the following channels.</p>

                <div class="space-y-4">
                    <!-- Address -->
                    <div class="contact-info-card">
                        <div class="icon primary"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h4>Office Address</h4>
                            <p><?php echo $settings['site_address'] ?? 'Addis Ababa, Ethiopia'; ?></p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="contact-info-card">
                        <div class="icon turquoise"><i class="fas fa-phone"></i></div>
                        <div>
                            <h4>Phone Numbers</h4>
                            <p><?php echo $settings['site_phone'] ?? '+251 981 82 22 22'; ?></p>
                            <p><?php echo $settings['site_mobile'] ?? '+251 981 72 22 22'; ?></p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="contact-info-card">
                        <div class="icon green"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h4>Email Address</h4>
                            <p><?php echo $settings['site_email'] ?? 'ethioareb22@gmail.com'; ?></p>
                            <p><?php echo $settings['support_email'] ?? 'ethioareb22@gmail.com'; ?></p>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="contact-info-card">
                        <div class="icon gold"><i class="fas fa-globe"></i></div>
                        <div>
                            <h4>Connect With Us</h4>
                            <div class="social-links">
                                <?php if (!empty($settings['site_whatsapp'])): ?>
                                <a href="<?php echo $settings['site_whatsapp']; ?>" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($settings['site_telegram'])): ?>
                                <a href="https://t.me/<?php echo ltrim($settings['site_telegram'], '@'); ?>" target="_blank" title="Telegram"><i class="fab fa-telegram-plane"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($settings['site_facebook'])): ?>
                                <a href="<?php echo $settings['site_facebook']; ?>" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($settings['site_linkedin'])): ?>
                                <a href="<?php echo $settings['site_linkedin']; ?>" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($settings['site_twitter'])): ?>
                                <a href="<?php echo $settings['site_twitter']; ?>" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($settings['site_instagram'])): ?>
                                <a href="<?php echo $settings['site_instagram']; ?>" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($settings['site_youtube'])): ?>
                                <a href="<?php echo $settings['site_youtube']; ?>" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Map -->
                <?php if (!empty($settings['site_google_maps'])): ?>
                <div class="map-container mt-6">
                    <iframe src="<?php echo $settings['site_google_maps']; ?>" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- WORKING HOURS - REBRANDED -->
<!-- ========================================== -->
<section class="working-hours">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10" data-aos="fade-up">
            <span class="section-badge">Working Hours</span>
            <h2 class="section-title">When You Can <span class="highlight">Reach Us</span></h2>
            <p class="section-subtitle">We're here to help during our working hours</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-3xl mx-auto">
            <div class="hour-card" data-aos="fade-up">
                <div class="icon"><i class="fas fa-calendar-day"></i></div>
                <div class="day">Monday - Friday</div>
                <div class="time">8:00 AM - 6:00 PM</div>
            </div>
            <div class="hour-card" data-aos="fade-up" data-aos-delay="100">
                <div class="icon"><i class="fas fa-calendar-week"></i></div>
                <div class="day">Saturday</div>
                <div class="time">9:00 AM - 1:00 PM</div>
            </div>
            <div class="hour-card closed" data-aos="fade-up" data-aos-delay="200">
                <div class="icon"><i class="fas fa-calendar-times"></i></div>
                <div class="day">Sunday</div>
                <div class="time">Closed</div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>