<?php
// header.php - Complete Brand Implementation with Accurate Logo Colors
$settings = getSettings();
$current_page = basename($_SERVER['PHP_SELF']);
$current_page = str_replace('.php', '', $current_page);

// Get logo from settings
$site_logo = $settings['site_logo'] ?? '';
$logo_url = !empty($site_logo) ? UPLOAD_URL . 'settings/' . $site_logo : '';
$favicon_url = !empty($settings['site_favicon']) ? UPLOAD_URL . 'settings/' . $settings['site_favicon'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $settings['meta_title'] ?? 'Ethio Areb - Foreign Employment'; ?></title>
    <meta name="description" content="<?php echo $settings['meta_description'] ?? ''; ?>">
    <meta name="keywords" content="<?php echo $settings['meta_keywords'] ?? ''; ?>">
    
    <!-- Favicon -->
    <?php if (!empty($favicon_url)): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo $favicon_url; ?>">
    <link rel="shortcut icon" href="<?php echo $favicon_url; ?>">
    <?php endif; ?>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Ethiopic:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>ethioareb/assets/css/ethioareb.css">
    
    <!-- ============================================================
    ACCURATE BRAND COLORS - Extracted from Logo
    ============================================================ -->
    <style>
        :root {
            /* ============================================================
            PRIMARY LOGO COLORS (EXACT EXTRACTION)
            ============================================================ */
            --brand-sky-blue: #36B4E7;      /* "E" monogram */
            --brand-leaf-green: #69BD44;    /* "A" monogram */
            --brand-teal: #13AABB;           /* Globe ring, continents, plane */
            --brand-navy: #3E5297;           /* Amharic tagline + company name */
            
            /* ============================================================
            SUPPORTING COLORS
            ============================================================ */
            --gold: #D4AF37;
            --dark: #1F2937;
            --gray: #6B7280;
            --light-gray: #F8FAFC;
            --white: #FFFFFF;
            
            /* ============================================================
            GRADIENTS
            ============================================================ */
            --brand-gradient: linear-gradient(135deg, var(--brand-teal), var(--brand-navy));
            --accent-gradient: linear-gradient(135deg, var(--brand-sky-blue), var(--brand-leaf-green));
            --gold-gradient: linear-gradient(135deg, #D4AF37, #f5d76e);
        }
        
        /* ============================================================
        TYPOGRAPHY
        ============================================================ */
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        .font-amharic { font-family: 'Noto Sans Ethiopic', sans-serif; }
        
        /* ============================================================
        BRAND COLOR CLASSES
        ============================================================ */
        .bg-teal { background-color: var(--brand-teal); }
        .text-teal { color: var(--brand-teal); }
        .bg-navy { background-color: var(--brand-navy); }
        .text-navy { color: var(--brand-navy); }
        .bg-sky-blue { background-color: var(--brand-sky-blue); }
        .text-sky-blue { color: var(--brand-sky-blue); }
        .bg-leaf-green { background-color: var(--brand-leaf-green); }
        .text-leaf-green { color: var(--brand-leaf-green); }
        
        .bg-primary { background-color: var(--brand-teal); }
        .text-primary { color: var(--brand-teal); }
        .hover\:bg-primary:hover { background-color: #0e8ba3; }
        .hover\:text-primary:hover { color: var(--brand-teal); }
        
        .bg-secondary { background-color: var(--brand-navy); }
        .text-secondary { color: var(--brand-navy); }
        
        .bg-accent { background-color: var(--brand-leaf-green); }
        .text-accent { color: var(--brand-leaf-green); }
        
        .border-primary { border-color: var(--brand-teal); }
        .border-secondary { border-color: var(--brand-navy); }
        
        /* Brand Gradient Backgrounds */
        .bg-brand-gradient { background: var(--brand-gradient); }
        .bg-accent-gradient { background: var(--accent-gradient); }
        .text-gold-gradient { 
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* ============================================================
        LOGO STYLES - DYNAMIC WITH AGENCY NAME
        ============================================================ */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
        }
        
        /* Logo Image */
        .logo-container .logo-image {
            height: 50px;
            width: auto;
            max-height: 50px;
            object-fit: contain;
        }
        
        /* Fallback logo when no image uploaded */
        .logo-fallback {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-fallback .logo-icon {
            position: relative;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--brand-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 20px rgba(62, 82, 151, 0.25);
            border: 2px solid rgba(255,255,255,0.15);
        }
        
        .logo-fallback .logo-icon .ea-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            font-size: 1.4rem;
            color: white;
            letter-spacing: -1px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .logo-fallback .logo-icon .ea-text .e { color: var(--brand-sky-blue); }
        .logo-fallback .logo-icon .ea-text .a { color: var(--brand-leaf-green); }
        
        .logo-fallback .logo-icon .globe-icon {
            position: absolute;
            font-size: 1.6rem;
            opacity: 0.15;
            color: white;
            animation: rotateGlobe 20s linear infinite;
        }
        
        .logo-fallback .logo-icon .plane-icon {
            position: absolute;
            bottom: 2px;
            right: 2px;
            font-size: 0.6rem;
            color: var(--brand-teal);
            opacity: 0.6;
            transform: rotate(45deg);
        }
        
        @keyframes rotateGlobe {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .logo-fallback .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        
        .logo-fallback .logo-text .brand-name {
            font-family: 'Poppins', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--brand-navy);
            letter-spacing: 0.3px;
        }
        
        .logo-fallback .logo-text .brand-name .gold {
            color: var(--gold);
            position: relative;
        }
        
        .logo-fallback .logo-text .brand-name .gold::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--gold-gradient);
            border-radius: 2px;
        }
        
        .logo-fallback .logo-text .brand-sub {
            font-family: 'Inter', sans-serif;
            font-size: 0.45rem;
            font-weight: 600;
            color: var(--gray);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }
        
        .logo-fallback .logo-text .brand-sub .amharic {
            font-family: 'Noto Sans Ethiopic', sans-serif;
            font-weight: 600;
            color: var(--brand-navy);
            font-size: 0.55rem;
        }
        
        .logo-fallback .logo-text .brand-sub .dot {
            color: var(--brand-teal);
            font-weight: 900;
        }
        
        /* ============================================================
        AGENCY NAME STYLES
        ============================================================ */
        .agency-name-wrapper {
            display: flex;
            flex-direction: column;
            padding-left: 16px;
            border-left: 2px solid var(--gold);
        }
        
        .agency-name-wrapper .agency-title {
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--brand-navy);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1.2;
        }
        
        .agency-name-wrapper .agency-title .gold-text {
            color: var(--gold);
        }
        
        .agency-name-wrapper .agency-sub {
            font-family: 'Inter', sans-serif;
            font-size: 0.55rem;
            font-weight: 500;
            color: var(--gray);
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        
        .agency-name-wrapper .agency-sub .amharic-text {
            font-family: 'Noto Sans Ethiopic', sans-serif;
            font-weight: 600;
            color: var(--brand-navy);
            font-size: 0.6rem;
        }
        
        /* ============================================================
        BRAND BUTTONS
        ============================================================ */
        .btn-primary {
            background: var(--brand-gradient);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(62, 82, 151, 0.25);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(62, 82, 151, 0.35);
            color: white;
        }
        
        .btn-secondary {
            background: var(--brand-teal);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(19, 170, 187, 0.25);
        }
        .btn-secondary:hover {
            background: #0e8ba3;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(19, 170, 187, 0.35);
            color: white;
        }
        
        .btn-success {
            background: var(--brand-leaf-green);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(105, 189, 68, 0.25);
        }
        .btn-success:hover {
            background: #4CAF50;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(105, 189, 68, 0.35);
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--brand-navy);
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: 2px solid var(--brand-navy);
            cursor: pointer;
            text-decoration: none;
        }
        .btn-outline:hover {
            background: var(--brand-navy);
            color: white;
            transform: translateY(-3px);
        }
        
        /* ============================================================
        SECTION TITLES
        ============================================================ */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
        }
        .section-title .highlight {
            background: var(--brand-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .section-subtitle {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            font-weight: 400;
        }
        
        .section-badge {
            display: inline-block;
            background: rgba(19, 170, 187, 0.1);
            color: var(--brand-teal);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }
        
        /* ============================================================
        NAVBAR
        ============================================================ */
        .navbar {
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0 2rem;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            flex-wrap: nowrap;
        }
        
        .nav-link {
            color: #4B5563;
            font-weight: 500;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--brand-navy);
            background: rgba(62, 82, 151, 0.06);
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--brand-gradient);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: 60%;
        }
        
        /* ============================================================
        GOOGLE TRANSLATE WIDGET
        ============================================================ */
        #google_translate_element {
            display: inline-block;
            vertical-align: middle;
        }
        
        .goog-te-gadget {
            font-family: 'Inter', sans-serif !important;
            display: inline-block !important;
        }
        
        .goog-te-gadget select {
            padding: 8px 12px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 8px !important;
            background: white !important;
            color: #374151 !important;
            font-size: 14px !important;
            cursor: pointer !important;
            min-width: 150px !important;
            font-family: 'Inter', sans-serif !important;
            height: 40px !important;
            appearance: auto !important;
            -webkit-appearance: auto !important;
        }
        
        .goog-te-gadget select:hover {
            border-color: var(--brand-teal) !important;
        }
        
        .goog-te-gadget select:focus {
            outline: none !important;
            border-color: var(--brand-teal) !important;
            box-shadow: 0 0 0 2px rgba(19, 170, 187, 0.15) !important;
        }
        
        /* ============================================================
        FIX FOR GOOGLE TRANSLATE BANNER
        ============================================================ */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }
        body { top: 0px !important; position: relative !important; }
        .goog-te-menu-frame { z-index: 9999 !important; }
        .goog-te-gadget-simple { z-index: 9999 !important; }
        .skiptranslate iframe { display: none !important; }
        .goog-te-balloon-frame { display: none !important; }
        
        /* ============================================================
        APPLY NOW BUTTON
        ============================================================ */
        .apply-btn {
            background: var(--brand-leaf-green);
            color: white;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
            text-decoration: none;
            display: inline-block;
            font-size: 0.85rem;
            white-space: nowrap;
        }
        .apply-btn:hover {
            background: #4CAF50;
            transform: scale(1.05);
            color: white;
        }
        .apply-btn i {
            margin-right: 0.3rem;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(105, 189, 68, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(105, 189, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(105, 189, 68, 0); }
        }
        
        /* ============================================================
        MOBILE MENU
        ============================================================ */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            z-index: 999;
            max-height: calc(100vh - 80px);
            overflow-y: auto;
        }
        .mobile-menu.open { display: block; }
        .mobile-menu a {
            display: block;
            padding: 0.75rem 0;
            color: #4B5563;
            text-decoration: none;
            border-bottom: 1px solid #f3f4f6;
        }
        .mobile-menu a:hover { color: var(--brand-navy); }
        .mobile-menu a:last-child { border-bottom: none; }
        
        /* ============================================================
        ADMIN ICON
        ============================================================ */
        .admin-icon {
            color: #9CA3AF;
            transition: color 0.3s ease;
            padding: 0.4rem 0.5rem;
        }
        .admin-icon:hover { color: var(--brand-navy); }
        
        /* ============================================================
        RESPONSIVE
        ============================================================ */
        @media (max-width: 1024px) {
            .nav-link { font-size: 0.8rem; padding: 0.3rem 0.5rem; }
            .apply-btn { font-size: 0.75rem; padding: 6px 12px; }
            .goog-te-gadget select { 
                font-size: 12px !important; 
                padding: 6px 10px !important; 
                height: 34px !important; 
                min-width: 120px !important;
            }
            .logo-fallback .logo-text .brand-name { font-size: 1.1rem; }
            .logo-fallback .logo-text .brand-sub { font-size: 0.4rem; }
            .logo-fallback .logo-icon { width: 40px; height: 40px; }
            .logo-fallback .logo-icon .ea-text { font-size: 1.1rem; }
            .logo-container .logo-image { height: 40px; max-height: 40px; }
            .agency-name-wrapper .agency-title { font-size: 0.7rem; }
            .agency-name-wrapper .agency-sub { font-size: 0.45rem; }
            .agency-name-wrapper { padding-left: 10px; }
        }
        
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-toggle { display: block !important; }
            .navbar { padding: 0 1rem; }
            .section-title { font-size: 1.8rem; }
            .logo-fallback .logo-text .brand-name { font-size: 0.9rem; }
            .logo-fallback .logo-text .brand-sub { font-size: 0.35rem; }
            .logo-fallback .logo-icon { width: 36px; height: 36px; }
            .logo-fallback .logo-icon .ea-text { font-size: 0.9rem; }
            .logo-fallback .logo-icon .globe-icon { font-size: 1.2rem; }
            .logo-container .logo-image { height: 35px; max-height: 35px; }
            .agency-name-wrapper { display: none; }
        }
        
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #4B5563;
            cursor: pointer;
            padding: 0.5rem;
        }
        .mobile-toggle:hover { color: var(--brand-navy); }
        
        /* ============================================================
        FOOTER
        ============================================================ */
        footer {
            background: var(--dark);
            color: #D1D5DB;
            padding: 4rem 0 2rem;
            margin-top: 2rem;
        }
        footer a { color: #9CA3AF; transition: color 0.3s ease; text-decoration: none; }
        footer a:hover { color: var(--brand-teal); }
        
        /* ============================================================
        ACTIVE PAGE DETECTION
        ============================================================ */
        .page-home .nav-home,
        .page-about .nav-about,
        .page-services .nav-services,
        .page-gallery .nav-gallery,
        .page-blog .nav-blog,
        .page-team .nav-team,
        .page-testimonials .nav-testimonials,
        .page-contact .nav-contact {
            color: var(--brand-navy);
            background: rgba(62, 82, 151, 0.06);
        }
        .page-home .nav-home::after,
        .page-about .nav-about::after,
        .page-services .nav-services::after,
        .page-gallery .nav-gallery::after,
        .page-blog .nav-blog::after,
        .page-team .nav-team::after,
        .page-testimonials .nav-testimonials::after,
        .page-contact .nav-contact::after {
            width: 60%;
        }
        
        /* ============================================================
        HERO SECTION - Brand Specific
        ============================================================ */
        .hero-section {
            background: var(--brand-gradient);
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section .hero-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .hero-section .hero-particles span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            animation: float 15s infinite;
        }
        
        .hero-section .hero-particles span:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; width: 30px; height: 30px; }
        .hero-section .hero-particles span:nth-child(2) { top: 30%; right: 15%; animation-delay: 2s; width: 40px; height: 40px; }
        .hero-section .hero-particles span:nth-child(3) { bottom: 20%; left: 10%; animation-delay: 4s; width: 25px; height: 25px; }
        .hero-section .hero-particles span:nth-child(4) { bottom: 30%; right: 25%; animation-delay: 6s; width: 35px; height: 35px; }
        .hero-section .hero-particles span:nth-child(5) { top: 50%; left: 50%; animation-delay: 8s; width: 50px; height: 50px; }
        .hero-section .hero-particles span:nth-child(6) { top: 15%; right: 40%; animation-delay: 10s; width: 20px; height: 20px; }
        .hero-section .hero-particles span:nth-child(7) { bottom: 40%; left: 35%; animation-delay: 12s; width: 45px; height: 45px; }
        .hero-section .hero-particles span:nth-child(8) { top: 60%; right: 5%; animation-delay: 14s; width: 30px; height: 30px; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
            25% { transform: translateY(-30px) rotate(90deg); opacity: 0.6; }
            50% { transform: translateY(-60px) rotate(180deg); opacity: 0.3; }
            75% { transform: translateY(-30px) rotate(270deg); opacity: 0.6; }
        }
        
        .hero-badge {
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
        }
        
        .hero-badge i {
            margin-right: 8px;
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        
        .hero-title .highlight {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255,255,255,0.85);
            max-width: 550px;
            line-height: 1.8;
        }
    </style>
