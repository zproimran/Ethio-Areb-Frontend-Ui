<?php
// faqs.php - Complete Rebranded Frequently Asked Questions
require_once 'config/db_config.php';
$conn = getDB();

$faqs = getFAQs();
$categories = $conn->query("SELECT * FROM faq_categories WHERE is_active = 1 ORDER BY order_no ASC");

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
    FAQS HERO - Brand Colors
    ============================================================ */
    .faqs-hero {
        background: var(--brand-gradient);
        padding: 120px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .faqs-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .faqs-hero .hero-badge {
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

    .faqs-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .faqs-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .faqs-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .faqs-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    CATEGORY TABS - Brand Colors
    ============================================================ */
    .category-tab {
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

    .category-tab:hover {
        background: rgba(45, 111, 183, 0.1);
        color: var(--primary-blue);
    }

    .category-tab.active {
        background: var(--brand-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(45, 111, 183, 0.3);
    }

    /* ============================================================
    FAQ ITEMS - Brand Colors
    ============================================================ */
    .faq-item {
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .faq-item:hover {
        border-color: var(--secondary-turquoise);
        box-shadow: 0 4px 20px rgba(45, 111, 183, 0.06);
    }

    .faq-item .question {
        padding: 1.25rem 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--dark);
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        gap: 1rem;
    }

    .faq-item .question:hover {
        background: var(--light-gray);
    }

    .faq-item .question .question-text {
        flex: 1;
    }

    .faq-item .question .icon {
        transition: transform 0.3s ease;
        color: var(--secondary-turquoise);
        font-size: 1.2rem;
        flex-shrink: 0;
        width: 24px;
        text-align: center;
    }

    .faq-item .question .icon.rotated {
        transform: rotate(180deg);
    }

    .faq-item .question .category-badge {
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 2px 12px;
        border-radius: 50px;
        background: rgba(18, 169, 198, 0.1);
        color: var(--secondary-turquoise);
        flex-shrink: 0;
        border: 1px solid rgba(18, 169, 198, 0.1);
    }

    .faq-item .answer {
        padding: 0 1.5rem 1.5rem;
        color: var(--gray);
        line-height: 1.8;
        display: none;
        font-size: 0.95rem;
    }

    .faq-item .answer.open {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ============================================================
    FAQ STATS - Brand Colors
    ============================================================ */
    .faq-stats {
        background: var(--light-gray);
        padding: 3rem 0;
    }

    .faq-stats .stat-item {
        text-align: center;
        padding: 1.5rem;
    }

    .faq-stats .stat-item .number {
        font-size: 2.5rem;
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        background: var(--brand-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .faq-stats .stat-item .label {
        color: var(--gray);
        font-weight: 500;
        margin-top: 0.25rem;
    }

    /* ============================================================
    CTA CARD - Brand Colors
    ============================================================ */
    .cta-card {
        text-align: center;
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .cta-card:hover {
        box-shadow: 0 15px 50px rgba(45, 111, 183, 0.08);
        border-color: rgba(18, 169, 198, 0.15);
        transform: translateY(-3px);
    }

    .cta-card .icon {
        font-size: 3rem;
        color: var(--secondary-turquoise);
        margin-bottom: 1rem;
    }

    .cta-card h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .cta-card p {
        color: var(--gray);
        max-width: 400px;
        margin: 0 auto 1.5rem;
    }

    .cta-card .btn-gradient {
        background: var(--brand-gradient);
        color: white;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(45, 111, 183, 0.3);
    }

    .cta-card .btn-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(45, 111, 183, 0.4);
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .faqs-hero h1 { font-size: 2.5rem; }
        .faqs-hero p { font-size: 1rem; }
        .category-tab { padding: 6px 16px; font-size: 0.8rem; }
        .faq-item .question { padding: 1rem; font-size: 0.9rem; }
        .faq-item .answer { padding: 0 1rem 1rem; font-size: 0.9rem; }
        .faq-item .question .category-badge { display: none; }
        .cta-card { padding: 1.5rem; }
        .faq-stats .stat-item .number { font-size: 2rem; }
    }

    @media (max-width: 480px) {
        .faqs-hero h1 { font-size: 2rem; }
        .faqs-hero { padding: 100px 0 40px; }
        .faq-item .question { font-size: 0.85rem; padding: 0.75rem 1rem; }
        .faq-item .answer { font-size: 0.85rem; padding: 0 1rem 1rem; }
        .category-tab { font-size: 0.7rem; padding: 4px 12px; }
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
<!-- FAQS HERO - REBRANDED -->
<!-- ========================================== -->
<section class="faqs-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-question-circle"></i>Got Questions?
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            Frequently Asked <span class="highlight">Questions</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Find answers to commonly asked questions about our services
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- FAQ STATS - REBRANDED -->
<!-- ========================================== -->
<section class="faq-stats">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-item" data-aos="fade-up">
                <div class="number"><?php echo count($faqs); ?></div>
                <div class="label">FAQs Available</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <div class="number"><?php echo $categories ? $categories->num_rows : 0; ?></div>
                <div class="label">Categories</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <div class="number">100%</div>
                <div class="label">Answered</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <div class="number">24/7</div>
                <div class="label">Available</div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- FAQS SECTION - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Categories -->
        <div class="flex flex-wrap gap-3 justify-center mb-12" data-aos="fade-up">
            <button class="category-tab active" data-category="all">All Questions</button>
            <?php if ($categories): ?>
            <?php $categories->data_seek(0); ?>
            <?php while ($cat = $categories->fetch_assoc()): ?>
            <button class="category-tab" data-category="<?php echo $cat['id']; ?>">
                <?php echo $cat['name']; ?>
            </button>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <!-- FAQs -->
        <div class="space-y-4">
            <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 50; ?>" data-category="<?php echo $faq['category_id'] ?? 'all'; ?>">
                <div class="question" onclick="toggleFAQ(this)">
                    <span class="question-text"><?php echo $faq['question']; ?></span>
                    <?php if (!empty($faq['category_id'])): ?>
                    <?php 
                    $catName = '';
                    if ($categories) {
                        $categories->data_seek(0);
                        while ($cat = $categories->fetch_assoc()) {
                            if ($cat['id'] == $faq['category_id']) {
                                $catName = $cat['name'];
                                break;
                            }
                        }
                    }
                    ?>
                    <?php if ($catName): ?>
                    <span class="category-badge"><?php echo $catName; ?></span>
                    <?php endif; ?>
                    <?php endif; ?>
                    <i class="fas fa-chevron-down icon"></i>
                </div>
                <div class="answer">
                    <?php echo nl2br($faq['answer']); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($faqs)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fas fa-question-circle"></i></div>
            <h3>No FAQs Found</h3>
            <p>We're currently building our FAQ section. Check back soon for answers to common questions.</p>
        </div>
        <?php endif; ?>

        <!-- Still Have Questions -->
        <div class="mt-12" data-aos="fade-up">
            <div class="cta-card">
                <div class="icon"><i class="fas fa-headset"></i></div>
                <h3>Still Have Questions?</h3>
                <p>Can't find what you're looking for? Contact us and we'll help you with your questions.</p>
                <a href="<?php echo SITE_URL; ?>contact" class="btn-gradient">
                    <i class="fas fa-envelope mr-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const icon = element.querySelector('.icon');
    
    // Close other FAQs
    document.querySelectorAll('.faq-item .answer').forEach(a => {
        if (a !== answer) {
            a.classList.remove('open');
            a.previousElementSibling.querySelector('.icon').classList.remove('rotated');
        }
    });
    
    // Toggle current
    answer.classList.toggle('open');
    icon.classList.toggle('rotated');
}

// Category filter
document.querySelectorAll('.category-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Update active tab
        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const category = this.dataset.category;
        document.querySelectorAll('.faq-item').forEach(item => {
            const itemCategory = item.dataset.category || 'all';
            if (category === 'all' || itemCategory == category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});

// Open first FAQ by default
document.addEventListener('DOMContentLoaded', function() {
    const firstFaq = document.querySelector('.faq-item');
    if (firstFaq) {
        const question = firstFaq.querySelector('.question');
        if (question) {
            toggleFAQ(question);
        }
    }
});
</script>

<?php include 'footer.php'; ?>