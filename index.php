<?php
// Root index.php - Complete Rebranded Homepage with Dynamic Hero Slider (No Team Section)

require_once 'config/db_config.php';

// Get database connection
$conn = getDB();

$settings = getSettings();

// ============================================================
// GET HERO SLIDES FROM DATABASE
// ============================================================
$slidesResult = $conn->query("SELECT * FROM hero_slides WHERE is_active = 1 ORDER BY order_no ASC, created_at DESC");
$slides = [];
if ($slidesResult) {
    while ($row = $slidesResult->fetch_assoc()) {
        $slides[] = $row;
    }
}

// If no slides, use fallback
if (empty($slides)) {
    $slides = [
        [
            'id' => 0,
            'title' => 'Getting Right People for the Right Job',
            'subtitle' => 'Overseas Recruitment Agency',
            'description' => 'Connecting Ethiopian talent with global opportunities across Gulf and Middle Eastern countries.',
            'image' => '',
            'button_text' => 'Apply Now',
            'button_url' => SITE_URL . 'apply',
            'button_type' => 'primary',
            'background_color' => '#13AABB',
            'text_color' => '#FFFFFF'
        ]
    ];
}

$services = getServices(6);
$testimonials = getTestimonials(6);
$blogPosts = getBlogPosts(3);
$galleryItems = getGalleryItems(null, 6);
$timeline = getTimeline();
$faqs = getFAQs();
$stats = getDashboardStats();

include 'header.php';
?>

