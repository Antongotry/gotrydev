<?php
/**
 * Template for Front Page (Home)
 * AI Landing Page з Video Background
 */

get_header(); 
?>

<!-- Video Background -->
<div class="video-background" id="video-background">
    <video id="bg-video" autoplay muted loop playsinline webkit-playsinline>
        <source src="https://antongotry.dev/wp-content/uploads/2026/01/0_Blackhole_Astrophysics_1920x1080.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-overlay"></div>
</div>

<!-- Foreground Object Layer (для об'єкта поверх відео, як щупальця восьминога) -->
<div class="hero-foreground-layer" id="heroForegroundLayer">
    <!-- Тут буде об'єкт (3D модель, зображення, SVG) який накладається поверх відео -->
    <!-- z-index буде між відео (z-1) та контентом (z-10) -->
</div>

<!-- Hero Section (як на референсі) -->
<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-main-wrapper">
            <!-- Ліва частина: Split text indicator (як на Lenis) -->
            <div class="hero-left-indicator">
                <p class="scroll-indicator-text">scroll</p>
                <p class="scroll-indicator-text">to explore</p>
            </div>
            
            <!-- Центральна частина: Великий заголовок з split text -->
            <div class="hero-center-section">
                <h1 class="hero-title-split">
                    <span class="title-word">Перетворюю</span>
                    <span class="title-word highlight">код</span>
                    <span class="title-word">у</span>
                    <span class="title-word highlight">красивий</span>
                    <span class="title-word">дизайн</span>
                </h1>
                
                <div class="hero-meta">
                    <p class="hero-tagline">Веб-сайти від ідеї до запуску</p>
                    <p class="hero-copyright">© 2026 Gotry</p>
                </div>
                
                <!-- CTA Links (як на Lenis - коротші) -->
                <div class="hero-cta-links">
                    <a href="#contact" class="cta-link" data-analytics="cta-hero-contact">
                        <span class="cta-link-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 3h8v8H3zM13 13h8v8h-8zM3 13h8v8H3zM13 3h8v8h-8z"/>
                            </svg>
                        </span>
                        <span class="cta-link-text">Консультація</span>
                    </a>
                    <a href="https://t.me/notarikon" class="cta-link" target="_blank" rel="noopener" data-analytics="cta-hero-telegram">
                        <span class="cta-link-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </span>
                        <span class="cta-link-text">Telegram</span>
                    </a>
                </div>
            </div>
            
            <!-- Права частина: Статистика (як на Lenis - мінімалістична) -->
            <div class="hero-right-meta">
                <div class="hero-stats-minimal">
                    <div class="stat-minimal">
                        <span class="stat-number">50+</span>
                        <span class="stat-label-small">проектів</span>
                    </div>
                    <div class="stat-minimal">
                        <span class="stat-number">100%</span>
                        <span class="stat-label-small">якість</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
