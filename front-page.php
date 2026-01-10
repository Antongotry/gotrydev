<?php
/**
 * Template for Front Page (Home)
 * AI Landing Page з Glass Distortion ефектом
 */

get_header(); 
?>

<!-- Video Background -->
<div class="video-background" id="video-background">
    <video autoplay muted loop playsinline>
        <source src="https://antongotry.dev/wp-content/uploads/2026/01/12.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-overlay"></div>
</div>

<!-- Main Content -->
<main class="hero-page">
    
    <!-- Header Navigation -->
    <header class="main-header">
        <div class="header-container">
            <div class="logo">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path d="M16 4L28 16L16 28L4 16L16 4Z" fill="url(#logoGradient)" stroke="url(#logoGradient)" stroke-width="2"/>
                    <defs>
                        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#8B5CF6"/>
                            <stop offset="100%" stop-color="#EC4899"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span>Technology Artificial Intelligence</span>
            </div>
            <nav class="main-nav">
                <a href="#home">Home</a>
                <a href="#about">About Us</a>
                <a href="#services">Services</a>
                <a href="#page">Page</a>
                <a href="#blog">Blog</a>
            </nav>
            <div class="header-actions">
                <button class="icon-btn" title="Sign In">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </button>
                <button class="icon-btn" title="Settings">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M12 1v6m0 6v6M5.64 5.64l4.24 4.24m4.24 4.24l4.24 4.24M1 12h6m6 0h6M5.64 18.36l4.24-4.24m4.24-4.24l4.24-4.24"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Harnessing the Power of<br>
                    <span class="gradient-text">Artificial Intelligence</span>
                </h1>
                <p class="hero-description">
                    Whether you are looking to optimize your operations, create intelligent products, or gain a competitive edge
                </p>
                <div class="hero-buttons">
                    <a href="#get-started" class="btn btn-primary">
                        Get Started 
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#contact" class="btn btn-secondary">Contact Us</a>
                </div>
            </div>

            <!-- Glass Cards -->
            <div class="hero-cards">
                <div class="glass-card card-1">
                    <div class="card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3 class="card-title">AI Solutions</h3>
                    <p class="card-text">Our solutions are tailored to meet the unique needs...</p>
                    <div class="card-dots">⋯</div>
                </div>

                <div class="glass-card card-2">
                    <div class="card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3 class="card-title">AI Ethics and Responsibility</h3>
                    <div class="card-icons">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>

                <div class="glass-card card-3">
                    <div class="card-image">
                        <div class="spiral-pattern"></div>
                    </div>
                    <h3 class="card-title">Future of AI Technology</h3>
                    <p class="card-text">Whether you are looking to optimize your operations, create intelligent products</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <h3 class="stat-label">AI-DRIVEN EXCELLENCE</h3>
            </div>
            <div class="stat-item">
                <div class="stat-value">295,4K+</div>
                <div class="stat-text">Experience Power AI</div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
