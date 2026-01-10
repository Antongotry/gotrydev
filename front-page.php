<?php
/**
 * Template for Front Page (Home)
 * Konpo Studio Inspired Layout
 */

get_header(); 
?>

<!-- Main Grid Container -->
<div class="main-grid" id="main-grid">
    <!-- Left Sidebar - Contains Hamburger and Scroll Indicator -->
    <div class="header-side" id="header-side">
        <!-- Hamburger Menu Button - Top of Sidebar -->
        <button class="hamburger-menu" id="hamburger-menu" aria-label="Menu">
            <div></div>
            <div></div>
            <div></div>
            <p class="hamburger-hint">hover & hold me down</p>
        </button>
        
        <!-- Right vertical line that goes down from hamburger -->
        <div class="sidebar-right-line"></div>
        
        <!-- Scroll Indicator - Inside Sidebar -->
        <div class="scroll-indicator">
            <div class="scroll-dot scroll-dot-top"></div>
            <div class="scroll-line"></div>
        </div>
    </div>
    
    <!-- Header Navigation - At main-grid level, fixed at top right -->
    <header class="top-nav" id="top-nav">
        <!-- Logo - Left Edge of Header -->
        <div class="header-logo">
            <a href="/" class="logo-link">
                <img src="https://antongotry.dev/wp-content/uploads/2026/01/dark-1d-logo.svg" alt="Gotry Logo" class="logo-img">
            </a>
        </div>
        
        <!-- Spacer - fills space between logo and right content -->
        <div class="header-spacer"></div>
        
        <!-- Right Content - Greeting + Button (Right Edge) -->
        <div class="header-right">
            <span class="nav-greeting" id="greeting-text">Добрий вечір!</span>
            <a href="#contact" class="nav-hire-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7 17L17 7M7 7h10v10"/>
                </svg>
                <span>Замовити</span>
            </a>
        </div>
        
        <!-- Header divider line - positioned at bottom of entire header (top-nav) -->
        <div class="header-divider"></div>
    </header>
    
    <!-- Main Content Area - Right Side (Working Area) - Starts below header -->
    <div class="main-content">
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
                    
                    <!-- Globe Icon - centered -->
                    <div class="hero-globe-wrapper">
                        <svg class="globe-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                    
                    <!-- Description - centered below globe -->
                    <p class="hero-description">Gotry is a plug-and-play crew of seasoned designers, for CXOs that know design is an unfair advantage.</p>
                </div>
                
                <!-- Project Cards -->
                <div class="projects-section">
                    <div class="projects-divider"></div>
                    <div class="projects-grid">
                        <!-- Card 1: Surge (Gradient) -->
                        <div class="project-card project-card-gradient">
                            <div class="project-card-content project-card-top-right">
                                <span class="project-type">Brand • Site • System</span>
                                <span class="project-name">surge<sup class="project-sup">AI</sup></span>
                            </div>
                            <div class="project-card-bottom-left">
                                <span class="project-name project-name-large">ChatGPT</span>
                            </div>
                        </div>
                        
                        <!-- Card 2: ComPsych (White) -->
                        <div class="project-card project-card-white">
                            <div class="project-card-content project-card-top-right">
                                <span class="project-type project-type-dark">Brand</span>
                                <div class="project-logo-wrapper">
                                    <svg class="project-logo" width="32" height="32" viewBox="0 0 32 32" fill="#2563eb">
                                        <path d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14 14-6.268 14-14S23.732 2 16 2zm0 24c-5.523 0-10-4.477-10-10S10.477 6 16 6s10 4.477 10 10-4.477 10-10 10zm0-16c-3.314 0-6 2.686-6 6s2.686 6 6 6 6-2.686 6-6-2.686-6-6-6z"/>
                                    </svg>
                                </div>
                                <span class="project-name project-name-dark">ComPsych</span>
                            </div>
                        </div>
                        
                        <!-- Card 3: amp (Dark) -->
                        <div class="project-card project-card-dark">
                            <div class="project-card-content project-card-top-right">
                                <span class="project-type">Product</span>
                                <svg class="project-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
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
