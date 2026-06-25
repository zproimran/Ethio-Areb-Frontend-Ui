<?php
// testimonials.php - Complete Rebranded Testimonials Page
require_once 'config/db_config.php';
$conn = getDB();

$testimonials = getTestimonials();

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
    TESTIMONIALS HERO - Brand Colors
    ============================================================ */
    .testimonials-hero {
        background: var(--brand-gradient);
        padding: 120px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .testimonials-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .testimonials-hero .hero-badge {
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

    .testimonials-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .testimonials-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .testimonials-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .testimonials-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    TESTIMONIAL CARDS - Brand Colors
    ============================================================ */
    .testimonial-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.04);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .testimonial-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--brand-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .testimonial-card:hover::before {
        opacity: 1;
    }

    .testimonial-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(45, 111, 183, 0.12);
        border-color: rgba(18, 169, 198, 0.15);
    }

    .testimonial-card .quote-icon {
        font-size: 2.5rem;
        color: var(--gold);
        opacity: 0.25;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }

    .testimonial-card:hover .quote-icon {
        opacity: 0.5;
        transform: scale(1.1);
    }

    .testimonial-card .rating {
        color: var(--gold);
        margin-bottom: 0.75rem;
    }

    .testimonial-card .rating .star {
        transition: all 0.3s ease;
    }

    .testimonial-card:hover .rating .star {
        animation: starPulse 0.5s ease;
    }

    @keyframes starPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .testimonial-card .text {
        color: #4B5563;
        line-height: 1.8;
        font-size: 1rem;
        font-style: italic;
        position: relative;
        padding: 0 0.5rem;
    }

    .testimonial-card .text::before {
        content: '"';
        font-size: 3rem;
        color: var(--secondary-turquoise);
        opacity: 0.1;
        position: absolute;
        top: -10px;
        left: -5px;
        font-family: 'Georgia', serif;
    }

    .testimonial-card .author {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #F3F4F6;
    }

    .testimonial-card .author .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--gold);
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .testimonial-card:hover .author .avatar {
        border-color: var(--secondary-turquoise);
        transform: scale(1.05);
    }

    .testimonial-card .author .avatar-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--brand-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        font-family: 'Poppins', sans-serif;
        border: 2px solid var(--gold);
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .testimonial-card:hover .author .avatar-placeholder {
        border-color: var(--secondary-turquoise);
        transform: scale(1.05);
    }

    .testimonial-card .author .name {
        font-weight: 700;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
    }

    .testimonial-card .author .position {
        font-size: 0.85rem;
        color: var(--gray);
    }

    .testimonial-card .author .position .company {
        color: var(--primary-blue);
        font-weight: 500;
    }

    .testimonial-card .video-badge {
        display: inline-block;
        background: rgba(18, 169, 198, 0.1);
        color: var(--secondary-turquoise);
        padding: 2px 12px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 600;
        margin-top: 0.5rem;
        border: 1px solid rgba(18, 169, 198, 0.15);
    }

    .testimonial-card .video-badge i {
        margin-right: 4px;
    }

    /* ============================================================
    TESTIMONIAL STATS - Brand Colors
    ============================================================ */
    .testimonial-stats {
        background: var(--light-gray);
        padding: 3rem 0;
    }

    .testimonial-stats .stat-item {
        text-align: center;
        padding: 1.5rem;
    }

    .testimonial-stats .stat-item .number {
        font-size: 2.5rem;
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        background: var(--brand-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .testimonial-stats .stat-item .label {
        color: var(--gray);
        font-weight: 500;
        margin-top: 0.25rem;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .testimonials-hero h1 { font-size: 2.5rem; }
        .testimonials-hero p { font-size: 1rem; }
        .testimonial-card { padding: 1.5rem; }
        .testimonial-card .text { font-size: 0.9rem; }
        .testimonial-card .author .name { font-size: 0.95rem; }
        .testimonial-stats .stat-item .number { font-size: 2rem; }
    }

    @media (max-width: 480px) {
        .testimonials-hero h1 { font-size: 2rem; }
        .testimonials-hero { padding: 100px 0 40px; }
        .testimonial-card { padding: 1rem; }
        .testimonial-card .author { flex-direction: column; text-align: center; }
        .testimonial-card .author .avatar,
        .testimonial-card .author .avatar-placeholder { width: 60px; height: 60px; font-size: 1.5rem; }
        .testimonial-card .text::before { display: none; }
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

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state .icon {
        font-size: 4rem;
        color: #D1D5DB;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--gray);
        max-width: 400px;
        margin: 0 auto;
    }

    /* CTA Section - Brand Colors */
    .cta-testimonials {
        background: var(--brand-gradient);
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }

    .cta-testimonials::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .cta-testimonials .cta-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .cta-testimonials .cta-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 1rem;
    }

    .cta-testimonials .cta-content h2 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .cta-testimonials .cta-content p {
        color: rgba(255,255,255,0.9);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .cta-testimonials .cta-content .btn-white {
        background: white;
        color: var(--primary-blue);
        padding: 14px 40px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .cta-testimonials .cta-content .btn-white:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .cta-testimonials .cta-content .btn-green {
        background: var(--accent-green);
        color: white;
        padding: 14px 40px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(108, 192, 74, 0.3);
    }

    .cta-testimonials .cta-content .btn-green:hover {
        background: #4CAF50;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(108, 192, 74, 0.4);
        color: white;
    }
</style>

<!-- ========================================== -->
<!-- TESTIMONIALS HERO - REBRANDED -->
<!-- ========================================== -->
<section class="testimonials-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-star"></i>What People Say
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            Client <span class="highlight">Testimonials</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            What our clients and candidates say about us
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- TESTIMONIAL STATS - REBRANDED -->
<!-- ========================================== -->
<section class="testimonial-stats">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-item" data-aos="fade-up">
                <div class="number"><?php echo count($testimonials); ?>+</div>
                <div class="label">Client Testimonials</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <div class="number">4.9/5</div>
                <div class="label">Average Rating</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <div class="number">98%</div>
                <div class="label">Satisfaction Rate</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <div class="number">100+</div>
                <div class="label">Happy Clients</div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- TESTIMONIALS LISTING - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="section-badge">Real Stories</span>
            <h2 class="section-title">What Our <span class="highlight">Clients Say</span></h2>
            <p class="section-subtitle">Hear from our satisfied clients and candidates about their experience with Ethio Areb</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-card" data-aos="fade-up">
                <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
                <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star star <?php echo $i <= ($testimonial['rating'] ?? 5) ? 'text-[#D4AF37]' : 'text-gray-300'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <p class="text"><?php echo $testimonial['testimonial']; ?></p>
                <?php if (!empty($testimonial['video_url'])): ?>
                <span class="video-badge"><i class="fas fa-video"></i> Video Testimonial</span>
                <?php endif; ?>
                <div class="author">
                    <?php if (!empty($testimonial['photo'])): ?>
                    <img src="<?php echo UPLOAD_URL . 'testimonials/' . $testimonial['photo']; ?>" alt="<?php echo $testimonial['customer_name']; ?>" class="avatar">
                    <?php else: ?>
                    <div class="avatar-placeholder"><?php echo substr($testimonial['customer_name'], 0, 1); ?></div>
                    <?php endif; ?>
                    <div>
                        <div class="name"><?php echo $testimonial['customer_name']; ?></div>
                        <div class="position"><?php echo $testimonial['position']; ?> at <span class="company"><?php echo $testimonial['company']; ?></span></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($testimonials)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fas fa-quote-left"></i></div>
            <h3>No Testimonials Yet</h3>
            <p>We're collecting feedback from our clients. Check back soon to see what they have to say.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================== -->
<!-- CTA SECTION - REBRANDED -->
<!-- ========================================== -->
<section class="cta-testimonials">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="cta-content" data-aos="fade-up">
            <h2>Ready to Join Our <span class="highlight">Success Story</span>?</h2>
            <p>Contact us today and let us help you find the right people for the right job.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="<?php echo SITE_URL; ?>contact" class="btn-white">
                    <i class="fas fa-phone mr-2"></i>Get in Touch
                </a>
                <a href="<?php echo SITE_URL; ?>apply" class="btn-green">
                    <i class="fas fa-paper-plane mr-2"></i>Apply Now
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>