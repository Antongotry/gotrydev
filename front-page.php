<?php
/**
 * Template for Front Page (Home)
 * Creative Branding Agency Layout
 */

get_header(); 
?>

<!-- Header Navigation -->
<header class="top-nav">
    <div class="nav-container">
        <div class="nav-logo">
            <span class="logo-text">R=</span>
        </div>
        <nav class="nav-links">
            <a href="#home" class="nav-link">HOME</a>
            <a href="#services" class="nav-link">SERVICES</a>
            <a href="#cases" class="nav-link">CASES</a>
        </nav>
        <div class="nav-social">
            <a href="#" class="social-icon" aria-label="Instagram">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                </svg>
            </a>
            <a href="#" class="social-icon" aria-label="Facebook">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                </svg>
            </a>
        </div>
    </div>
</header>

<!-- Video Background -->
<div class="video-background" id="video-background">
    <video id="bg-video" autoplay muted loop playsinline webkit-playsinline>
        <source src="https://antongotry.dev/wp-content/uploads/2026/01/0_Blackhole_Astrophysics_1920x1080.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-overlay"></div>
</div>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-main-wrapper">
            <!-- Left Content Block -->
            <div class="hero-left-content">
                <h1 class="hero-main-title">SOURCE OF BOLD IDEAS/</h1>
                <p class="hero-subtitle">Where brands are reborn and boundaries are erased.</p>
                
                <div class="hero-cards">
                    <!-- White Card -->
                    <div class="hero-card hero-card-white">
                        <div class="card-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        <p class="card-text">Brands that lead forward.</p>
                        <div class="card-stat">85%</div>
                        <p class="card-subtext">Win beyond the market.</p>
                    </div>
                    
                    <!-- Dark Red Card -->
                    <div class="hero-card hero-card-red">
                        <div class="card-icon star-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </div>
                        <p class="card-text">Reload your brand.</p>
                        <p class="card-description">We craft bold brands with strategies built to grow and lead globally.</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Content Block -->
            <div class="hero-right-content">
                <h2 class="hero-title-large">CREATIVE<br>BRANDING<br>AGENCY.</h2>
                <p class="hero-description">We craft bold identities that stand out. From strategy to visual DNA — we help brands redefine, not just refresh.</p>
                
                <!-- Tags at bottom right -->
                <div class="hero-tags">
                    <span class="hero-tag">DIGITAL CAMPAIGNS</span>
                    <span class="hero-tag">CONTENT</span>
                    <span class="hero-tag">CREATIVE STRATEGY</span>
                    <span class="hero-tag hero-tag-branding">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        BRANDING
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
