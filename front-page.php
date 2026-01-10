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
        <div class="nav-wrapper">
            <!-- Left: Logo + Hamburger -->
            <div class="nav-left">
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
            <div class="nav-center">
                <nav class="nav-links">
                    <a href="#home" class="nav-link">HOME</a>
                    <a href="#services" class="nav-link">SERVICES</a>
                    <a href="#cases" class="nav-link">CASES</a>
                </nav>
            </div>
            
            <!-- Right: Social Icons -->
            <div class="nav-right">
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
        <div class="hero-grid">
            <!-- Left Side: Slogan + Cards -->
            <div class="hero-left">
                <div class="hero-slogan">
                    <h1 class="hero-main-title">ГРАВІТАЦІЯ<br>ДИЗАЙНУ/</h1>
                    <p class="hero-subtitle">Де ваші ідеї отримують новий вимір. Виводимо бізнес на орбіту сучасних технологій.</p>
                </div>
                
                <!-- Cards positioned at bottom left -->
                <div class="hero-cards-container">
                    <!-- White Card - Bottom Left -->
                    <div class="hero-card hero-card-white">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>
                                <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/>
                                <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/>
                                <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <p class="card-text">Політ нормальний.</p>
                            <div class="card-stat">100+</div>
                            <p class="card-subtext">Успішних запусків.</p>
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
                        <p class="card-text">Запуск у орбіту.</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side: Main Title + Description + Tags -->
            <div class="hero-right">
                <!-- Main Title - Right Center/Above Center -->
                <h2 class="hero-title-large">ШВИДКІСТЬ<br>КОДУ.</h2>
                
                <!-- Description with Arrow Icon -->
                <div class="hero-description-wrapper">
                    <p class="hero-description">Створюємо веб-простір, де кожна деталь має значення. Дизайн, що притягує погляди, та розробка, що працює як годинник. Ваш запуск починається тут.</p>
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
                        <span>ЗАПУСК</span>
                    </div>
                    <div class="hero-tags">
                        <span class="hero-tag">ДИЗАЙН</span>
                        <span class="hero-tag">РОЗРОБКА</span>
                        <span class="hero-tag">ОРБІТА</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
