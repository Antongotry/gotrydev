<?php
/**
 * Template for Front Page (Home)
 * AI Landing Page з Video Background
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

<!-- Hero Section -->
<section class="hero-section">
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
</section>

<?php get_footer(); ?>
