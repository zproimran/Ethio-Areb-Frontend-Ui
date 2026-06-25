<?php
// gallery.php - Complete Rebranded Gallery Page
require_once 'config/db_config.php';
$conn = getDB();

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
$items = getGalleryItems($category_id);
$categories = getGalleryCategories();

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
    GALLERY HERO - Brand Colors
    ============================================================ */
    .gallery-hero {
        background: var(--brand-gradient);
        padding: 120px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .gallery-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .gallery-hero .hero-badge {
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

    .gallery-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .gallery-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .gallery-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .gallery-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    FILTER BUTTONS - Brand Colors
    ============================================================ */
    .filter-btn {
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

    .filter-btn:hover {
        background: rgba(45, 111, 183, 0.1);
        color: var(--primary-blue);
    }

    .filter-btn.active {
        background: var(--brand-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(45, 111, 183, 0.3);
    }

    /* ============================================================
    GALLERY ITEMS - Brand Colors
    ============================================================ */
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    .gallery-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .gallery-item video {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .gallery-item:hover img,
    .gallery-item:hover video {
        transform: scale(1.08);
    }

    .gallery-item .overlay {
        position: absolute;
        inset: 0;
        background: var(--brand-gradient);
        opacity: 0;
        transition: all 0.4s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        padding: 1.5rem;
    }

    .gallery-item:hover .overlay {
        opacity: 0.92;
    }

    .gallery-item .overlay i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: var(--gold);
        transform: scale(0.8);
        transition: transform 0.4s ease;
    }

    .gallery-item:hover .overlay i {
        transform: scale(1);
    }

    .gallery-item .overlay h4 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        text-align: center;
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
        transform: translateY(10px);
        opacity: 0;
        transition: all 0.4s ease;
    }

    .gallery-item:hover .overlay h4 {
        transform: translateY(0);
        opacity: 1;
    }

    .gallery-item .overlay p {
        font-size: 0.85rem;
        opacity: 0.8;
        text-align: center;
        transform: translateY(10px);
        opacity: 0;
        transition: all 0.4s ease 0.1s;
    }

    .gallery-item:hover .overlay p {
        transform: translateY(0);
        opacity: 0.8;
    }

    .gallery-item .category-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(10px);
        color: white;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.1);
        z-index: 2;
        transition: all 0.3s ease;
    }

    .gallery-item:hover .category-badge {
        background: rgba(212, 175, 55, 0.8);
        border-color: var(--gold);
    }

    /* ============================================================
    LIGHTBOX - Brand Colors
    ============================================================ */
    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .lightbox.open {
        display: flex;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 80vh;
        border-radius: 12px;
        object-fit: contain;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        animation: zoomIn 0.4s ease;
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .lightbox .close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 2.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .lightbox .close:hover {
        transform: rotate(90deg) scale(1.1);
        background: rgba(212, 175, 55, 0.3);
        border-color: var(--gold);
    }

    .lightbox .caption {
        color: white;
        text-align: center;
        margin-top: 1rem;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .lightbox .caption .category-name {
        color: var(--gold);
        font-size: 0.85rem;
        display: block;
        margin-top: 0.25rem;
        opacity: 0.7;
    }

    .lightbox .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 2.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .lightbox .nav-btn:hover {
        background: rgba(212, 175, 55, 0.3);
        border-color: var(--gold);
    }

    .lightbox .nav-btn.prev {
        left: 20px;
    }

    .lightbox .nav-btn.next {
        right: 20px;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .gallery-hero h1 { font-size: 2.5rem; }
        .gallery-hero p { font-size: 1rem; }
        .filter-btn { padding: 6px 16px; font-size: 0.8rem; }
        .gallery-item img, .gallery-item video { height: 180px; }
        .lightbox .nav-btn { display: none; }
    }

    @media (max-width: 480px) {
        .gallery-hero h1 { font-size: 2rem; }
        .gallery-hero { padding: 100px 0 40px; }
        .gallery-item img, .gallery-item video { height: 140px; }
        .gallery-item .overlay h4 { font-size: 0.9rem; }
        .gallery-item .overlay i { font-size: 1.8rem; }
    }

    /* Section title override */
    .section-title .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

<!-- ========================================== -->
<!-- GALLERY HERO - REBRANDED -->
<!-- ========================================== -->
<section class="gallery-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-images"></i>Visual Tour
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            Our <span class="highlight">Gallery</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Explore our work, events, and activities
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- GALLERY SECTION - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Categories Filter -->
        <div class="flex flex-wrap gap-3 justify-center mb-12" data-aos="fade-up">
            <a href="gallery" class="filter-btn <?php echo !$category_id ? 'active' : ''; ?>">All</a>
            <?php foreach ($categories as $cat): ?>
            <a href="?category=<?php echo $cat['id']; ?>" class="filter-btn <?php echo $category_id == $cat['id'] ? 'active' : ''; ?>">
                <?php echo $cat['name']; ?>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($items as $item): ?>
            <div class="gallery-item" data-aos="fade-up" onclick="openLightbox('<?php echo UPLOAD_URL . 'gallery/' . $item['image']; ?>', '<?php echo $item['title']; ?>', '<?php echo $item['category_name'] ?? ''; ?>')">
                <?php if ($item['type'] == 'video' && !empty($item['video_url'])): ?>
                <video src="<?php echo $item['video_url']; ?>" class="w-full h-64 object-cover" muted loop></video>
                <?php else: ?>
                <img src="<?php echo UPLOAD_URL . 'gallery/' . $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                <?php endif; ?>
                <?php if (!empty($item['category_name'])): ?>
                <span class="category-badge"><?php echo $item['category_name']; ?></span>
                <?php endif; ?>
                <div class="overlay">
                    <i class="fas fa-search-plus"></i>
                    <h4><?php echo $item['title']; ?></h4>
                    <p><?php echo $item['category_name'] ?? ''; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($items)): ?>
        <div class="text-center py-12">
            <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">No gallery items found.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================== -->
<!-- LIGHTBOX - REBRANDED -->
<!-- ========================================== -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <span class="close" onclick="closeLightbox()">&times;</span>
    <button class="nav-btn prev" onclick="event.stopPropagation(); navigateLightbox(-1);">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="nav-btn next" onclick="event.stopPropagation(); navigateLightbox(1);">
        <i class="fas fa-chevron-right"></i>
    </button>
    <img id="lightboxImage" src="" alt="">
    <div class="caption" id="lightboxCaption"></div>
</div>

<script>
// Lightbox functionality
let lightboxItems = [];
let currentIndex = 0;

<?php if (!empty($items)): ?>
lightboxItems = <?php echo json_encode(array_map(function($item) {
    return [
        'src' => UPLOAD_URL . 'gallery/' . $item['image'],
        'title' => $item['title'],
        'category' => $item['category_name'] ?? ''
    ];
}, $items)); ?>;
<?php endif; ?>

function openLightbox(src, title, category) {
    // Find the index of the clicked item
    currentIndex = lightboxItems.findIndex(item => item.src === src);
    if (currentIndex === -1) currentIndex = 0;
    
    updateLightboxContent();
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function updateLightboxContent() {
    const item = lightboxItems[currentIndex];
    if (item) {
        document.getElementById('lightboxImage').src = item.src;
        document.getElementById('lightboxCaption').innerHTML = `
            ${item.title || ''}
            <span class="category-name">${item.category || ''}</span>
        `;
    }
}

function navigateLightbox(direction) {
    if (lightboxItems.length === 0) return;
    
    currentIndex += direction;
    if (currentIndex < 0) currentIndex = lightboxItems.length - 1;
    if (currentIndex >= lightboxItems.length) currentIndex = 0;
    
    updateLightboxContent();
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = 'auto';
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    if (!lightbox.classList.contains('open')) return;
    
    if (e.key === 'Escape') {
        closeLightbox();
    } else if (e.key === 'ArrowLeft') {
        navigateLightbox(-1);
    } else if (e.key === 'ArrowRight') {
        navigateLightbox(1);
    }
});

// Close on overlay click
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>

<?php include 'footer.php'; ?>