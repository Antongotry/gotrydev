<?php
/**
 * Template for Front Page (Home)
 * Creative Branding Agency Layout
 */

get_header(); 
?>

<!-- Header Navigation -->
<header class="top-nav" id="top-nav">
    <div class="wide-container">
        <div class="grid-12">
            <!-- Left: Logo + Hamburger -->
            <div class="col-2 nav-left">
                <div class="nav-logo">
                    <a href="/" class="logo-link">
                        <img src="https://antongotry.dev/wp-content/uploads/2026/01/logo-white.svg" alt="Logo" class="logo-img logo-white">
                        <img src="https://antongotry.dev/wp-content/uploads/2026/01/dark-logo.svg" alt="Logo" class="logo-img logo-dark">
                    </a>
                    <button class="hamburger-menu" aria-label="Menu">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>
            </div>
            
            <!-- Center: Navigation Menu -->
            <div class="col-6 nav-center">
                <nav class="nav-links">
                    <a href="#home" class="nav-link">HOME</a>
                    <a href="#services" class="nav-link">SERVICES</a>
                    <a href="#cases" class="nav-link">CASES</a>
                </nav>
            </div>
            
            <!-- Right: Social Icons -->
            <div class="col-2 nav-right">
                <div class="nav-social">
                    <a href="#" class="social-icon" aria-label="Instagram">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>
                    <a href="https://t.me/notarikon" class="social-icon" aria-label="Telegram" target="_blank" rel="noopener">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Video Background -->
<div class="video-background" id="video-background">
    <video id="bg-video" autoplay muted loop playsinline webkit-playsinline>
        <source src="https://antongotry.dev/wp-content/uploads/2026/01/0_Blackhole_Astrophysics_1920x1080.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="wide-container">
        <div class="grid-12 hero-grid">
            <!-- Left Side: Slogan + Cards -->
            <div class="col-5 hero-left">
                <div class="hero-slogan">
                    <h1 class="hero-main-title">SOURCE<br>OF BOLD<br>IDEAS/</h1>
                    <p class="hero-subtitle">Where brands are reborn and boundaries are erased.</p>
                </div>
                
                <!-- Cards positioned at bottom left -->
                <div class="hero-cards-container">
                    <!-- White Card - Bottom Left -->
                    <div class="hero-card hero-card-white">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="2" x2="12" y2="22"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <polyline points="8 4 4 8 8 12"/>
                                <polyline points="16 4 20 8 16 12"/>
                                <polyline points="8 20 4 16 8 12"/>
                                <polyline points="16 20 20 16 16 12"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <p class="card-text">Brands that lead forward.</p>
                            <div class="card-stat">85%</div>
                            <p class="card-subtext">Win beyond the market.</p>
                        </div>
                    </div>
                    
                    <!-- Dark Card - Closer to center-left -->
                    <div class="hero-card hero-card-dark">
                        <div class="card-icon card-icon-swirl">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                <path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9c2.12 0 4.07.74 5.62 1.97L12 8" stroke-linejoin="round"/>
                                <path d="M21 3v5h-5" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="card-text">Reload your brand.</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side: Main Title + Description + Tags -->
            <div class="col-6 col-start-7 hero-right">
                <!-- Main Title - Right Center/Above Center -->
                <h2 class="hero-title-large">WEB<br>DEVELOPMENT<br>STUDIO.</h2>
                
                <!-- Description with Arrow Icon -->
                <div class="hero-description-wrapper">
                    <p class="hero-description">Full-cycle web creation from concept to launch. Design, development, or pixel-perfect implementation — we turn visions into functional reality.</p>
                    <div class="hero-arrow-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 16l4-4-4-4M8 12h8"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Tags at Bottom Right -->
                <div class="hero-tags-section">
                    <div class="hero-branding-badge">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        <span>DESIGN</span>
                    </div>
                    <div class="hero-tags">
                        <span class="hero-tag">DESIGN + CODE</span>
                        <span class="hero-tag">MARKUP</span>
                        <span class="hero-tag">RESPONSIVE</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
