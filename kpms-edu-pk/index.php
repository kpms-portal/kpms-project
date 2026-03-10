<?php
/**
 * KPMS Redesign Theme - Fallback Template
 * WordPress requires index.php in every theme.
 * All pages use custom page templates registered in functions.php.
 */
get_header();
?>
<main style="max-width:800px;margin:80px auto;padding:20px;font-family:'DM Sans',sans-serif;text-align:center;">
    <h1 style="color:#003087;">Kamal Public Middle School</h1>
    <p style="color:#4a5e7a;">This page is using the default template. Please assign a KPMS page template in the WordPress editor.</p>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <h2><?php the_title(); ?></h2>
            <div><?php the_content(); ?></div>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
