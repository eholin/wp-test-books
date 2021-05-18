<?php
/**
 * The template for displaying single book post
 *
 */

get_header();

/* Start the Loop */
while (have_posts()) :
    the_post();

    $book_id = get_the_ID();
    $book = new \app\Book($book_id);

    ?>
    <article id="post-<?php
    the_ID(); ?>" <?php
    post_class(); ?>>

        <header class="entry-header alignwide">
            <h1 class="entry-title">
                <?php
                echo $book->get_title(); ?>
            </h1>
            <?php
            echo $book->get_thumbnail(); ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            the_content();
            ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer default-max-width">
            <div class="meta-field short-description">
                <?php
                echo $book->get_short_description(); ?>
            </div>
            <div class="meta-field authors">
                <?php
                echo $book->get_authors(); ?>
            </div>
            <div class="meta-field publishing-house">
                <?php
                echo $book->get_publishing_house(); ?>
            </div>
            <div class="meta-field date-issue">
                <?php
                echo $book->get_date_issue(); ?>
            </div>
        </footer><!-- .entry-footer -->

    </article>

    <?php

    // If comments are open or there is at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) {
        comments_template();
    }

endwhile; // End of the loop.

get_footer();
