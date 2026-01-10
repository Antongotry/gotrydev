<?php
/**
 * Template for Front Page (Home)
 * Konpo Studio Inspired Layout
 */

get_header(); 
?>

<!-- Main Grid Container -->
<div class="main-grid" id="main-grid">
    <!-- Left Sidebar with Scroll Indicator -->
    <div class="header-side" id="header-side">
        <!-- Scroll Indicator - vertical line with dot at top -->
        <div class="scroll-indicator">
            <div class="scroll-dot scroll-dot-top"></div>
            <div class="scroll-line"></div>
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Header Navigation -->
        <header class="top-nav" id="top-nav">
            <div class="wide-container">
                <div class="nav-wrapper">
                    <!-- Left: Logo with dots -->
                    <div class="nav-left">
                        <a href="/" class="logo-link">
                            <span class="logo-dots">
                                <span class="dot-row">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </span>
                                <span class="dot-row">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </span>
                            </span>
                            <span class="logo-text">Gotry</span>
                        </a>
                    </div>
                    
                    <!-- Right: Greeting + Hire Button -->
                    <div class="nav-right">
                        <span class="nav-greeting" id="greeting-text">Добрий вечір!</span>
                        <a href="#contact" class="nav-hire-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7 17L17 7M7 7h10v10"/>
                            </svg>
                            <span>Замовити</span>
                        </a>
                    </div>
                </div>
                <!-- Header divider line -->
                <div class="header-divider"></div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero-section" id="hero">
            <div class="wide-container">
                <div class="hero-content">
                    <!-- Main Title -->
                    <h1 class="hero-main-title">
                        <span class="title-line-1">Full-Stack Design</span>
                        <span class="title-line-2">
                            <span class="strikethrough-text">Agency</span> Studio.
                        </span>
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
                                <span class="project-name">surge<sup class="project-sup">AI</sup></span>
                            </div>
                        </div>
                        
                        <!-- Card 2: ComPsych (White) -->
                        <div class="project-card project-card-white">
                            <div class="project-card-content">
                                <div class="project-logo">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#2563eb">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <span class="project-name project-name-dark">ComPsych</span>
                            </div>
                        </div>
                        
                        <!-- Card 3: amp (Dark) -->
                        <div class="project-card project-card-dark">
                            <div class="project-card-content">
                                <svg class="project-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                                </svg>
                                <span class="project-name">amp</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php get_footer(); ?>
