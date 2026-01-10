<?php
/**
 * Main Template File
 * Для всіх інших сторінок окрім головної
 */

get_header(); 
?>

<main id="main" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
        
        // Навігація по сторінках
        the_posts_navigation();
        
    else :
        ?>
        <p><?php _e('No content found', 'gotry'); ?></p>
        <?php
    endif;
    ?>
</main>

<?php get_footer(); ?>

