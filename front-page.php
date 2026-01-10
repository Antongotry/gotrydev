<?php
/**
 * Template for Front Page (Home)
 * Web Development Studio Layout
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
                    <a href="https://www.instagram.com/antongotry?igsh=bmFzdHpqb2RnM2Zj" class="social-icon" aria-label="Instagram" target="_blank" rel="noopener">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>
                    <a href="https://t.me/notarikon" class="social-icon" aria-label="Telegram" target="_blank" rel="noopener">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
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
                    <h1 class="hero-main-title">CODE<br>MEETS<br>DESIGN/</h1>
                    <p class="hero-subtitle">Where ideas become pixels and pixels become experiences.</p>
                </div>
                
                <!-- Cards positioned at bottom left -->
                <div class="hero-cards-container">
                    <!-- White Card - Bottom Left -->
                    <div class="hero-card hero-card-white">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                <line x1="8" y1="21" x2="16" y2="21"/>
                                <line x1="12" y1="17" x2="12" y2="21"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <p class="card-text">Sites that perform.</p>
                            <div class="card-stat">100+</div>
                            <p class="card-subtext">Projects delivered.</p>
                        </div>
                    </div>
                    
                    <!-- Dark Card - Closer to center-left -->
                    <div class="hero-card hero-card-dark">
                        <div class="card-icon card-icon-swirl">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6"/>
                                <polyline points="8 6 2 12 8 18"/>
                            </svg>
                        </div>
                        <p class="card-text">Design to code.</p>
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