</head>
<body class="page-<?php echo $current_page ?: 'home'; ?>">

<!-- Navbar -->
<nav class="navbar">
    <!-- Logo with Branding - DYNAMIC -->
    <a href="<?php echo SITE_URL; ?>" class="logo-container">
        <?php if (!empty($logo_url) && file_exists(UPLOAD_PATH . 'settings/' . $site_logo)): ?>
            <!-- Uploaded Logo -->
            <img src="<?php echo $logo_url; ?>" alt="Ethio Areb" class="logo-image">
        <?php else: ?>
            <!-- Fallback Logo (when no image uploaded) -->
            <div class="logo-fallback">
                <div class="logo-icon">
                    <i class="fas fa-globe-africa globe-icon"></i>
                    <span class="ea-text"><span class="e" style="color: #36B4E7;">E</span><span class="a" style="color: #69BD44;">A</span></span>
                    <i class="fas fa-plane plane-icon" style="color: #13AABB;"></i>
                </div>
                <div class="logo-text">
                    <span class="brand-name">
                        Ethio <span class="gold">Areb</span>
                    </span>
                    <span class="brand-sub">
                        <span class="amharic">አትዮ-አረብ</span>
                        <span class="dot">·</span>
                        FOREIGN EMPLOYMENT AGENT PLC
                    </span>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Agency Name - AFTER LOGO -->
        <div class="agency-name-wrapper">
            <span class="agency-title">
                Ethio <span class="gold-text">Areb</span>
            </span>
            <span class="agency-sub">
                <span class="amharic-text">አትዮ-አረብ</span>
                <span style="color: #D4AF37;">·</span>
                FOREIGN EMPLOYMENT AGENCY
            </span>
        </div>
    </a>
    
    <!-- Navigation Links -->
    <div class="nav-links">
        
        <!-- Google Translate Widget -->
        <div id="google_translate_element"></div>
        
        <!-- Navigation Links -->
        <a href="<?php echo SITE_URL; ?>" class="nav-link nav-home <?php echo $current_page == '' || $current_page == 'index' ? 'active' : ''; ?>">Home</a>
        <a href="<?php echo SITE_URL; ?>about" class="nav-link nav-about <?php echo $current_page == 'about' ? 'active' : ''; ?>">About</a>
        <a href="<?php echo SITE_URL; ?>services" class="nav-link nav-services <?php echo $current_page == 'services' || $current_page == 'service-detail' ? 'active' : ''; ?>">Services</a>
        <a href="<?php echo SITE_URL; ?>gallery" class="nav-link nav-gallery <?php echo $current_page == 'gallery' ? 'active' : ''; ?>">Gallery</a>
        <a href="<?php echo SITE_URL; ?>blog" class="nav-link nav-blog <?php echo $current_page == 'blog' || $current_page == 'blog-detail' ? 'active' : ''; ?>">Blog</a>
        <a href="<?php echo SITE_URL; ?>team" class="nav-link nav-team <?php echo $current_page == 'team' ? 'active' : ''; ?>">Team</a>
        <a href="<?php echo SITE_URL; ?>testimonials" class="nav-link nav-testimonials <?php echo $current_page == 'testimonials' ? 'active' : ''; ?>">Testimonials</a>
        <a href="<?php echo SITE_URL; ?>contact" class="nav-link nav-contact <?php echo $current_page == 'contact' ? 'active' : ''; ?>">Contact</a>
        <a href="<?php echo SITE_URL; ?>faqs" class="nav-link nav-faqs <?php echo $current_page == 'faqs' ? 'active' : ''; ?>">FAQs</a>
        
        <!-- Apply Now Button -->
        <a href="<?php echo SITE_URL; ?>apply" class="apply-btn"><i class="fas fa-paper-plane"></i>Apply Now</a>
        
        <!-- Admin Icon 
        <a href="<?php echo ADMIN_URL; ?>" class="admin-icon"><i class="fas fa-user-shield"></i></a>
        -->
    </div>
    
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="toggleMobile()">
        <i class="fas fa-bars"></i>
    </button>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <a href="<?php echo SITE_URL; ?>">Home</a>
    <a href="<?php echo SITE_URL; ?>about">About</a>
    <a href="<?php echo SITE_URL; ?>services">Services</a>
    <a href="<?php echo SITE_URL; ?>gallery">Gallery</a>
    <a href="<?php echo SITE_URL; ?>blog">Blog</a>
    <a href="<?php echo SITE_URL; ?>team">Team</a>
    <a href="<?php echo SITE_URL; ?>testimonials">Testimonials</a>
    <a href="<?php echo SITE_URL; ?>contact">Contact</a>
    <a href="<?php echo SITE_URL; ?>faqs">FAQs</a>
    <a href="<?php echo SITE_URL; ?>apply" class="text-green-600 font-bold">Apply Now</a>
</div>

<!-- Main Content -->
<main style="padding-top: 80px;">

<script>
function toggleMobile() {
    document.getElementById('mobileMenu').classList.toggle('open');
}

// Close mobile menu on link click
document.querySelectorAll('#mobileMenu a').forEach(function(link) {
    link.addEventListener('click', function() {
        document.getElementById('mobileMenu').classList.remove('open');
    });
});

// Close mobile menu on outside click
document.addEventListener('click', function(e) {
    const menu = document.getElementById('mobileMenu');
    const toggle = document.querySelector('.mobile-toggle');
    if (menu.classList.contains('open') && !menu.contains(e.target) && !toggle.contains(e.target)) {
        menu.classList.remove('open');
    }
});

// Fix for Google Translate widget positioning after translation
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.body.style.top = '0px';
        document.body.style.position = 'relative';
        var banner = document.querySelector('.goog-te-banner-frame');
        if (banner) {
            banner.style.display = 'none';
        }
    }, 1000);
});
</script>