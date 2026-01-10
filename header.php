<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="icon" type="image/webp" href="https://antongotry.dev/wp-content/uploads/2026/01/favicon-2_result.webp">
    <link rel="shortcut icon" type="image/webp" href="https://antongotry.dev/wp-content/uploads/2026/01/favicon-2_result.webp">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if (is_front_page()): ?>
<!-- Preloader - Карточки как колода -->
<div class="preloader" id="preloader">
    <div class="preloader-cards-stack" id="preloader-cards-stack">
        <!-- Card 1: Surge (Gradient) -->
        <div class="preloader-card preloader-card-gradient" data-card-index="0">
            <div class="project-card-content project-card-top-right">
                <span class="project-type">Brand • Site • System</span>
                <span class="project-name">surge<sup class="project-sup">AI</sup></span>
            </div>
            <div class="project-card-bottom-left">
                <span class="project-name project-name-large">ChatGPT</span>
            </div>
        </div>
        
        <!-- Card 2: ComPsych (White) -->
        <div class="preloader-card preloader-card-white" data-card-index="1">
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
        <div class="preloader-card preloader-card-dark" data-card-index="2">
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
<?php endif; ?>

<?php if (!is_front_page()): ?>
<header class="site-header">
    <!-- Нічого тут немає -->
</header>
<?php endif; ?>
