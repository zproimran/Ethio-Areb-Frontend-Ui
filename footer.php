<?php
// footer.php - Complete Rebranded Footer with Dynamic Logo
?>
</main>

<footer>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info with Dynamic Logo -->
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <?php if (!empty($settings['site_logo']) && file_exists(UPLOAD_PATH . 'settings/' . $settings['site_logo'])): ?>
                        <!-- Uploaded Logo -->
                        <img src="<?php echo UPLOAD_URL . 'settings/' . $settings['site_logo']; ?>" alt="Ethio Areb" style="height: 44px; width: auto; max-height: 44px; object-fit: contain;">
                    <?php else: ?>
                        <!-- Fallback Logo -->
                        <div class="logo-icon" style="width: 44px; height: 44px; background: var(--brand-gradient, linear-gradient(135deg, #2D6FB7, #12A9C6)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; font-weight: 900; font-family: 'Poppins', sans-serif; border: 2px solid #D4AF37; flex-shrink: 0;">
                            <span>አ</span>
                            <span style="color: #D4AF37; font-size: 1.4rem;">✦</span>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                            Ethio <span style="color: #D4AF37;">Areb</span>
                        </h3>
                        <p class="text-xs text-gray-400" style="font-family: 'Noto Sans Ethiopic', sans-serif;">
                            አትዮ-አረብ · Foreign Employment Agent PLC
                        </p>
                    </div>
                </div>
                
                <!-- Agency Name - Full Display -->
                <div class="mt-4 pt-4 border-t border-gray-700">
                    <p class="text-sm font-semibold text-white" style="font-family: 'Poppins', sans-serif;">
                        Ethio Areb <span style="color: #D4AF37;">Foreign Employment Agency</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5" style="font-family: 'Noto Sans Ethiopic', sans-serif;">
                        አትዮ-አረብ የውጭ አገር ሥራ ማስተዋወቂያ ኤጀንሲ
                    </p>
                </div>
                
                <p class="text-gray-400 text-sm leading-relaxed mt-3">
                    <?php echo $settings['site_tagline'] ?? 'Getting Right People for the Right Job'; ?>
                </p>
                
                <div class="flex gap-3 mt-4">
                    <?php if (!empty($settings['site_facebook'])): ?>
                    <a href="<?php echo $settings['site_facebook']; ?>" target="_blank" class="w-9 h-9 rounded-full bg-gray-700 hover:bg-[#1877F2] flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="color: #9CA3AF;">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_twitter'])): ?>
                    <a href="<?php echo $settings['site_twitter']; ?>" target="_blank" class="w-9 h-9 rounded-full bg-gray-700 hover:bg-black flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="color: #9CA3AF;">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_linkedin'])): ?>
                    <a href="<?php echo $settings['site_linkedin']; ?>" target="_blank" class="w-9 h-9 rounded-full bg-gray-700 hover:bg-[#0A66C2] flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="color: #9CA3AF;">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_instagram'])): ?>
                    <a href="<?php echo $settings['site_instagram']; ?>" target="_blank" class="w-9 h-9 rounded-full bg-gray-700 hover:bg-gradient-to-br hover:from-[#F58529] hover:via-[#DD2A7B] hover:to-[#8134AF] flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="color: #9CA3AF;">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_youtube'])): ?>
                    <a href="<?php echo $settings['site_youtube']; ?>" target="_blank" class="w-9 h-9 rounded-full bg-gray-700 hover:bg-[#FF0000] flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="color: #9CA3AF;">
                        <i class="fab fa-youtube text-sm"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_telegram'])): ?>
                    <a href="https://t.me/<?php echo ltrim($settings['site_telegram'], '@'); ?>" target="_blank" class="w-9 h-9 rounded-full bg-gray-700 hover:bg-[#26A5E4] flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="color: #9CA3AF;">
                        <i class="fab fa-telegram-plane text-sm"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_whatsapp'])): ?>
                    <a href="<?php echo $settings['site_whatsapp']; ?>" target="_blank" class="w-9 h-9 rounded-full bg-gray-700 hover:bg-[#25D366] flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="color: #9CA3AF;">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-lg relative" style="font-family: 'Poppins', sans-serif;">
                    Quick Links
                    <span class="absolute bottom-0 left-0 w-10 h-0.5 bg-[#D4AF37] mt-1"></span>
                </h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="<?php echo SITE_URL; ?>about" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#12A9C6]"></i>About Us</a></li>
                    <li><a href="<?php echo SITE_URL; ?>services" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#12A9C6]"></i>Services</a></li>
                    <li><a href="<?php echo SITE_URL; ?>blog" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#12A9C6]"></i>Blog</a></li>
                    <li><a href="<?php echo SITE_URL; ?>contact" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#12A9C6]"></i>Contact</a></li>
                    <li><a href="<?php echo SITE_URL; ?>faqs" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#12A9C6]"></i>FAQs</a></li>
                    <li><a href="<?php echo SITE_URL; ?>apply" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#12A9C6]"></i>Apply Now</a></li>
                </ul>
            </div>

            <!-- Our Services -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-lg relative" style="font-family: 'Poppins', sans-serif;">
                    Our Services
                    <span class="absolute bottom-0 left-0 w-10 h-0.5 bg-[#D4AF37] mt-1"></span>
                </h4>
                <ul class="space-y-2.5 text-sm">
                    <?php 
                    $footerServices = getServices(6);
                    foreach ($footerServices as $fs): 
                    ?>
                    <li><a href="<?php echo SITE_URL; ?>service/<?php echo $fs['slug']; ?>" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#12A9C6]"></i><?php echo $fs['name']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-lg relative" style="font-family: 'Poppins', sans-serif;">
                    Contact Info
                    <span class="absolute bottom-0 left-0 w-10 h-0.5 bg-[#D4AF37] mt-1"></span>
                </h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-3 text-gray-400">
                        <i class="fas fa-map-marker-alt text-[#D4AF37] mt-1"></i>
                        <span><?php echo $settings['site_address'] ?? 'Addis Ababa, Ethiopia'; ?></span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-400">
                        <i class="fas fa-phone text-[#D4AF37]"></i>
                        <span><?php echo $settings['site_phone'] ?? '+251 981 82 22 22'; ?></span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-400">
                        <i class="fas fa-mobile-alt text-[#D4AF37]"></i>
                        <span><?php echo $settings['site_mobile'] ?? '+251 981 72 22 22'; ?></span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-400">
                        <i class="fas fa-envelope text-[#D4AF37]"></i>
                        <a href="mailto:<?php echo $settings['site_email'] ?? 'ethioareb22@gmail.com'; ?>" class="hover:text-[#D4AF37] transition-colors duration-300">
                            <?php echo $settings['site_email'] ?? 'ethioareb22@gmail.com'; ?>
                        </a>
                    </li>
                    <?php if (!empty($settings['site_whatsapp'])): ?>
                    <li class="flex items-center gap-3 text-gray-400">
                        <i class="fab fa-whatsapp text-[#25D366]"></i>
                        <a href="<?php echo $settings['site_whatsapp']; ?>" target="_blank" class="hover:text-[#D4AF37] transition-colors duration-300">WhatsApp</a>
                    </li>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_telegram'])): ?>
                    <li class="flex items-center gap-3 text-gray-400">
                        <i class="fab fa-telegram-plane text-[#26A5E4]"></i>
                        <a href="https://t.me/<?php echo ltrim($settings['site_telegram'], '@'); ?>" target="_blank" class="hover:text-[#D4AF37] transition-colors duration-300">Telegram</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-400 text-sm">
                <?php echo $settings['footer_text'] ?? '© 2026 Ethio Areb Foreign Employment PLC. All Rights Reserved.'; ?>
            </p>
            <div class="flex items-center gap-6 text-sm">
                <a href="<?php echo SITE_URL; ?>privacy" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">Privacy Policy</a>
                <span class="text-gray-600">|</span>
                <a href="<?php echo SITE_URL; ?>terms" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">Terms & Conditions</a>
                <span class="text-gray-600">|</span>
                <a href="<?php echo SITE_URL; ?>sitemap" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">Sitemap</a>
            </div>
        </div>

        <!-- Scroll to Top -->
        <div class="text-center mt-6">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="text-gray-500 hover:text-[#D4AF37] transition-colors duration-300 text-sm">
                <i class="fas fa-chevron-up"></i> Back to Top
            </button>
        </div>
    </div>
