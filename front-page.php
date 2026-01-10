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
        <source src="https://antongotry.dev/wp-content/uploads/2026/01/12.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-overlay"></div>
</div>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <!-- Code Background для lens-effect -->
    <div class="hero-background" id="heroBackground">
        <pre class="code-background"><code><span class="code-keyword">function</span> <span class="code-function">createWebsite</span>(<span class="code-param">client</span>) {
    <span class="code-keyword">const</span> <span class="code-var">design</span> = <span class="code-function">design</span>();
    <span class="code-keyword">const</span> <span class="code-var">code</span> = <span class="code-function">develop</span>(design);
    <span class="code-keyword">const</span> <span class="code-var">website</span> = <span class="code-function">deploy</span>(code);
    <span class="code-keyword">return</span> website;
}

<span class="code-comment">// HTML / CSS / JS</span>
<span class="code-comment">// Адаптив + Швидкість + SEO</span>
<span class="code-comment">// Від 500 $</span></code></pre>
    </div>
    
    <!-- Lens overlay для інтерактивного ефекту -->
    <div class="hero-lens" id="heroLens"></div>
    
    <!-- Hero Content -->
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">
                <span class="gradient-text">Перетворюю код</span><br>
                у красивий дизайн
            </h1>
            <p class="hero-description">
                Створюю сучасні веб-сайти: від ідеї до запуску.<br>
                HTML/CSS/JS, адаптив, швидкість, SEO-база.<br>
                Лендинги від <strong>500 $</strong>, термін від <strong>5 днів</strong>.
            </p>
            <div class="hero-buttons">
                <a href="#contact" class="btn btn-primary" data-analytics="cta-hero-primary">
                    Отримати розрахунок
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="https://t.me/notarikon" class="btn btn-secondary" target="_blank" rel="noopener" data-analytics="cta-hero-telegram">
                    Написати в Telegram
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="hero-scroll-indicator">
        <span>Scroll</span>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M5 12l7 7 7-7"/>
        </svg>
    </div>
</section>

<?php get_footer(); ?>