<style>
    /* ============================================================
    ACCURATE BRAND COLORS - Extracted from Logo
    ============================================================ */
    :root {
        --brand-sky-blue: #36B4E7;      /* "E" monogram */
        --brand-leaf-green: #69BD44;    /* "A" monogram */
        --brand-teal: #13AABB;           /* Globe ring, continents, plane */
        --brand-navy: #3E5297;           /* Amharic tagline + company name */
        --gold: #D4AF37;
        --dark: #1F2937;
        --gray: #6B7280;
        --light-gray: #F8FAFC;
        --white: #FFFFFF;
        --brand-gradient: linear-gradient(135deg, var(--brand-teal), var(--brand-navy));
        --accent-gradient: linear-gradient(135deg, var(--brand-sky-blue), var(--brand-leaf-green));
        --gold-gradient: linear-gradient(135deg, #D4AF37, #f5d76e);
    }

    /* ============================================================
    HERO SLIDER STYLES
    ============================================================ */
    .hero-slider-section {
        position: relative;
        overflow: hidden;
        min-height: 90vh;
    }
    
    .hero-slider-section .swiper {
        height: 90vh;
        min-height: 600px;
        width: 100%;
    }
    
    .hero-slider-section .swiper-slide {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        width: 100%;
        height: 100%;
    }
    
    .hero-slider-section .swiper-slide .slide-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.35);
        z-index: 1;
    }
    
    .hero-slider-section .swiper-slide .slide-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        padding: 2rem;
        width: 100%;
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-badge {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.2);
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
        animation: pulse-badge 2s infinite;
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-badge i {
        margin-right: 8px;
        color: var(--gold);
    }
    
    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.03); }
    }
    
    .hero-slider-section .swiper-slide .slide-content h1 {
        font-size: 4rem;
        font-weight: 800;
        line-height: 1.1;
        color: white;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 1rem;
    }
    
    .hero-slider-section .swiper-slide .slide-content h1 .highlight {
        color: var(--gold);
        position: relative;
    }
    
    .hero-slider-section .swiper-slide .slide-content h1 .highlight::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--gold-gradient);
        border-radius: 2px;
        animation: underline-grow 2.5s ease infinite;
    }
    
    @keyframes underline-grow {
        0%, 100% { width: 0; }
        50% { width: 100%; }
    }
    
    .hero-slider-section .swiper-slide .slide-content p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
        max-width: 550px;
        line-height: 1.8;
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-btn {
        padding: 14px 36px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-btn.primary {
        background: var(--brand-teal);
        color: white;
        box-shadow: 0 4px 20px rgba(19, 170, 187, 0.3);
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-btn.primary:hover {
        background: #0e8ba3;
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(19, 170, 187, 0.4);
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-btn.secondary {
        background: var(--brand-leaf-green);
        color: white;
        box-shadow: 0 4px 20px rgba(105, 189, 68, 0.3);
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-btn.secondary:hover {
        background: #4CAF50;
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(105, 189, 68, 0.4);
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-btn.outline {
        background: transparent;
        color: white;
        border: 2px solid white;
    }
    
    .hero-slider-section .swiper-slide .slide-content .slide-btn.outline:hover {
        background: white;
        color: var(--brand-navy);
        transform: translateY(-3px);
    }
    
    /* Swiper Navigation */
    .hero-slider-section .swiper-button-next,
    .hero-slider-section .swiper-button-prev {
        color: white;
        background: rgba(255,255,255,0.15);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.3s ease;
    }
    
    .hero-slider-section .swiper-button-next:hover,
    .hero-slider-section .swiper-button-prev:hover {
        background: rgba(255,255,255,0.25);
        transform: scale(1.05);
    }
    
    .hero-slider-section .swiper-button-next::after,
    .hero-slider-section .swiper-button-prev::after {
        font-size: 1.2rem;
    }
    
    .hero-slider-section .swiper-pagination-bullet {
        background: rgba(255,255,255,0.5);
        opacity: 1;
        width: 12px;
        height: 12px;
        transition: all 0.3s ease;
    }
    
    .hero-slider-section .swiper-pagination-bullet-active {
        background: var(--gold);
        width: 30px;
        border-radius: 6px;
    }
    
    /* ============================================================
    HERO SECTION (Fallback when no slides)
    ============================================================ */
    .hero-section-fallback {
        background: var(--brand-gradient);
        min-height: 90vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section-fallback .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .hero-section-fallback .hero-particles span {
        position: absolute;
        display: block;
        width: 20px;
        height: 20px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
        animation: float 15s infinite;
    }

    .hero-section-fallback .hero-particles span:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; width: 30px; height: 30px; }
    .hero-section-fallback .hero-particles span:nth-child(2) { top: 30%; right: 15%; animation-delay: 2s; width: 40px; height: 40px; }
    .hero-section-fallback .hero-particles span:nth-child(3) { bottom: 20%; left: 10%; animation-delay: 4s; width: 25px; height: 25px; }
    .hero-section-fallback .hero-particles span:nth-child(4) { bottom: 30%; right: 25%; animation-delay: 6s; width: 35px; height: 35px; }
    .hero-section-fallback .hero-particles span:nth-child(5) { top: 50%; left: 50%; animation-delay: 8s; width: 50px; height: 50px; }
    .hero-section-fallback .hero-particles span:nth-child(6) { top: 15%; right: 40%; animation-delay: 10s; width: 20px; height: 20px; }
    .hero-section-fallback .hero-particles span:nth-child(7) { bottom: 40%; left: 35%; animation-delay: 12s; width: 45px; height: 45px; }
    .hero-section-fallback .hero-particles span:nth-child(8) { top: 60%; right: 5%; animation-delay: 14s; width: 30px; height: 30px; }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
        25% { transform: translateY(-30px) rotate(90deg); opacity: 0.6; }
        50% { transform: translateY(-60px) rotate(180deg); opacity: 0.3; }
        75% { transform: translateY(-30px) rotate(270deg); opacity: 0.6; }
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-content .hero-badge {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.2);
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
        animation: pulse-badge 2s infinite;
    }

    .hero-content .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .hero-content h1 {
        font-size: 4rem;
        font-weight: 800;
        line-height: 1.1;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .hero-content h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
    }

    .hero-content h1 .highlight::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--gold-gradient);
        border-radius: 2px;
        animation: underline-grow 2.5s ease infinite;
    }

    .hero-content p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
        max-width: 550px;
        line-height: 1.8;
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
        max-width: 450px;
    }

    .hero-stats .stat-item {
        text-align: center;
        color: white;
        padding: 0.5rem;
    }

    .hero-stats .stat-item .number {
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        color: var(--gold);
        display: block;
    }

    .hero-stats .stat-item .label {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.75);
        margin-top: 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .hero-btn-primary {
        background: var(--brand-teal);
        color: white;
        padding: 14px 36px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        display: inline-block;
        border: none;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(19, 170, 187, 0.3);
    }
    .hero-btn-primary:hover {
        background: #0e8ba3;
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(19, 170, 187, 0.4);
        color: white;
    }

    .hero-btn-success {
        background: var(--brand-leaf-green);
        color: white;
        padding: 14px 36px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        display: inline-block;
        border: none;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(105, 189, 68, 0.3);
    }
    .hero-btn-success:hover {
        background: #4CAF50;
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(105, 189, 68, 0.4);
        color: white;
    }

    .hero-image-wrapper {
        position: relative;
        z-index: 2;
    }

    .hero-image-wrapper .floating-card {
        position: absolute;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1rem 1.5rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: float-card 3.5s ease-in-out infinite;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .hero-image-wrapper .floating-card:nth-child(2) {
        top: -20px;
        right: -30px;
        animation-delay: 1s;
    }

    .hero-image-wrapper .floating-card:nth-child(3) {
        bottom: 30px;
        left: -40px;
        animation-delay: 2s;
    }

    @keyframes float-card {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* ============================================================
    SERVICE CARDS - Brand Colors
    ============================================================ */
    .service-card-modern {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .service-card-modern::before {
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

    .service-card-modern:hover::before {
        opacity: 1;
    }

    .service-card-modern:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(62, 82, 151, 0.12);
        border-color: rgba(19, 170, 187, 0.2);
    }

    .service-card-modern .icon-wrapper {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(54, 180, 231, 0.08), rgba(19, 170, 187, 0.08));
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: var(--brand-teal);
        margin-bottom: 1.25rem;
        transition: all 0.4s ease;
    }

    .service-card-modern:hover .icon-wrapper {
        background: var(--brand-gradient);
        color: white;
        transform: rotate(-10deg) scale(1.1);
    }

    /* ============================================================
    STATS COUNTER - Brand Colors
    ============================================================ */
    .stats-counter {
        background: var(--brand-gradient);
        padding: 4rem 0;
        position: relative;
    }

    .stats-counter .stat-box {
        text-align: center;
        color: white;
        padding: 1.5rem;
        border-right: 1px solid rgba(255,255,255,0.1);
    }

    .stats-counter .stat-box:last-child {
        border-right: none;
    }

    .stats-counter .stat-box .counter {
        font-size: 3.5rem;
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        color: var(--gold);
        display: block;
    }

    .stats-counter .stat-box .label {
        font-size: 1rem;
        color: rgba(255,255,255,0.85);
        margin-top: 0.5rem;
        font-weight: 400;
    }

    .stats-counter .stat-box .label i {
        margin-right: 6px;
        color: var(--gold);
    }

    /* ============================================================
    TESTIMONIAL CARDS
    ============================================================ */
    .testimonial-card-modern {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
        height: 100%;
    }

    .testimonial-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0,0,0,0.08);
    }

    .testimonial-card-modern .quote-icon {
        font-size: 2.5rem;
        color: var(--gold);
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .testimonial-card-modern .rating {
        color: var(--gold);
        margin-bottom: 0.75rem;
    }

    /* ============================================================
    BLOG CARDS
    ============================================================ */
    .blog-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.4s ease;
        height: 100%;
    }

    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    }

    .blog-card .blog-image {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .blog-card .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .blog-card:hover .blog-image img {
        transform: scale(1.08);
    }

    .blog-card .blog-image .category-tag {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: var(--brand-gradient);
        color: white;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .blog-card .blog-body {
        padding: 1.5rem;
    }

    .blog-card .blog-body .meta {
        font-size: 0.8rem;
        color: var(--gray);
        margin-bottom: 0.5rem;
    }

    .blog-card .blog-body .meta i {
        margin-right: 4px;
        color: var(--brand-teal);
    }

    .blog-card .blog-body h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .blog-card:hover .blog-body h4 {
        color: var(--brand-navy);
    }

    .blog-card .blog-body .read-more {
        color: var(--brand-navy);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .blog-card .blog-body .read-more:hover {
        color: var(--brand-teal);
        gap: 12px;
    }

    /* ============================================================
    CTA SECTION - Brand Colors
    ============================================================ */
    .cta-section {
        background: var(--brand-gradient);
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .cta-section .cta-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .cta-section .cta-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 1rem;
    }

    .cta-section .cta-content p {
        color: rgba(255,255,255,0.9);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .cta-section .cta-content .btn-white {
        background: white;
        color: var(--brand-navy);
        padding: 14px 40px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .cta-section .cta-content .btn-white:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .cta-section .cta-content .btn-success-cta {
        background: var(--brand-leaf-green);
        color: white;
        padding: 14px 40px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(105, 189, 68, 0.3);
    }

    .cta-section .cta-content .btn-success-cta:hover {
        background: #4CAF50;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(105, 189, 68, 0.4);
        color: white;
    }

    /* ============================================================
    FAQ SECTION
    ============================================================ */
    .faq-toggle .fa-chevron-down {
        color: var(--brand-teal);
    }

    .faq-toggle .fa-chevron-down.rotated {
        transform: rotate(180deg);
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 1024px) {
        .hero-slider-section .swiper-slide .slide-content h1 { font-size: 3rem; }
        .stats-counter .stat-box .counter { font-size: 2.5rem; }
        .hero-content h1 { font-size: 3rem; }
    }

    @media (max-width: 768px) {
        .hero-slider-section { min-height: 70vh; }
        .hero-slider-section .swiper { height: 70vh; min-height: 500px; }
        .hero-slider-section .swiper-slide .slide-content h1 { font-size: 2.2rem; }
        .hero-slider-section .swiper-slide .slide-content p { font-size: 1rem; }
        .hero-slider-section .swiper-button-next,
        .hero-slider-section .swiper-button-prev { display: none; }
        .hero-slider-section .swiper-slide .slide-content .slide-btn { padding: 12px 24px; font-size: 0.95rem; }
        
        .hero-section-fallback { min-height: 70vh; }
        .hero-content h1 { font-size: 2.2rem; }
        .hero-content p { font-size: 1rem; }
        .hero-stats { grid-template-columns: repeat(3, 1fr); gap: 0.5rem; }
        .hero-stats .stat-item .number { font-size: 1.5rem; }
        .section-title { font-size: 1.8rem; }
        .stats-counter .stat-box { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .stats-counter .stat-box:last-child { border-bottom: none; }
        .cta-section .cta-content h2 { font-size: 1.8rem; }
        .hero-btn-primary, .hero-btn-success { padding: 12px 24px; font-size: 0.95rem; }
    }

    @media (max-width: 480px) {
        .hero-slider-section .swiper { height: 60vh; min-height: 400px; }
        .hero-slider-section .swiper-slide .slide-content h1 { font-size: 1.8rem; }
        .hero-slider-section .swiper-slide .slide-content .slide-buttons { flex-direction: column; align-items: center; }
        .hero-slider-section .swiper-slide .slide-content .slide-btn { width: 100%; text-align: center; }
        
        .hero-content h1 { font-size: 1.8rem; }
        .hero-stats .stat-item .number { font-size: 1.2rem; }
        .hero-stats .stat-item .label { font-size: 0.65rem; }
    }
</style>

<!-- ========================================== -->
<!-- HERO SLIDER SECTION - DYNAMIC FROM DATABASE -->
<!-- ========================================== -->
<?php if (count($slides) > 1 || !empty($slides[0]['image'])): ?>
<section class="hero-slider-section">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $index => $slide): ?>
            <div class="swiper-slide" style="
                background-image: url('<?php echo !empty($slide['image']) ? UPLOAD_URL . 'banners/' . $slide['image'] : ''; ?>');
                background-color: <?php echo $slide['background_color'] ?? '#13AABB'; ?>;
            ">
                <div class="slide-overlay"></div>
                <div class="slide-content" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <?php if (!empty($slide['subtitle'])): ?>
                    <div class="slide-badge">
                        <i class="fas fa-globe-africa"></i><?php echo htmlspecialchars($slide['subtitle']); ?>
                    </div>
                    <?php endif; ?>
                    
                    <h1>
                        <?php 
                        $title = htmlspecialchars($slide['title']);
                        // Highlight "Right Job" if present
                        if (strpos($title, 'Right Job') !== false) {
                            $title = str_replace('Right Job', '<span class="highlight">Right Job</span>', $title);
                        }
                        echo $title;
                        ?>
                    </h1>
                    
                    <?php if (!empty($slide['description'])): ?>
                    <p><?php echo htmlspecialchars($slide['description']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($slide['button_text']) && !empty($slide['button_url'])): ?>
                    <div class="slide-buttons">
                        <a href="<?php echo $slide['button_url']; ?>" class="slide-btn <?php echo $slide['button_type'] ?? 'primary'; ?>" style="color: <?php echo $slide['text_color'] ?? '#FFFFFF'; ?>;">
                            <?php echo htmlspecialchars($slide['button_text']); ?>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Navigation Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<?php else: ?>
<!-- ========================================== -->
<!-- FALLBACK HERO SECTION (when no slides) -->
<!-- ========================================== -->
<section class="hero-section-fallback">
    <div class="hero-particles">
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center hero-content">
            <div>
                <div class="hero-badge" data-aos="fade-up">
                    <i class="fas fa-globe-africa"></i>Overseas Recruitment Agency
                </div>

                <h1 data-aos="fade-up" data-aos-delay="100">
                    Getting Right People for the <span class="highlight">Right Job</span>
                </h1>

                <p data-aos="fade-up" data-aos-delay="200">
                    Connecting Ethiopian talent with global opportunities across Gulf and Middle Eastern countries.
                </p>

                <div class="flex flex-wrap gap-4 mt-8" data-aos="fade-up" data-aos-delay="300">
                    <a href="<?php echo SITE_URL; ?>services" class="hero-btn-primary">
                        <i class="fas fa-rocket mr-2"></i>Our Services
                    </a>
                    <a href="<?php echo SITE_URL; ?>apply" class="hero-btn-success">
                        <i class="fas fa-paper-plane mr-2"></i>Apply Now
                    </a>
                </div>

                <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <span class="number" data-count="5000">0+</span>
                        <span class="label">Candidates Placed</span>
                    </div>
                    <div class="stat-item">
                        <span class="number" data-count="15">0+</span>
                        <span class="label">Countries Served</span>
                    </div>
                    <div class="stat-item">
                        <span class="number" data-count="<?php echo $stats['services']; ?>">0+</span>
                        <span class="label">Services</span>
                    </div>
                </div>
            </div>

            <div class="hero-image-wrapper hidden lg:block" data-aos="fade-left" data-aos-delay="200">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/10 rounded-full blur-3xl"></div>
                    <img src="<?php echo SITE_URL; ?>assets/images/hero-illustration.png" alt="Ethio Areb Recruitment" class="relative w-full max-w-lg mx-auto" onerror="this.style.display='none'">

                    <div class="floating-card hidden xl:block" style="top: -20px; right: -30px;">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-[#69BD44] text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark">100%</p>
                                <p class="text-sm text-gray-500">Satisfaction Rate</p>
                            </div>
                        </div>
                    </div>

                    <div class="floating-card hidden xl:block" style="bottom: 30px; left: -40px;">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-[#36B4E7] text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark">5000+</p>
                                <p class="text-sm text-gray-500">Happy Candidates</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========================================== -->
<!-- WELCOME / ABOUT SECTION -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <span class="text-[#13AABB] font-semibold text-sm uppercase tracking-wider">Welcome to Ethio Areb</span>
                <h2 class="section-title mt-2">Your Trusted <span class="text-[#D4AF37]">Recruitment Partner</span></h2>
                <p class="text-gray-600 text-lg leading-relaxed mt-4">
                    <?php echo $settings['welcome_text'] ?? 'Ethio Areb Foreign Employment Agent Plc is a human resource outsourcing and manpower recruitment agency that partners with global clients to provide them with best talents from Ethiopia.'; ?>
                </p>
                <p class="text-gray-600 mt-4 leading-relaxed">
                    We are a dedicated team of professional consultants offering top of the line executive search and selection services to diverse corporate of all sizes; with varied business interests.
                </p>
                <div class="flex flex-wrap gap-4 mt-6">
                    <a href="<?php echo SITE_URL; ?>about" class="btn-primary">
                        <i class="fas fa-info-circle mr-2"></i>Learn More
                    </a>
                    <a href="<?php echo SITE_URL; ?>contact" class="btn-outline">
                        <i class="fas fa-phone mr-2"></i>Contact Us
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                <div class="bg-[#36B4E7]/5 p-6 rounded-2xl text-center card-hover">
                    <div class="text-4xl font-bold text-[#36B4E7] font-poppins"><?php echo $stats['services']; ?></div>
                    <div class="text-gray-600 mt-1 font-medium">Services</div>
                </div>
                <div class="bg-[#13AABB]/10 p-6 rounded-2xl text-center card-hover">
                    <div class="text-4xl font-bold text-[#13AABB] font-poppins"><?php echo $stats['team']; ?></div>
                    <div class="text-gray-600 mt-1 font-medium">Team Members</div>
                </div>
                <div class="bg-[#69BD44]/10 p-6 rounded-2xl text-center card-hover">
                    <div class="text-4xl font-bold text-[#69BD44] font-poppins"><?php echo $stats['testimonials']; ?></div>
                    <div class="text-gray-600 mt-1 font-medium">Testimonials</div>
                </div>
                <div class="bg-[#3E5297]/5 p-6 rounded-2xl text-center card-hover">
                    <div class="text-4xl font-bold text-[#3E5297] font-poppins"><?php echo $stats['posts']; ?></div>
                    <div class="text-gray-600 mt-1 font-medium">Blog Posts</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- MISSION, VISION, VALUES -->
<!-- ========================================== -->
<section class="py-20 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="text-[#13AABB] font-semibold text-sm uppercase tracking-wider">Our Foundation</span>
            <h2 class="section-title">Mission, Vision &amp; <span class="text-[#D4AF37]">Values</span></h2>
            <p class="section-subtitle">Guiding principles that drive us to deliver excellence in recruitment services</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <div class="bg-white p-8 rounded-2xl shadow-sm card-hover" data-aos="fade-up">
                <div class="w-16 h-16 bg-[#36B4E7]/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-bullseye text-2xl text-[#36B4E7]"></i>
                </div>
                <h3 class="text-xl font-bold text-dark-slate mb-3 font-poppins">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed text-sm"><?php echo $settings['mission'] ?? 'To provide globally competitive manpower resources to clients so they can acquire gifted workforce that will benefit their organization in every way possible.'; ?></p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-[#13AABB]/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-eye text-2xl text-[#13AABB]"></i>
                </div>
                <h3 class="text-xl font-bold text-dark-slate mb-3 font-poppins">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed text-sm"><?php echo $settings['vision'] ?? 'To fulfill the need of our clients by getting Right People for the Right Job and enhance our global presence as a leading overseas recruitment service.'; ?></p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-[#69BD44]/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-handshake text-2xl text-[#69BD44]"></i>
                </div>
                <h3 class="text-xl font-bold text-dark-slate mb-3 font-poppins">Core Values</h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex items-start"><i class="fas fa-check-circle text-[#D4AF37] mt-1 mr-3"></i>Trustworthy connection between employers and employees</li>
                    <li class="flex items-start"><i class="fas fa-check-circle text-[#D4AF37] mt-1 mr-3"></i>Genuine services maintaining trust</li>
                    <li class="flex items-start"><i class="fas fa-check-circle text-[#D4AF37] mt-1 mr-3"></i>Globally competitive manpower</li>
                    <li class="flex items-start"><i class="fas fa-check-circle text-[#D4AF37] mt-1 mr-3"></i>Reducing employment crisis in Ethiopia</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- SERVICES SECTION -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="text-[#13AABB] font-semibold text-sm uppercase tracking-wider">What We Do</span>
            <h2 class="section-title">Our <span class="text-[#D4AF37]">Services</span></h2>
            <p class="section-subtitle">Comprehensive recruitment solutions across multiple industries to meet your manpower needs</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
            <?php foreach ($services as $index => $service): ?>
            <div class="service-card-modern" data-aos="fade-up" data-aos-delay="<?php echo ($index % 3) * 100; ?>">
                <div class="icon-wrapper">
                    <i class="fas fa-<?php echo $service['icon'] ?? 'briefcase'; ?>"></i>
                </div>
                <h4 class="text-xl font-bold text-dark-slate mb-2 font-poppins"><?php echo $service['name']; ?></h4>
                <p class="text-gray-600 text-sm leading-relaxed"><?php echo substr($service['description'] ?? '', 0, 100) . '...'; ?></p>
                <a href="<?php echo SITE_URL; ?>service/<?php echo $service['slug']; ?>" class="text-[#36B4E7] font-semibold hover:text-[#13AABB] transition inline-flex items-center mt-3 text-sm">
                    Learn More <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12" data-aos="fade-up">
            <a href="<?php echo SITE_URL; ?>services" class="btn-primary">View All Services <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- INDUSTRIES WE SERVE -->
<!-- ========================================== -->
<section class="py-16 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="text-[#13AABB] font-semibold text-sm uppercase tracking-wider">Expertise</span>
            <h2 class="section-title">Industries We <span class="text-[#D4AF37]">Serve</span></h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mt-10">
            <?php 
            $industries = [
                ['icon' => 'hard-hat', 'name' => 'Construction', 'color' => '#36B4E7'],
                ['icon' => 'heartbeat', 'name' => 'Healthcare', 'color' => '#EF4444'],
                ['icon' => 'chart-line', 'name' => 'Finance', 'color' => '#22C55E'],
                ['icon' => 'tshirt', 'name' => 'Garment & Textile', 'color' => '#8B5CF6'],
                ['icon' => 'truck', 'name' => 'Transportation', 'color' => '#F59E0B'],
                ['icon' => 'home', 'name' => 'Domestic Services', 'color' => '#14B8A6'],
            ];
            foreach ($industries as $index => $industry): 
            ?>
            <div class="bg-white p-6 rounded-2xl text-center card-hover" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <div class="text-4xl mb-2" style="color: <?php echo $industry['color']; ?>"><i class="fas fa-<?php echo $industry['icon']; ?>"></i></div>
                <span class="text-sm font-semibold text-dark-slate"><?php echo $industry['name']; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- STATISTICS COUNTER -->
<!-- ========================================== -->
<section class="stats-counter">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-box" data-aos="fade-up">
                <span class="counter" data-count="5000">0</span>
                <span class="label"><i class="fas fa-user-check"></i>Candidates Placed</span>
            </div>
            <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                <span class="counter" data-count="15">0</span>
                <span class="label"><i class="fas fa-globe-africa"></i>Countries Served</span>
            </div>
            <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                <span class="counter" data-count="<?php echo $stats['services'] * 10; ?>">0</span>
                <span class="label"><i class="fas fa-briefcase"></i>Jobs Filled</span>
            </div>
            <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                <span class="counter" data-count="<?php echo $stats['team']; ?>">0</span>
                <span class="label"><i class="fas fa-users"></i>Team Members</span>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- TESTIMONIALS SECTION -->
<!-- ========================================== -->
<?php if (!empty($testimonials)): ?>
<section class="py-20 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="text-[#13AABB] font-semibold text-sm uppercase tracking-wider">What People Say</span>
            <h2 class="section-title">Client <span class="text-[#D4AF37]">Testimonials</span></h2>
            <p class="section-subtitle">Hear from our satisfied clients and candidates</p>
        </div>

        <div class="swiper testimonials-swiper mt-12" data-aos="fade-up">
            <div class="swiper-wrapper">
                <?php foreach ($testimonials as $testimonial): ?>
                <div class="swiper-slide">
                    <div class="testimonial-card-modern">
                        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
                        <div class="rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= ($testimonial['rating'] ?? 5) ? 'text-[#D4AF37]' : 'text-gray-300'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="text-gray-700 leading-relaxed">"<?php echo $testimonial['testimonial']; ?>"</p>
                        <div class="flex items-center mt-6">
                            <?php if (!empty($testimonial['photo'])): ?>
                            <img src="<?php echo UPLOAD_URL . 'testimonials/' . $testimonial['photo']; ?>" alt="<?php echo $testimonial['customer_name']; ?>" class="w-12 h-12 rounded-full object-cover">
                            <?php else: ?>
                            <div class="w-12 h-12 rounded-full bg-[#13AABB]/20 flex items-center justify-center text-[#13AABB] font-bold text-xl">
                                <?php echo substr($testimonial['customer_name'], 0, 1); ?>
                            </div>
                            <?php endif; ?>
                            <div class="ml-4">
                                <h4 class="font-bold text-dark-slate"><?php echo $testimonial['customer_name']; ?></h4>
                                <p class="text-sm text-gray-500"><?php echo $testimonial['position']; ?> at <?php echo $testimonial['company']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination mt-8"></div>
        </div>

        <div class="text-center mt-12" data-aos="fade-up">
            <a href="<?php echo SITE_URL; ?>testimonials" class="btn-primary">View All Testimonials <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========================================== -->
<!-- BLOG SECTION -->
<!-- ========================================== -->
<?php if (!empty($blogPosts)): ?>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="text-[#13AABB] font-semibold text-sm uppercase tracking-wider">Stay Updated</span>
            <h2 class="section-title">Latest <span class="text-[#D4AF37]">News</span></h2>
            <p class="section-subtitle">Insights, updates, and articles from the world of recruitment</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
            <?php foreach ($blogPosts as $index => $post): ?>
            <div class="blog-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <div class="blog-image">
                    <?php if (!empty($post['featured_image'])): ?>
                    <img src="<?php echo UPLOAD_URL . 'blog/' . $post['featured_image']; ?>" alt="<?php echo $post['title']; ?>">
                    <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-[#36B4E7]/10 to-[#13AABB]/10 flex items-center justify-center">
                        <i class="fas fa-newspaper text-4xl text-gray-300"></i>
                    </div>
                    <?php endif; ?>
                    <span class="category-tag"><?php echo $post['category_name'] ?? 'General'; ?></span>
                </div>
                <div class="blog-body">
                    <div class="meta">
                        <i class="far fa-calendar-alt"></i> <?php echo date('M d, Y', strtotime($post['published_at'] ?? $post['created_at'])); ?>
                        <span class="mx-2">|</span>
                        <i class="far fa-eye"></i> <?php echo $post['views'] ?? 0; ?>
                    </div>
                    <h4><?php echo $post['title']; ?></h4>
                    <p class="text-gray-600 text-sm"><?php echo substr($post['excerpt'] ?? $post['content'] ?? '', 0, 100) . '...'; ?></p>
                    <a href="<?php echo SITE_URL; ?>blog/<?php echo $post['slug']; ?>" class="read-more">
                        Read More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12" data-aos="fade-up">
            <a href="<?php echo SITE_URL; ?>blog" class="btn-primary">View All Posts <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========================================== -->
<!-- GALLERY SNIPPET -->
<!-- ========================================== -->
<?php if (!empty($galleryItems)): ?>
<section class="py-16 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="text-[#13AABB] font-semibold text-sm uppercase tracking-wider">Visual Tour</span>
            <h2 class="section-title">Our <span class="text-[#D4AF37]">Gallery</span></h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mt-10">
            <?php foreach (array_slice($galleryItems, 0, 6) as $item): ?>
            <div class="relative group overflow-hidden rounded-xl" data-aos="fade-up">
                <?php if (!empty($item['image'])): ?>
                <img src="<?php echo UPLOAD_URL . 'gallery/' . $item['image']; ?>" alt="<?php echo $item['title']; ?>" class="w-full h-32 object-cover transition duration-500 group-hover:scale-110">
                <?php endif; ?>
                <div class="absolute inset-0 bg-[#3E5297]/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    <i class="fas fa-search-plus text-white text-2xl"></i>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-10" data-aos="fade-up">
            <a href="<?php echo SITE_URL; ?>gallery" class="btn-primary">View Full Gallery <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========================================== -->
<!-- FAQ SECTION -->
<!-- ========================================== -->
<?php if (!empty($faqs)): ?>
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="text-[#13AABB] font-semibold text-sm uppercase tracking-wider">Got Questions?</span>
            <h2 class="section-title">Frequently Asked <span class="text-[#D4AF37]">Questions</span></h2>
            <p class="section-subtitle">Find answers to commonly asked questions about our services</p>
        </div>

        <div class="space-y-4 mt-12">
            <?php foreach (array_slice($faqs, 0, 4) as $index => $faq): ?>
            <div class="border border-gray-200 rounded-xl overflow-hidden" data-aos="fade-up" data-aos-delay="<?php echo $index * 50; ?>">
                <button class="faq-toggle w-full text-left px-6 py-4 flex items-center justify-between hover:bg-[#F8FAFC] transition">
                    <span class="font-semibold text-dark-slate"><?php echo $faq['question']; ?></span>
                    <i class="fas fa-chevron-down text-[#13AABB] transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-4">
                    <p class="text-gray-600 leading-relaxed"><?php echo $faq['answer']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-10" data-aos="fade-up">
            <a href="<?php echo SITE_URL; ?>faqs" class="btn-primary">View All FAQs <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    $('.faq-toggle').click(function() {
        const answer = $(this).next('.faq-answer');
        const icon = $(this).find('i');
        
        $('.faq-answer').not(answer).addClass('hidden');
        $('.faq-toggle').not(this).find('i').removeClass('rotated');
        
        answer.toggleClass('hidden');
        icon.toggleClass('rotated');
    });
});
</script>
<?php endif; ?>

<!-- ========================================== -->
<!-- CTA SECTION -->
<!-- ========================================== -->
<section class="cta-section">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="cta-content" data-aos="fade-up">
            <h2>Ready to Find the Right People?</h2>
            <p>Contact us today to discuss your manpower requirements. We'll help you find the best candidates for your organization.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="<?php echo SITE_URL; ?>contact" class="btn-white">
                    <i class="fas fa-phone mr-2"></i>Get in Touch
                </a>
                <a href="<?php echo SITE_URL; ?>apply" class="btn-success-cta">
                    <i class="fas fa-paper-plane mr-2"></i>Apply Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- COUNTER ANIMATION SCRIPT -->
<!-- ========================================== -->
<script>
$(document).ready(function() {
    // ============================================================
    // HERO SLIDER INITIALIZATION
    // ============================================================
    <?php if (count($slides) > 1 || !empty($slides[0]['image'])): ?>
    const heroSwiper = new Swiper('.heroSwiper', {
        slidesPerView: 1,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        speed: 1000,
        watchSlidesProgress: true,
        on: {
            slideChangeTransitionStart: function() {
                // Optional: Add animation on slide change
            },
            slideChangeTransitionEnd: function() {
                // Optional: Add animation on slide change complete
            }
        }
    });
    
    // Pause autoplay on hover
    document.querySelector('.heroSwiper')?.addEventListener('mouseenter', function() {
        heroSwiper.autoplay.stop();
    });
    
    document.querySelector('.heroSwiper')?.addEventListener('mouseleave', function() {
        heroSwiper.autoplay.start();
    });
    <?php endif; ?>
    
    // ============================================================
    // COUNTER ANIMATION
    // ============================================================
    function animateCounters() {
        $('.counter').each(function() {
            const target = parseInt($(this).data('count'));
            if (isNaN(target)) return;
            
            const duration = 2000;
            const steps = 60;
            const increment = target / steps;
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                $(this).text(Math.floor(current).toLocaleString());
            }, duration / steps);
        });
    }
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    $('.stats-counter').each(function() {
        observer.observe(this);
    });
    
    const heroObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                $('.hero-stats .number').each(function() {
                    const target = parseInt($(this).data('count'));
                    if (isNaN(target)) return;
                    
                    const duration = 1500;
                    const steps = 40;
                    const increment = target / steps;
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        $(this).text(Math.floor(current).toLocaleString() + '+');
                    }, duration / steps);
                });
                heroObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    
    $('.hero-stats').each(function() {
        heroObserver.observe(this);
    });
});
</script>

<?php include 'footer.php'; ?>