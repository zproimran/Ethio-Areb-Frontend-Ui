<?php
// service-detail.php - Single Service Detail Page
require_once 'config/db_config.php';
$conn = getDB();

$slug = $_GET['slug'] ?? '';
$service = getServiceBySlug($slug);

if (!$service) {
    header('Location: services.php');
    exit();
}

// Update view count
$conn->query("UPDATE services SET views = views + 1 WHERE id = {$service['id']}");

// Get related services
$related = getServices(3, $service['category_id']);
$images = $conn->query("SELECT * FROM service_images WHERE service_id = {$service['id']} ORDER BY is_primary DESC, order_no ASC");

include 'header.php';
?>

<style>
    .service-detail-hero {
        background: linear-gradient(135deg, #0B3D91, #1a4fa0);
        padding: 120px 0 60px;
    }
    .service-content h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #1F2937;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .service-content ul {
        list-style: none;
        padding: 0;
    }
    .service-content ul li {
        padding: 6px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #4B5563;
    }
    .service-content ul li i {
        color: #D4AF37;
        font-size: 0.8rem;
    }
    .enquiry-form input,
    .enquiry-form textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #D1D5DB;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .enquiry-form input:focus,
    .enquiry-form textarea:focus {
        outline: none;
        border-color: #0B3D91;
        box-shadow: 0 0 0 3px rgba(11, 61, 145, 0.1);
    }
</style>

<!-- Service Hero -->
<section class="service-detail-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <nav class="text-sm mb-4">
            <a href="services.php" class="text-blue-200 hover:text-white transition">Services</a>
            <span class="mx-2 text-blue-300">/</span>
            <span class="text-white"><?php echo $service['name']; ?></span>
        </nav>
        <h1 class="text-4xl md:text-5xl font-bold mb-4" data-aos="fade-up"><?php echo $service['name']; ?></h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            <?php echo $service['category_name'] ?? 'Recruitment Service'; ?>
        </p>
    </div>
</section>

<!-- Service Content -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <?php if (!empty($service['image'])): ?>
                <img src="<?php echo UPLOAD_URL . 'services/' . $service['image']; ?>" alt="<?php echo $service['name']; ?>" class="w-full rounded-2xl mb-8" data-aos="fade-up">
                <?php endif; ?>
                
                <div class="service-content" data-aos="fade-up">
                    <p class="text-gray-600 leading-relaxed text-lg"><?php echo nl2br($service['description']); ?></p>
                    
                    <?php if (!empty($service['long_description'])): ?>
                    <h2>About This Service</h2>
                    <p class="text-gray-600 leading-relaxed"><?php echo nl2br($service['long_description']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($service['features'])): ?>
                    <h2>Key Features</h2>
                    <ul>
                        <?php foreach (explode("\n", $service['features']) as $feature): ?>
                        <li><i class="fas fa-check-circle"></i> <?php echo trim($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    
                    <?php if (!empty($service['benefits'])): ?>
                    <h2>Benefits</h2>
                    <ul>
                        <?php foreach (explode("\n", $service['benefits']) as $benefit): ?>
                        <li><i class="fas fa-star"></i> <?php echo trim($benefit); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    
                    <?php if (!empty($service['requirements'])): ?>
                    <h2>Requirements</h2>
                    <ul>
                        <?php foreach (explode("\n", $service['requirements']) as $req): ?>
                        <li><i class="fas fa-arrow-right"></i> <?php echo trim($req); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
                
                <!-- Service Images Gallery -->
                <?php if ($images && $images->num_rows > 0): ?>
                <div class="mt-12" data-aos="fade-up">
                    <h3 class="text-2xl font-bold text-dark-slate mb-4 font-poppins">Service Gallery</h3>
                    <div class="grid grid-cols-3 gap-3">
                        <?php while ($img = $images->fetch_assoc()): ?>
                        <img src="<?php echo UPLOAD_URL . 'services/' . $img['image']; ?>" alt="<?php echo $img['caption'] ?? ''; ?>" class="w-full h-32 object-cover rounded-xl hover:scale-105 transition">
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div data-aos="fade-left">
                <!-- Quick Info -->
                <div class="bg-light-gray p-6 rounded-2xl mb-6">
                    <h4 class="text-lg font-bold text-dark-slate mb-4 font-poppins">Quick Info</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-tag text-secondary"></i>
                            <span class="text-gray-600">Category: <?php echo $service['category_name'] ?? 'General'; ?></span>
                        </li>
                        <?php if ($service['price']): ?>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-dollar-sign text-secondary"></i>
                            <span class="text-gray-600">Price: <?php echo $service['price_currency'] ?? 'USD'; ?> <?php echo number_format($service['price'], 2); ?></span>
                        </li>
                        <?php endif; ?>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-eye text-secondary"></i>
                            <span class="text-gray-600">Views: <?php echo $service['views'] ?? 0; ?></span>
                        </li>
                    </ul>
                </div>
                
                <!-- Enquiry Form -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h4 class="text-lg font-bold text-dark-slate mb-4 font-poppins">Request Information</h4>
                    <form method="POST" action="" class="enquiry-form space-y-4">
                        <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                        <input type="text" name="name" placeholder="Your Name *" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <input type="email" name="email" placeholder="Your Email *" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <input type="tel" name="phone" placeholder="Phone Number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <input type="text" name="company" placeholder="Company Name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <textarea name="message" rows="4" placeholder="Your Message *" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        <button type="submit" class="btn-primary w-full text-center">Send Enquiry <i class="fas fa-paper-plane ml-2"></i></button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Related Services -->
        <?php if (!empty($related)): ?>
        <div class="mt-20" data-aos="fade-up">
            <h3 class="text-2xl font-bold text-dark-slate mb-6 font-poppins">Related Services</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($related as $rel): ?>
                <?php if ($rel['id'] == $service['id']) continue; ?>
                <div class="bg-white p-6 rounded-2xl shadow-sm card-hover">
                    <div class="icon">
                        <i class="fas fa-<?php echo $rel['icon'] ?? 'briefcase'; ?> text-2xl text-primary"></i>
                    </div>
                    <h4 class="text-lg font-bold text-dark-slate font-poppins"><?php echo $rel['name']; ?></h4>
                    <p class="text-gray-600 text-sm"><?php echo substr($rel['description'] ?? '', 0, 80); ?>...</p>
                    <a href="service-detail.php?slug=<?php echo $rel['slug']; ?>" class="text-primary font-semibold hover:text-secondary transition inline-flex items-center text-sm mt-2">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
// Handle Enquiry Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_id'])) {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $company = sanitize($_POST['company'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    $service_id = (int)$_POST['service_id'];
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO service_enquiries (service_id, name, email, phone, company, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $service_id, $name, $email, $phone, $company, $message);
        $stmt->execute();
        echo '<script>alert("Thank you! Your enquiry has been sent. We will contact you soon.");</script>';
    }
}
?>

<?php include 'footer.php'; ?>