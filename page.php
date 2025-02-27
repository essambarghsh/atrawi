<?php
/**
 * The template for displaying all pages
 *
 * @package Atrawi
 * @since 1.0.0
 */

get_header();
?>

<main class="container mx-auto px-4 py-8">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="page-<?php the_ID(); ?>" <?php post_class('bg-white shadow-md p-6'); ?>>
            <header class="mb-6">
                <h1 class="text-2xl font-bold"><?php the_title(); ?></h1>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-6">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-auto']); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();