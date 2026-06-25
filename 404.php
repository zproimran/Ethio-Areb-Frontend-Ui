<?php
// 404.php - Custom 404 Page
require_once 'config/db_config.php';
$settings = getSettings();
include 'header.php';
?>

<section class="min-h-screen flex items-center justify-center bg-white py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-9xl font-bold text-secondary mb-4">404</div>
        <h1 class="text-4xl font-bold text-dark-slate mb-4 font-poppins">Page Not Found</h1>
        <p class="text-gray-600 text-lg mb-8">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="<?php echo SITE_URL; ?>" class="btn-primary">
                <i class="fas fa-home mr-2"></i>Go Home
            </a>
            <a href="<?php echo SITE_URL; ?>contact" class="btn-outline">
                <i class="fas fa-envelope mr-2"></i>Contact Us
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>