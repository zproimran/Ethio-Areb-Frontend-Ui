<?php
// about.php - Complete Rebranded About Page with Team Section
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/db_config.php';

// Get database connection
$conn = getDB();

// Get settings
$settings = getSettings();

// Get company info
$companyInfo = $conn->query("SELECT * FROM company_info LIMIT 1");
if ($companyInfo) {
    $companyInfo = $companyInfo->fetch_assoc();
} else {
    $companyInfo = null;
}

// Get timeline
$timeline = getTimeline();

// Get stats
$stats = getDashboardStats();

// Get certificates
$certificates = $conn->query("SELECT * FROM certificates WHERE is_active = 1 ORDER BY order_no ASC");

// Get team members
$team = getTeamMembers();

// Include header
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
    ABOUT HERO - Brand Colors
    ============================================================ */
    .about-hero {
        background: var(--brand-gradient);
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .about-hero .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .about-hero .hero-particles span {
        position: absolute;
        display: block;
        width: 20px;
        height: 20px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
        animation: float 15s infinite;
    }

    .about-hero .hero-particles span:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; width: 30px; height: 30px; }
    .about-hero .hero-particles span:nth-child(2) { top: 30%; right: 15%; animation-delay: 2s; width: 40px; height: 40px; }
    .about-hero .hero-particles span:nth-child(3) { bottom: 20%; left: 10%; animation-delay: 4s; width: 25px; height: 25px; }
    .about-hero .hero-particles span:nth-child(4) { bottom: 30%; right: 25%; animation-delay: 6s; width: 35px; height: 35px; }
    .about-hero .hero-particles span:nth-child(5) { top: 50%; left: 50%; animation-delay: 8s; width: 50px; height: 50px; }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
        25% { transform: translateY(-30px) rotate(90deg); opacity: 0.6; }
        50% { transform: translateY(-60px) rotate(180deg); opacity: 0.3; }
        75% { transform: translateY(-30px) rotate(270deg); opacity: 0.6; }
    }

    .about-hero .hero-badge {
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

    .about-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .about-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .about-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .about-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    TIMELINE - Brand Colors
    ============================================================ */
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        border-left: 3px solid var(--gold);
        padding-bottom: 2rem;
    }

    .timeline-item:last-child {
        border-left: none;
        padding-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 0;
        width: 14px;
        height: 14px;
        background: var(--gold);
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 3px var(--gold);
    }

    .timeline-item .year {
        color: var(--gold);
        font-weight: 800;
        font-size: 2rem;
        font-family: 'Poppins', sans-serif;
    }

    /* ============================================================
    VALUE CARDS - Brand Colors
    ============================================================ */
    .value-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
        border-top: 4px solid var(--gold);
    }

    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(45, 111, 183, 0.1);
    }

    .value-card .icon {
        width: 60px;
        height: 60px;
        background: rgba(45, 111, 183, 0.08);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-center: center;
        font-size: 24px;
        color: var(--primary-blue);
        margin-bottom: 1rem;
    }

    .value-card .icon.turquoise {
        background: rgba(18, 169, 198, 0.08);
        color: var(--secondary-turquoise);
    }

    .value-card .icon.green {
        background: rgba(108, 192, 74, 0.08);
        color: var(--accent-green);
    }

    /* ============================================================
    CERTIFICATE CARDS - Brand Colors
    ============================================================ */
    .cert-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid rgba(212, 175, 55, 0.1);
    }

    .cert-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(45, 111, 183, 0.08);
        border-color: var(--gold);
    }

    .cert-card .icon {
        font-size: 3rem;
        color: var(--gold);
        margin-bottom: 0.5rem;
    }

    .cert-card .icon i {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ============================================================
    STATS GRID - Brand Colors
    ============================================================ */
    .stats-grid .stat-box {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .stats-grid .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(45, 111, 183, 0.08);
    }

    .stats-grid .stat-box .number {
        font-size: 2.5rem;
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        background: var(--brand-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-grid .stat-box .label {
        color: var(--gray);
        font-weight: 500;
        margin-top: 0.25rem;
    }

    .stats-grid .stat-box .icon {
        font-size: 2rem;
        color: var(--gold);
        margin-bottom: 0.5rem;
    }

    /* ============================================================
    TEAM SECTION - Brand Colors
    ============================================================ */
    .team-section {
        background: var(--white);
        padding: 4rem 0;
    }

    .team-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.4s ease;
        height: 100%;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(45, 111, 183, 0.12);
        border-color: rgba(18, 169, 198, 0.15);
    }

    .team-card .image {
        height: 280px;
        overflow: hidden;
        position: relative;
    }

    .team-card .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .team-card:hover .image img {
        transform: scale(1.08);
    }

    .team-card .image .social {
        position: absolute;
        bottom: -70px;
        left: 0;
        right: 0;
        padding: 1rem;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        transition: bottom 0.4s ease;
        backdrop-filter: blur(10px);
    }

    .team-card:hover .image .social {
        bottom: 0;
    }

    .team-card .image .social a {
        color: white;
        background: rgba(255,255,255,0.15);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .team-card .image .social a:hover {
        background: var(--gold);
        transform: scale(1.15);
        border-color: var(--gold);
        box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
    }

    .team-card .image .featured-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--gold);
        color: white;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        z-index: 2;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .team-card .image .department-badge {
        position: absolute;
        bottom: 70px;
        left: 1rem;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(10px);
        color: white;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
        z-index: 2;
    }

    .team-card:hover .image .department-badge {
        background: var(--brand-gradient);
        border-color: rgba(255,255,255,0.2);
    }

    .team-card .info {
        padding: 1.5rem;
        text-align: center;
    }

    .team-card .info h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .team-card .info .position {
        color: var(--secondary-turquoise);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .team-card .info .bio {
        color: var(--gray);
        font-size: 0.9rem;
        margin-top: 0.5rem;
        line-height: 1.6;
    }

    .team-card .info .contact {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid #F3F4F6;
    }

    .team-card .info .contact a {
        color: #9CA3AF;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
    }

    .team-card .info .contact a:hover {
        color: var(--primary-blue);
        background: rgba(45, 111, 183, 0.08);
        border-color: rgba(45, 111, 183, 0.15);
        transform: scale(1.1);
    }

    .team-card .info .contact a.email:hover {
        color: #EA4335;
        background: rgba(234, 67, 53, 0.08);
        border-color: rgba(234, 67, 53, 0.15);
    }

    .team-card .info .contact a.phone:hover {
        color: #34A853;
        background: rgba(52, 168, 83, 0.08);
        border-color: rgba(52, 168, 83, 0.15);
    }

    .team-card .info .contact a.linkedin:hover {
        color: #0A66C2;
        background: rgba(10, 102, 194, 0.08);
        border-color: rgba(10, 102, 194, 0.15);
    }

    /* ============================================================
    CTA SECTION - Brand Colors
    ============================================================ */
    .cta-about {
        background: var(--brand-gradient);
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }

    .cta-about::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .cta-about .cta-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .cta-about .cta-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 1rem;
    }

    .cta-about .cta-content p {
        color: rgba(255,255,255,0.9);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .cta-about .cta-content .btn-white {
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

    .cta-about .cta-content .btn-white:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .cta-about .cta-content .btn-green {
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

    .cta-about .cta-content .btn-green:hover {
        background: #4CAF50;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(108, 192, 74, 0.4);
        color: white;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .about-hero h1 { font-size: 2.5rem; }
        .about-hero p { font-size: 1rem; }
        .cta-about .cta-content h2 { font-size: 1.8rem; }
        .timeline-item .year { font-size: 1.5rem; }
        .stats-grid .stat-box .number { font-size: 1.8rem; }
        .team-card .image { height: 240px; }
        .team-card .info h3 { font-size: 1rem; }
        .team-card .info .position { font-size: 0.8rem; }
    }

    @media (max-width: 480px) {
        .about-hero h1 { font-size: 2rem; }
        .about-hero { padding: 100px 0 60px; }
        .value-card { padding: 1.5rem; }
        .team-card .image { height: 200px; }
        .team-card .image .department-badge { display: none; }
        .team-card .info { padding: 1rem; }
        .team-card .info .bio { font-size: 0.8rem; }
    }

    /* Section title override */
    .section-title .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-title .highlight-blue {
        background: var(--brand-gradient);
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

    /* Empty state for team */
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
</style>

<!-- ========================================== -->
<!-- ABOUT HERO - REBRANDED -->
<!-- ========================================== -->
<section class="about-hero">
    <div class="hero-particles">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-info-circle"></i>About Us
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            About <span class="highlight">Ethio Areb</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Your trusted partner in overseas recruitment and manpower solutions
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- COMPANY STORY - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <span class="section-badge">Our Story</span>
                <h2 class="section-title mt-2">Company <span class="highlight">Overview</span></h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p><?php echo htmlspecialchars($companyInfo['business_description'] ?? 'Ethio Areb Foreign Employment Agent Plc is a human resource outsourcing and manpower recruitment agency that partners with global clients to provide them with best talents from Ethiopia.'); ?></p>
                    <p>We are a dedicated team of professional consultants offering top of the line executive search and selection services to diverse corporate of all sizes; with varied business interests. We have been competing with all of the leading service providers in the field and have succeeded to be a pioneer in the field of Human Resource Recruitment.</p>
                    <p>We meet the entire staffing needs of the clients without complexities and formalities. We have track record of recruiting thousands of management professionals, technical and non-technical personnel, skilled, semi-skilled and unskilled workers for clients in the Gulf and other Middle Eastern countries.</p>
                    <p class="font-semibold text-lg" style="color: var(--primary-blue);">Our professionals specialize in identifying <span style="color: var(--gold);">Right People for the Right Job</span>.</p>
                </div>
                <div class="flex flex-wrap gap-4 mt-6">
                    <a href="<?php echo SITE_URL; ?>services" class="btn-primary">
                        <i class="fas fa-briefcase mr-2"></i>Our Services
                    </a>
                    <a href="<?php echo SITE_URL; ?>contact" class="btn-outline">
                        <i class="fas fa-phone mr-2"></i>Contact Us
                    </a>
                </div>
            </div>
            <div data-aos="fade-left">
                <div class="stats-grid grid grid-cols-2 gap-4">
                    <div class="stat-box">
                        <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                        <div class="number"><?php echo htmlspecialchars($companyInfo['year_established'] ?? '2021'); ?></div>
                        <div class="label">Year Established</div>
                    </div>
                    <div class="stat-box">
                        <div class="icon"><i class="fas fa-briefcase"></i></div>
                        <div class="number"><?php echo $stats['services'] ?? 0; ?></div>
                        <div class="label">Services Offered</div>
                    </div>
                    <div class="stat-box">
                        <div class="icon"><i class="fas fa-user-check"></i></div>
                        <div class="number">5000+</div>
                        <div class="label">Candidates Placed</div>
                    </div>
                    <div class="stat-box">
                        <div class="icon"><i class="fas fa-globe-africa"></i></div>
                        <div class="number">15+</div>
                        <div class="label">Countries Served</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- MISSION, VISION, VALUES - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge">Our Foundation</span>
            <h2 class="section-title">Mission, Vision &amp; <span class="highlight">Values</span></h2>
            <p class="section-subtitle">Guiding principles that drive us to deliver excellence in recruitment services</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <!-- Mission -->
            <div class="value-card" data-aos="fade-up">
                <div class="icon"><i class="fas fa-bullseye"></i></div>
                <h3 class="text-xl font-bold text-dark-slate mb-3 font-poppins">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed"><?php echo htmlspecialchars($companyInfo['mission'] ?? 'Our team of professionals is entirely devoted in the mission to provide globally competitive manpower resources to the clients so that they can acquire gifted work force that will benefit their organization in every way possible.'); ?></p>
                <p class="text-gray-600 leading-relaxed mt-3">We work in synergy with the clients to understand manpower requirements and procure best candidates with desired profiles.</p>
            </div>

            <!-- Vision -->
            <div class="value-card" data-aos="fade-up" data-aos-delay="100">
                <div class="icon turquoise"><i class="fas fa-eye"></i></div>
                <h3 class="text-xl font-bold text-dark-slate mb-3 font-poppins">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed"><?php echo htmlspecialchars($companyInfo['vision'] ?? 'The principal vision of our organization is to fulfill the need of our clients of getting Right People for the Right Job.'); ?></p>
                <p class="text-gray-600 leading-relaxed mt-3">Our goal is to further enhance our global presence and to build on our existing strength as a leading overseas recruitment services.</p>
            </div>

            <!-- Core Values -->
            <div class="value-card" data-aos="fade-up" data-aos-delay="200">
                <div class="icon green"><i class="fas fa-handshake"></i></div>
                <h3 class="text-xl font-bold text-dark-slate mb-3 font-poppins">Core Values</h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle" style="color: var(--gold); margin-top: 3px; margin-right: 10px;"></i>
                        <span>To provide genuine services maintaining trust</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle" style="color: var(--gold); margin-top: 3px; margin-right: 10px;"></i>
                        <span>Globally competitive manpower for a cohesive society</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle" style="color: var(--gold); margin-top: 3px; margin-right: 10px;"></i>
                        <span>Opportunity for Ethiopians to work abroad</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle" style="color: var(--gold); margin-top: 3px; margin-right: 10px;"></i>
                        <span>Help Ethiopian government in reducing employment crisis</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle" style="color: var(--gold); margin-top: 3px; margin-right: 10px;"></i>
                        <span>Fulfill employer requirements with honest, competent manpower</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- TIMELINE - REBRANDED -->
<!-- ========================================== -->
<?php if (!empty($timeline)): ?>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge">Our Journey</span>
            <h2 class="section-title">Company <span class="highlight">Timeline</span></h2>
            <p class="section-subtitle">Key milestones in our journey of excellence</p>
        </div>

        <div class="max-w-3xl mx-auto mt-12">
            <?php foreach ($timeline as $index => $item): ?>
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 50; ?>">
                <div class="bg-[#F8FAFC] p-6 rounded-2xl">
                    <span class="year"><?php echo htmlspecialchars($item['year']); ?></span>
                    <h4 class="text-xl font-bold text-dark-slate mt-1 font-poppins"><?php echo htmlspecialchars($item['title']); ?></h4>
                    <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($item['description']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========================================== -->
<!-- CERTIFICATES & AWARDS - REBRANDED -->
<!-- ========================================== -->
<?php if ($certificates && $certificates->num_rows > 0): ?>
<section class="py-20 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge">Recognition</span>
            <h2 class="section-title">Certificates &amp; <span class="highlight">Awards</span></h2>
            <p class="section-subtitle">Our achievements and recognitions in the industry</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-12">
            <?php while ($cert = $certificates->fetch_assoc()): ?>
            <div class="cert-card" data-aos="fade-up">
                <div class="icon">
                    <i class="fas fa-<?php echo $cert['type'] == 'certificate' ? 'certificate' : ($cert['type'] == 'award' ? 'trophy' : 'license'); ?>"></i>
                </div>
                <h4 class="font-bold text-dark-slate"><?php echo htmlspecialchars($cert['title']); ?></h4>
                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($cert['issuer'] ?? ''); ?></p>
                <?php if (!empty($cert['issue_date'])): ?>
                <p class="text-xs text-gray-400 mt-1">Issued: <?php echo date('M Y', strtotime($cert['issue_date'])); ?></p>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ========================================== -->
<!-- TEAM SECTION - NEWLY ADDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge">Our People</span>
            <h2 class="section-title">Meet Our <span class="highlight">Team</span></h2>
            <p class="section-subtitle">Dedicated professionals committed to finding the right people for the right job</p>
        </div>

        <?php if (!empty($team)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
            <?php foreach ($team as $member): ?>
            <div class="team-card" data-aos="fade-up">
                <div class="image">
                    <?php if (!empty($member['photo'])): ?>
                    <img src="<?php echo UPLOAD_URL . 'team/' . $member['photo']; ?>" alt="<?php echo $member['full_name']; ?>">
                    <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-[#2D6FB7]/20 to-[#12A9C6]/20 flex items-center justify-center">
                        <i class="fas fa-user text-6xl text-gray-300"></i>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($member['is_featured'])): ?>
                    <span class="featured-badge"><i class="fas fa-star"></i> Featured</span>
                    <?php endif; ?>
                    <?php if (!empty($member['department'])): ?>
                    <span class="department-badge"><?php echo $member['department']; ?></span>
                    <?php endif; ?>
                    <div class="social">
                        <?php if (!empty($member['linkedin_url'])): ?>
                        <a href="<?php echo $member['linkedin_url']; ?>" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($member['email'])): ?>
                        <a href="mailto:<?php echo $member['email']; ?>" title="Email"><i class="fas fa-envelope"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($member['phone'])): ?>
                        <a href="tel:<?php echo $member['phone']; ?>" title="Phone"><i class="fas fa-phone"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($member['facebook_url'])): ?>
                        <a href="<?php echo $member['facebook_url']; ?>" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($member['twitter_url'])): ?>
                        <a href="<?php echo $member['twitter_url']; ?>" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($member['instagram_url'])): ?>
                        <a href="<?php echo $member['instagram_url']; ?>" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="info">
                    <h3><?php echo $member['full_name']; ?></h3>
                    <p class="position"><?php echo $member['position']; ?></p>
                    <?php if (!empty($member['short_bio'])): ?>
                    <p class="bio"><?php echo $member['short_bio']; ?></p>
                    <?php endif; ?>
                    <div class="contact">
                        <?php if (!empty($member['email'])): ?>
                        <a href="mailto:<?php echo $member['email']; ?>" class="email" title="Email"><i class="fas fa-envelope"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($member['phone'])): ?>
                        <a href="tel:<?php echo $member['phone']; ?>" class="phone" title="Phone"><i class="fas fa-phone"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($member['linkedin_url'])): ?>
                        <a href="<?php echo $member['linkedin_url']; ?>" class="linkedin" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <div class="icon"><i class="fas fa-users"></i></div>
            <h3>No Team Members Found</h3>
            <p>We're currently building our team. Check back later to meet our professionals.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================== -->
<!-- CTA SECTION - REBRANDED -->
<!-- ========================================== -->
<section class="cta-about">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="cta-content" data-aos="fade-up">
            <h2>Ready to Work With Us?</h2>
            <p>Contact us today to discuss your manpower requirements and find the right people for the right job.</p>
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