</footer>

<style>
    /* ============================================================
    FOOTER BRAND COLORS
    ============================================================ */
    footer {
        background: #1F2937;
        padding: 4rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(45, 111, 183, 0.05), transparent);
        border-radius: 50%;
        pointer-events: none;
    }

    footer .logo-icon {
        background: linear-gradient(135deg, #2D6FB7, #12A9C6);
        border: 2px solid #D4AF37;
    }

    footer .social-icon {
        transition: all 0.3s ease;
    }

    footer .social-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    footer .social-icon.facebook:hover { background: #1877F2; }
    footer .social-icon.twitter:hover { background: #000000; }
    footer .social-icon.linkedin:hover { background: #0A66C2; }
    footer .social-icon.instagram:hover { 
        background: linear-gradient(135deg, #F58529, #DD2A7B, #8134AF); 
    }
    footer .social-icon.youtube:hover { background: #FF0000; }
    footer .social-icon.telegram:hover { background: #26A5E4; }
    footer .social-icon.whatsapp:hover { background: #25D366; }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        footer .grid {
            gap: 2rem;
        }
        footer .border-t {
            flex-direction: column;
            text-align: center;
        }
        footer .border-t .flex {
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        footer {
            padding: 3rem 0 1.5rem;
        }
        footer .logo-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }
        footer .social-icon {
            width: 32px;
            height: 32px;
        }
        footer .social-icon i {
            font-size: 0.7rem;
        }
        /* Hide agency name on mobile */
        footer .border-t.border-gray-700.mt-4 {
            display: none;
        }
        footer img[style*="height: 44px;"] {
            height: 32px !important;
            max-height: 32px !important;
        }
    }
</style>

<!-- ============================================================
    SCRIPTS
============================================================ -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?php echo SITE_URL; ?>ethioareb/assets/js/ethioareb.js"></script>

<script>
    AOS.init({ duration: 800, once: true, offset: 100 });

    // Initialize Swiper for testimonials
    <?php if (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'testimonials.php'): ?>
    new Swiper('.testimonials-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });
    <?php endif; ?>

    // Back to Top button visibility
    window.addEventListener('scroll', function() {
        const btn = document.querySelector('[onclick*="scrollTo"]');
        if (btn) {
            if (window.scrollY > 300) {
                btn.style.opacity = '1';
                btn.style.visibility = 'visible';
            } else {
                btn.style.opacity = '0';
                btn.style.visibility = 'hidden';
            }
        }
    });
</script>

</body>
</html>