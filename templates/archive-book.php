<?php
/**
 * The template for displaying books archive
 *
 */

get_header();

$description = get_the_archive_description();

if (have_posts()) { ?>


    <header class="page-header alignwide">
        <?php
        the_archive_title('<h1 class="page-title">', '</h1>'); ?>
        <?php
        if ($description) { ?>
            <div class="archive-description"><?php
                echo wp_kses_post(wpautop($description)); ?></div>
            <?php
        } ?>
    </header><!-- .page-header -->

    <?php
    while (have_posts()) {
        the_post(); ?>
        <article id="post-<?php
        the_ID(); ?>" <?php
        post_class(); ?>>

        <?php
        $book_id = get_the_ID();
        $book = new \app\Book($book_id);
        $title = $book->get_title();
        $permalink = $book->get_permalink();
        $thumbnail = $book->get_thumbnail(array('150', '150'));

        ?>
        <header class="entry-header">
            <h2 class="entry-title default-max-width">
                <a class="book-title" href="<?php
                echo $permalink; ?>" title="<?php
                echo $title; ?>">
                    <?php
                    echo $thumbnail;
                    echo $title; ?>
                </a>
            </h2>
        </header>
        <div class="entry-content">
            <p>
                <?php
                echo $book->get_short_description(); ?>
            </p>
        </div>
        <footer class="entry-footer default-max-width">
            <div class="meta-field authors">
                <?php
                echo $book->get_authors(); ?>
            </div>
            <div class="meta-field date-issue">
                <?php
                echo $book->get_date_issue(); ?>
            </div>
        </footer><!-- .entry-footer -->

        <?php
    } ?>
    </article>
    <?php
} ?>

<?php
get_footer(); ?>
