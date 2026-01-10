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
        <source src="https://antongotry.dev/wp-content/uploads/2026/01/0_Blackhole_Astrophysics_1920x1080.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-overlay"></div>
</div>

<!-- Hero Section (як на референсі) -->
<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-main-wrapper">
            <!-- Ліва частина: Основний контент -->
            <div class="hero-left-section">
                <p class="hero-subtitle">Від ідеї до запуску</p>
                <h1 class="hero-title">
                    <span class="gradient-text">Перетворюю код</span><br>
                    у красивий дизайн
                </h1>
                
                <div class="hero-cta-wrapper">
                    <a href="#contact" class="btn btn-primary" data-analytics="cta-hero-primary">
                        Отримати безкоштовну консультацію
                    </a>
                    <div class="cta-arrow">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <p class="cta-description">
                        Залиште заявку зараз і отримайте безкоштовну 30-хвилинну консультацію.
                    </p>
                </div>
                
                <!-- Статистичні картки зліва внизу (як на референсі) -->
                <div class="hero-stats-bottom">
                    <div class="hero-stat-card-bottom">
                        <span class="stat-number-large gradient-text">50+</span>
                        <span class="stat-label">проектів</span>
                        <p class="stat-description">Реалізовано для клієнтів у 15+ країнах</p>
                    </div>
                    <div class="hero-stat-card-bottom">
                        <span class="stat-number-large gradient-text">30+</span>
                        <span class="stat-label">послуг</span>
                        <p class="stat-description">Від дизайну до розробки та SEO</p>
                    </div>
                </div>
            </div>
            
            <!-- Права частина: Біла картка з інформацією (як на референсі) -->
            <div class="hero-right-section">
                <div class="hero-info-card">
                    <div class="info-card-image">
                        <!-- Тут буде відео або зображення -->
                        <video class="info-video" autoplay muted loop playsinline>
                            <source src="#" type="video/mp4">
                        </video>
                    </div>
                    <div class="info-card-content">
                        <span class="info-budget gradient-text">$500+</span>
                        <span class="info-label">бюджет проекту</span>
                        <div class="info-divider">+</div>
                        <p class="info-text">
                            Як створити сайт без перевитрат та отримати результат за мінімальний термін.
                        </p>
                        <div class="info-avatars">
                            <span class="avatar" style="background-image: url('https://i.pravatar.cc/100?img=1');"></span>
                            <span class="avatar" style="background-image: url('https://i.pravatar.cc/100?img=3');"></span>
                            <span class="avatar" style="background-image: url('https://i.pravatar.cc/100?img=8');"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
