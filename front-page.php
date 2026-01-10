<?php
/**
 * Template for Front Page (Home)
 * Konpo Studio Inspired Layout
 */

get_header(); 
?>

<!-- Header Navigation -->
<header class="top-nav" id="top-nav">
    <div class="wide-container">
        <div class="nav-wrapper">
            <!-- Left: Logo -->
            <div class="nav-left">
                <a href="/" class="logo-link">
                    <span class="logo-dots">:</span>
                    <span class="logo-text">Gotry</span>
                </a>
            </div>
            
            <!-- Right: Greeting + Hire Button -->
            <div class="nav-right">
                <span class="nav-greeting" id="greeting-text">Добрий день!</span>
                <a href="#contact" class="nav-hire-btn">
                    <span>Замовити</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 17L17 7M7 7h10v10"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="wide-container">
        <div class="hero-content">
            <!-- Main Title -->
            <h1 class="hero-main-title">
                <span class="title-line-1">Full-Stack Design</span>
                <span class="title-line-2">Agency Studio.</span>
            </h1>
            
            <!-- Description with Globe Icon -->
            <div class="hero-description">
                <svg class="globe-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="2" y1="12" x2="22" y2="12"/>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
                <p>Gotry — це plug-and-play команда досвідчених дизайнерів для тих, хто розуміє, що дизайн — це несправедлива перевага.</p>
            </div>
        </div>
        
        <!-- Project Cards -->
        <div class="projects-section">
            <div class="projects-divider"></div>
            <div class="projects-grid">
                <!-- Card 1: Surge (Gradient) -->
                <div class="project-card project-card-gradient">
                    <div class="project-card-content">
                        <span class="project-name">surge</span>
                    </div>
                </div>
                
                <!-- Card 2: ComPsych (White) -->
                <div class="project-card project-card-white">
                    <div class="project-card-content">
                        <span class="project-name project-name-dark">ComPsych</span>
                    </div>
                </div>
                
                <!-- Card 3: amp (Dark) -->
                <div class="project-card project-card-dark">
                    <div class="project-card-content">
                        <span class="project-name">amp</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
