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


<?php if (!is_front_page()): ?>
<header class="site-header">
    <!-- Нічого тут немає -->
</header>
<?php endif; ?>
