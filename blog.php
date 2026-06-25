<?php
// blog.php - Complete Rebranded Blog Listing Page
require_once 'config/db_config.php';
$conn = getDB();

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
$posts = getBlogPosts(null, $category_id);
$categories = getBlogCategories();

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
    BLOG HERO - Brand Colors
    ============================================================ */
    .blog-hero {
        background: var(--brand-gradient);
        padding: 120px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .blog-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .blog-hero .hero-badge {
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

    .blog-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .blog-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .blog-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .blog-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    FILTER BUTTONS - Brand Colors
    ============================================================ */
    .filter-tag {
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

    .filter-tag:hover {
        background: rgba(45, 111, 183, 0.1);
        color: var(--primary-blue);
    }

    .filter-tag.active {
        background: var(--brand-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(45, 111, 183, 0.3);
    }

    /* ============================================================
    BLOG CARDS - Brand Colors
    ============================================================ */
    .blog-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(45, 111, 183, 0.12);
        border-color: rgba(18, 169, 198, 0.15);
    }

    .blog-card .image {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .blog-card .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .blog-card:hover .image img {
        transform: scale(1.08);
    }

    .blog-card .image .category-tag {
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
        box-shadow: 0 4px 15px rgba(45, 111, 183, 0.3);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .blog-card .image .featured-badge {
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
    }

    .blog-card .image .urgent-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #EF4444;
        color: white;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        animation: pulse-badge 2s infinite;
    }

    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .blog-card .body {
        padding: 1.5rem;
    }

    .blog-card .body .meta {
        font-size: 0.8rem;
        color: var(--gray);
        margin-bottom: 0.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
    }

    .blog-card .body .meta i {
        margin-right: 4px;
        color: var(--secondary-turquoise);
    }

    .blog-card .body .meta .separator {
        color: #D1D5DB;
    }

    .blog-card .body h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
        line-height: 1.4;
    }

    .blog-card:hover .body h3 {
        color: var(--primary-blue);
    }

    .blog-card .body .excerpt {
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0.75rem;
    }

    .blog-card .body .read-more {
        color: var(--primary-blue);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .blog-card .body .read-more:hover {
        color: var(--secondary-turquoise);
        gap: 12px;
    }

    .blog-card .body .author-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid #F3F4F6;
    }

    .blog-card .body .author-info .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--brand-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
    }

    .blog-card .body .author-info .name {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--dark);
    }

    /* ============================================================
    PAGINATION - Brand Colors
    ============================================================ */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 3rem;
    }

    .pagination a,
    .pagination span {
        padding: 10px 16px;
        border-radius: 8px;
        background: #f3f4f6;
        color: #4B5563;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        min-width: 44px;
        text-align: center;
    }

    .pagination a:hover {
        background: rgba(45, 111, 183, 0.1);
        color: var(--primary-blue);
    }

    .pagination .active {
        background: var(--brand-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(45, 111, 183, 0.3);
    }

    .pagination .active:hover {
        background: var(--brand-gradient);
        color: white;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .blog-hero h1 { font-size: 2.5rem; }
        .blog-hero p { font-size: 1rem; }
        .filter-tag { padding: 6px 16px; font-size: 0.8rem; }
        .blog-card .image { height: 180px; }
        .blog-card .body h3 { font-size: 1rem; }
        .blog-card .body .meta { font-size: 0.7rem; }
    }

    @media (max-width: 480px) {
        .blog-hero h1 { font-size: 2rem; }
        .blog-hero { padding: 100px 0 40px; }
        .blog-card .image { height: 160px; }
        .blog-card .body { padding: 1rem; }
        .blog-card .body .meta .separator { display: none; }
        .blog-card .body .meta { gap: 0.25rem; }
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

    .empty-state .btn {
        margin-top: 1.5rem;
        display: inline-block;
        padding: 10px 30px;
        background: var(--brand-gradient);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(45, 111, 183, 0.3);
    }

    .empty-state .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(45, 111, 183, 0.4);
    }
</style>

<!-- ========================================== -->
<!-- BLOG HERO - REBRANDED -->
<!-- ========================================== -->
<section class="blog-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-newspaper"></i>Stay Updated
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            Blog &amp; <span class="highlight">News</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Stay updated with the latest news and insights from Ethio Areb
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- BLOG LISTING - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Categories -->
        <div class="flex flex-wrap gap-3 justify-center mb-12" data-aos="fade-up">
            <a href="blog" class="filter-tag <?php echo !$category_id ? 'active' : ''; ?>">All Posts</a>
            <?php foreach ($categories as $cat): ?>
            <a href="?category=<?php echo $cat['id']; ?>" class="filter-tag <?php echo $category_id == $cat['id'] ? 'active' : ''; ?>">
                <?php echo $cat['name']; ?>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($posts as $post): ?>
            <div class="blog-card" data-aos="fade-up">
                <div class="image">
                    <?php if (!empty($post['featured_image'])): ?>
                    <img src="<?php echo UPLOAD_URL . 'blog/' . $post['featured_image']; ?>" alt="<?php echo $post['title']; ?>">
                    <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-[#2D6FB7]/10 to-[#12A9C6]/10 flex items-center justify-center">
                        <i class="fas fa-newspaper text-4xl text-gray-300"></i>
                    </div>
                    <?php endif; ?>
                    <span class="category-tag"><?php echo $post['category_name'] ?? 'General'; ?></span>
                    <?php if (!empty($post['is_featured'])): ?>
                    <span class="featured-badge"><i class="fas fa-star"></i> Featured</span>
                    <?php endif; ?>
                    <?php if (!empty($post['is_urgent'])): ?>
                    <span class="urgent-badge"><i class="fas fa-bolt"></i> Urgent</span>
                    <?php endif; ?>
                </div>
                <div class="body">
                    <div class="meta">
                        <span><i class="far fa-calendar-alt"></i> <?php echo date('M d, Y', strtotime($post['published_at'] ?? $post['created_at'])); ?></span>
                        <span class="separator">|</span>
                        <span><i class="far fa-eye"></i> <?php echo $post['views'] ?? 0; ?></span>
                        <span class="separator">|</span>
                        <span><i class="far fa-comment"></i> <?php echo $post['comments_count'] ?? 0; ?></span>
                    </div>
                    <h3><?php echo $post['title']; ?></h3>
                    <p class="excerpt"><?php echo substr($post['excerpt'] ?? $post['content'] ?? '', 0, 120) . '...'; ?></p>
                    <a href="blog-detail.php?slug=<?php echo $post['slug']; ?>" class="read-more">
                        Read More <i class="fas fa-arrow-right"></i>
                    </a>
                    <?php if (!empty($post['author_name'])): ?>
                    <div class="author-info">
                        <div class="avatar"><?php echo substr($post['author_name'], 0, 1); ?></div>
                        <span class="name"><?php echo $post['author_name']; ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($posts)): ?>
        <div class="empty-state">
            <div class="icon"><i class="fas fa-newspaper"></i></div>
            <h3>No Posts Found</h3>
            <p>We couldn't find any blog posts in this category. Check back later for updates.</p>
            <a href="blog" class="btn">View All Posts</a>
        </div>
        <?php endif; ?>

        <!-- Pagination (Optional - Add if you have many posts) -->
        <?php if (count($posts) > 9): ?>
        <div class="pagination">
            <a href="#"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <span>...</span>
            <a href="#">5</a>
            <a href="#"><i class="fas fa-chevron-right"></i></a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================== -->
<!-- NEWSLETTER CTA - BRANDED -->
<!-- ========================================== -->
<section class="py-16" style="background: var(--light-gray);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl p-8 md:p-12 shadow-sm border border-gray-100">
            <div class="text-center" data-aos="fade-up">
                <span class="section-badge">Newsletter</span>
                <h2 class="text-2xl md:text-3xl font-bold text-dark mb-2 font-poppins">
                    Subscribe to Our <span class="highlight">Newsletter</span>
                </h2>
                <p class="text-gray-600 max-w-lg mx-auto mb-6">
                    Get the latest updates on recruitment opportunities, industry news, and career tips.
                </p>
                <form class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                    <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-[#2D6FB7] focus:ring-2 focus:ring-[#2D6FB7]/20 transition">
                    <button type="submit" class="px-8 py-3 rounded-xl font-semibold text-white" style="background: var(--brand-gradient); box-shadow: 0 4px 15px rgba(45, 111, 183, 0.3); transition: all 0.3s ease;">
                        Subscribe
                    </button>
                </form>
                <p class="text-xs text-gray-400 mt-3">No spam, unsubscribe anytime.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>