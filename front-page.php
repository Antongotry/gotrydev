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
                
                <!-- About/Credibility Section -->
                <section class="about-credibility-section">
                    <div class="about-headline">
                        <span class="headline-main">Lean, fast, and ruthless about world-class standards, Gotry is built for companies that define categor</span><span class="headline-fade">ies.</span>
                    </div>
                    <div class="about-tagline">The design studio with actual agency.</div>
                    <div class="about-divider"></div>
                    <div class="about-content-wrapper">
                        <div class="about-content">
                            <p class="about-paragraph">
                                Since 2020, I've partnered with <span class="about-link">Startups</span>, <span class="about-link">Agencies</span>, <span class="about-link">Freelance Clients</span>, handled full-code development for <span class="about-link">SaaS Products</span>, designed and built <span class="about-link">Brand Systems</span>, created products with <span class="about-link">No-code Tools</span> and <span class="about-link">Custom Solutions</span>.
                            </p>
                            <p class="about-paragraph">
                                Actively used by clients and widely loved by my collective mothers, my work has been recognized by the folks from <span class="about-link">Awwwards</span> and <span class="about-link">CSS Design Awards</span>, survived the critics at <span class="about-link">Product Hunt</span>, talked about in the obscure corners of <span class="about-link">HackerNews</span>, featured on <span class="about-link">Behance</span> and smiled from the top of <span class="about-link">Dribbble</span>.
                            </p>
                            <p class="about-paragraph-short">I live at the intersection of design, code and product.</p>
                        </div>
                        <div class="about-logos">
                        <!-- FWA Logo -->
                        <div class="about-logo-item">
                            <svg width="48" height="24" viewBox="0 0 48 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 2H6V22H2V2Z" fill="currentColor"/>
                                <path d="M6 2H12V6H6V2Z" fill="currentColor"/>
                                <path d="M6 10H12V14H6V10Z" fill="currentColor"/>
                                <path d="M16 2H24V6H16V2Z" fill="currentColor"/>
                                <path d="M16 10H24V14H16V10Z" fill="currentColor"/>
                                <path d="M16 14H24V18H16V14Z" fill="currentColor"/>
                                <path d="M28 2H36V6H28V2Z" fill="currentColor"/>
                                <path d="M28 10H36V14H28V10Z" fill="currentColor"/>
                                <path d="M28 14H36V18H28V14Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <!-- Awwwards Logo (W.) -->
                        <div class="about-logo-item">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <text x="4" y="24" font-family="Arial, sans-serif" font-size="20" font-weight="900" fill="currentColor">W.</text>
                            </svg>
                        </div>
                        <!-- Webby Awards Logo (Globe with stripes) -->
                        <div class="about-logo-item">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="16" cy="16" r="11" stroke="currentColor" stroke-width="1.2" fill="none"/>
                                <ellipse cx="16" cy="16" rx="11" ry="5.5" stroke="currentColor" stroke-width="1.2" fill="none"/>
                                <ellipse cx="16" cy="16" rx="11" ry="5.5" stroke="currentColor" stroke-width="1.2" fill="none" transform="rotate(90 16 16)"/>
                                <circle cx="16" cy="16" r="1.5" fill="currentColor"/>
                            </svg>
                        </div>
                        <!-- Apple Logo -->
                        <div class="about-logo-item">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.2 6.4C20.6 6.8 19.6 7.4 18.6 7.3C18.4 5.7 19 4.4 19.4 3.6C20.2 2.6 21.2 2 21.8 2C22.8 2 23.6 2.6 24.2 2.6C24.7 2.6 25.8 1.8 27 2C28.1 2.2 29 2.8 29.5 3.6C28.4 4.2 27.6 5.2 27.6 6.4C27.6 7.6 28.4 8.6 29.4 9.2C28.9 9.8 28.3 10.5 27.4 11.4C26.2 12.5 25.2 13.8 23.8 13.8C22.8 13.8 22.2 13.2 21 13.2C19.7 13.2 19 13.8 18 13.8C16.6 13.8 15.6 12.5 14.5 11.4C13.1 10 11.8 8.4 12.2 6.6C12.4 5.2 13.2 4.2 14.2 3.6C15.3 3 16.4 3.4 17 3.6C17.4 3.4 18.6 2.8 20 2.8C20.4 2.8 20.9 2.9 21.2 3.2C21.8 3.4 22.6 4.2 23 5C22.6 5.2 22 5.8 21.2 6.4Z" fill="currentColor"/>
                                <path d="M22.8 16.4C22.6 18.6 24.4 20.4 26.6 20.6C26.8 22.8 24.9 24.7 22.8 24.9C20.6 25.1 18.8 23.3 18.8 21.1C19.6 18.9 21.4 17.1 22.8 16.4Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <!-- CSS Design Awards Logo (Comb) -->
                        <div class="about-logo-item">
                            <svg width="24" height="32" viewBox="0 0 24 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="8" y="4" width="8" height="24" rx="0.5" fill="currentColor"/>
                                <rect x="9" y="6" width="6" height="1.5" fill="none" stroke="currentColor" stroke-width="0.3" opacity="0.3"/>
                                <rect x="9" y="9" width="6" height="1.5" fill="none" stroke="currentColor" stroke-width="0.3" opacity="0.3"/>
                                <rect x="9" y="12" width="6" height="1.5" fill="none" stroke="currentColor" stroke-width="0.3" opacity="0.3"/>
                                <rect x="9" y="15" width="6" height="1.5" fill="none" stroke="currentColor" stroke-width="0.3" opacity="0.3"/>
                                <rect x="9" y="18" width="6" height="1.5" fill="none" stroke="currentColor" stroke-width="0.3" opacity="0.3"/>
                                <rect x="9" y="21" width="6" height="1.5" fill="none" stroke="currentColor" stroke-width="0.3" opacity="0.3"/>
                                <rect x="9" y="24" width="6" height="1.5" fill="none" stroke="currentColor" stroke-width="0.3" opacity="0.3"/>
                            </svg>
                        </div>
                        <!-- Chevron/Arrow Logo -->
                        <div class="about-logo-item">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12L16 6L22 12M10 20L16 26L22 20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
</div>

<?php get_footer(); ?>
