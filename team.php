<?php
// team.php - Complete Rebranded Team Members Page
require_once 'config/db_config.php';
$conn = getDB();

$team = getTeamMembers();

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
    TEAM HERO - Brand Colors
    ============================================================ */
    .team-hero {
        background: var(--brand-gradient);
        padding: 120px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .team-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .team-hero .hero-badge {
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

    .team-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .team-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .team-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .team-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    TEAM CARDS - Brand Colors
    ============================================================ */
    .team-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(45, 111, 183, 0.12);
        border-color: rgba(18, 169, 198, 0.15);
    }

    .team-card .image {
        height: 300px;
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

    .team-card .info .position .gold {
        color: var(--gold);
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
    TEAM STATS - Brand Colors
    ============================================================ */
    .team-stats {
        background: var(--light-gray);
        padding: 3rem 0;
    }

    .team-stats .stat-item {
        text-align: center;
        padding: 1.5rem;
    }

    .team-stats .stat-item .number {
        font-size: 2.5rem;
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        background: var(--brand-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .team-stats .stat-item .label {
        color: var(--gray);
        font-weight: 500;
        margin-top: 0.25rem;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .team-hero h1 { font-size: 2.5rem; }
        .team-hero p { font-size: 1rem; }
        .team-card .image { height: 240px; }
        .team-card .info h3 { font-size: 1rem; }
        .team-card .info .position { font-size: 0.8rem; }
        .team-stats .stat-item .number { font-size: 2rem; }
    }

    @media (max-width: 480px) {
        .team-hero h1 { font-size: 2rem; }
        .team-hero { padding: 100px 0 40px; }
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
</style>

<!-- ========================================== -->
<!-- TEAM HERO - REBRANDED -->
<!-- ========================================== -->
<section class="team-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-users"></i>Our People
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            Our <span class="highlight">Team</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Meet our dedicated professionals committed to your success
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- TEAM STATS - REBRANDED -->
<!-- ========================================== -->
<section class="team-stats">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-item" data-aos="fade-up">
                <div class="number"><?php echo count($team); ?>+</div>
                <div class="label">Team Members</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <div class="number">10+</div>
                <div class="label">Years Combined Experience</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <div class="number">5+</div>
                <div class="label">Countries Covered</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <div class="number">100%</div>
                <div class="label">Client Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- TEAM MEMBERS - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="section-badge">Meet the Team</span>
            <h2 class="section-title">Our <span class="highlight">Professionals</span></h2>
            <p class="section-subtitle">Dedicated experts committed to finding the right people for the right job</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($team as $member): ?>
            <div class="team-card" data-aos="fade-up">
                <div class="image">
                    <?php if (!empty($member['photo'])): ?>
                    <img src="<?php echo UPLOAD_URL . 'team/' . $member['photo']; ?>" alt="<?php echo $member['full_name']; ?>">
                    <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-[#2D6FB7]/10 to-[#12A9C6]/10 flex items-center justify-center">
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

        <?php if (empty($team)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fas fa-users"></i></div>
            <h3>No Team Members Found</h3>
            <p>We're currently building our team. Check back later to meet our professionals.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================== -->
<!-- JOIN OUR TEAM CTA - BRANDED -->
<!-- ========================================== -->
<section class="py-16" style="background: var(--brand-gradient);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <div class="relative z-10" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 font-poppins">Join Our <span style="color: var(--gold);">Team</span></h2>
            <p class="text-white/90 text-lg max-w-2xl mx-auto mb-8">
                We're always looking for talented professionals to join our team. If you're passionate about recruitment and helping people find their dream jobs, we'd love to hear from you.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="<?php echo SITE_URL; ?>contact" class="bg-white text-[#2D6FB7] px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition shadow-lg hover:shadow-xl inline-flex items-center">
                    <i class="fas fa-envelope mr-2"></i>Get in Touch
                </a>
                <a href="<?php echo SITE_URL; ?>apply" class="bg-[#6CC04A] text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-[#4CAF50] transition shadow-lg hover:shadow-xl inline-flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i>Apply Now
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>