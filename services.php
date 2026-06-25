<?php
// services.php - Complete Rebranded Services Listing Page
require_once 'config/db_config.php';
$conn = getDB();

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
$services = getServices(null, $category_id);
$categories = getServiceCategories();

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
    SERVICES HERO - Brand Colors
    ============================================================ */
    .services-hero {
        background: var(--brand-gradient);
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
    }

    .services-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .services-hero .hero-badge {
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

    .services-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .services-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .services-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .services-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    FILTER BUTTONS - Brand Colors
    ============================================================ */
    .service-filter-btn {
        padding: 10px 24px;
        border-radius: 50px;
        background: #f3f4f6;
        color: #4B5563;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-block;
    }

    .service-filter-btn:hover {
        background: rgba(45, 111, 183, 0.1);
        color: var(--primary-blue);
    }

    .service-filter-btn.active {
        background: var(--brand-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(45, 111, 183, 0.3);
    }

    /* ============================================================
    SERVICE CARDS - Brand Colors
    ============================================================ */
    .service-detail-card {
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

    .service-detail-card::before {
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

    .service-detail-card:hover::before {
        opacity: 1;
    }

    .service-detail-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(45, 111, 183, 0.12);
        border-color: rgba(18, 169, 198, 0.15);
    }

    .service-detail-card .icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(45, 111, 183, 0.08), rgba(18, 169, 198, 0.08));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--primary-blue);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .service-detail-card:hover .icon {
        background: var(--brand-gradient);
        color: white;
        transform: scale(1.05);
    }

    .service-detail-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
        margin-bottom: 0.5rem;
    }

    .service-detail-card .description {
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .service-detail-card .feature-list {
        list-style: none;
        padding: 0;
        margin-bottom: 1rem;
    }

    .service-detail-card .feature-list li {
        padding: 4px 0;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #4B5563;
    }

    .service-detail-card .feature-list li i {
        color: var(--gold);
        font-size: 0.7rem;
    }

    .service-detail-card .learn-more {
        color: var(--primary-blue);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .service-detail-card .learn-more:hover {
        color: var(--secondary-turquoise);
        gap: 12px;
    }

    .service-detail-card .price-tag {
        display: inline-block;
        background: rgba(108, 192, 74, 0.1);
        color: var(--accent-green);
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    /* ============================================================
    WHY CHOOSE US - Brand Colors
    ============================================================ */
    .why-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.4s ease;
        height: 100%;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .why-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(45, 111, 183, 0.1);
    }

    .why-card .icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 28px;
        transition: all 0.3s ease;
    }

    .why-card .icon-wrapper.blue {
        background: rgba(45, 111, 183, 0.1);
        color: var(--primary-blue);
    }

    .why-card .icon-wrapper.turquoise {
        background: rgba(18, 169, 198, 0.1);
        color: var(--secondary-turquoise);
    }

    .why-card .icon-wrapper.green {
        background: rgba(108, 192, 74, 0.1);
        color: var(--accent-green);
    }

    .why-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(-5deg);
    }

    .why-card h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
        margin-bottom: 0.5rem;
    }

    .why-card p {
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .services-hero h1 { font-size: 2.5rem; }
        .services-hero p { font-size: 1rem; }
        .service-filter-btn { padding: 6px 16px; font-size: 0.8rem; }
        .service-detail-card { padding: 1.5rem; }
        .why-card { padding: 1.5rem; }
    }

    @media (max-width: 480px) {
        .services-hero h1 { font-size: 2rem; }
        .services-hero { padding: 100px 0 60px; }
        .service-filter-btn { font-size: 0.7rem; padding: 4px 12px; }
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
</style>

<!-- ========================================== -->
<!-- SERVICES HERO - REBRANDED -->
<!-- ========================================== -->
<section class="services-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-briefcase"></i>Our Expertise
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            Our <span class="highlight">Services</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Comprehensive recruitment solutions across multiple industries to meet your manpower needs
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- SERVICES LISTING - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Categories Filter -->
        <div class="flex flex-wrap gap-3 justify-center mb-12" data-aos="fade-up">
            <a href="services" class="service-filter-btn <?php echo !$category_id ? 'active' : ''; ?>">All Services</a>
            <?php foreach ($categories as $cat): ?>
            <a href="?category=<?php echo $cat['id']; ?>" class="service-filter-btn <?php echo $category_id == $cat['id'] ? 'active' : ''; ?>">
                <?php echo $cat['name']; ?>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $service): ?>
            <div class="service-detail-card" data-aos="fade-up">
                <div class="icon">
                    <i class="fas fa-<?php echo $service['icon'] ?? 'briefcase'; ?>"></i>
                </div>
                <h3><?php echo $service['name']; ?></h3>
                <p class="description"><?php echo substr($service['description'] ?? '', 0, 120) . '...'; ?></p>

                <?php if (!empty($service['features'])): ?>
                <ul class="feature-list">
                    <?php 
                    $features = explode("\n", $service['features']);
                    foreach (array_slice($features, 0, 3) as $feature): 
                    ?>
                    <li><i class="fas fa-check-circle"></i> <?php echo trim($feature); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <?php if (!empty($service['price'])): ?>
                <span class="price-tag">$<?php echo number_format($service['price'], 0); ?> / <?php echo $service['price_period'] ?? 'one_time'; ?></span>
                <?php endif; ?>

                <a href="service-detail.php?slug=<?php echo $service['slug']; ?>" class="learn-more">
                    Learn More <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($services)): ?>
        <div class="text-center py-12">
            <i class="fas fa-briefcase text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">No services found in this category.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================== -->
<!-- WHY CHOOSE US - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge">Why Us</span>
            <h2 class="section-title">Why Choose <span class="highlight">Ethio Areb</span></h2>
            <p class="section-subtitle">We are committed to providing the best recruitment services with integrity and professionalism</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
            <div class="why-card" data-aos="fade-up">
                <div class="icon-wrapper blue">
                    <i class="fas fa-users"></i>
                </div>
                <h4>Expert Team</h4>
                <p>Professional consultants with years of experience in overseas recruitment and manpower solutions.</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="100">
                <div class="icon-wrapper turquoise">
                    <i class="fas fa-globe-africa"></i>
                </div>
                <h4>Global Reach</h4>
                <p>Serving clients in Gulf and Middle Eastern countries with quality candidates and reliable service.</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-wrapper green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4>Quality Assurance</h4>
                <p>Thorough screening and verification to ensure the best candidates for your organization.</p>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- STATS COUNTER - Rebranded -->
<!-- ========================================== -->
<section class="py-16" style="background: var(--brand-gradient);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center text-white" data-aos="fade-up">
                <div class="text-4xl font-bold font-poppins text-[#D4AF37]">5000+</div>
                <div class="text-white/80 mt-1">Candidates Placed</div>
            </div>
            <div class="text-center text-white" data-aos="fade-up" data-aos-delay="100">
                <div class="text-4xl font-bold font-poppins text-[#D4AF37]">15+</div>
                <div class="text-white/80 mt-1">Countries Served</div>
            </div>
            <div class="text-center text-white" data-aos="fade-up" data-aos-delay="200">
                <div class="text-4xl font-bold font-poppins text-[#D4AF37]"><?php echo $stats['services'] * 10 ?? 50; ?>+</div>
                <div class="text-white/80 mt-1">Jobs Filled</div>
            </div>
            <div class="text-center text-white" data-aos="fade-up" data-aos-delay="300">
                <div class="text-4xl font-bold font-poppins text-[#D4AF37]"><?php echo $stats['team'] ?? 4; ?>+</div>
                <div class="text-white/80 mt-1">Team Members</div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>