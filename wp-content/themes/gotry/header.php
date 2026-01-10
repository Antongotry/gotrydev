<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
    <?php if (is_front_page()): ?>
    <!-- THREE.js завантажується безпосередньо в HEAD для головної -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js"></script>
    <?php endif; ?>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Порожній header - без меню, логотипу, навігації -->
<header class="site-header">
    <!-- Нічого тут немає -->
</header>
