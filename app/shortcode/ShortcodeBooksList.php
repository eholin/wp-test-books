<?php


namespace app\shortcode;


class ShortcodeBooksList
{
    public $post_type;
    public $description_length;

    function __construct()
    {
        $this->post_type = 'book';
        $this->description_length = 120;

        add_shortcode('test_books_list', array($this, 'shortcode'));

        add_action('wp_enqueue_scripts', array($this, 'frontend_enqueue_scripts'));
        add_action('wp_footer', array($this, 'shortcode_js'));
    }

    function shortcode($atts = array())
    {
        extract(
            shortcode_atts(
                array(
                    'limit' => '5'
                ),
                $atts
            )
        );

        $content = '';

        $args = array(
            'post_type' => $this->post_type,
            'posts_per_page' => $limit,
            'post_status ' => 'publish'
        );

        $the_query = new \WP_Query($args);

        if ($the_query->have_posts()) {
            $content .= '<div class="books-shortcode">';
            while ($the_query->have_posts()) {
                $the_query->the_post();

                $book_id = get_the_ID();
                $book = new \app\Book($book_id);
                $title = $book->get_title();
                $permalink = $book->get_permalink();
                $thumbnail = $book->get_thumbnail(array('75', '75'));
                $description = $book->get_short_description();
                $short_description = $this->truncate_description($description);


                $content .= '<div class="books-shortcode__item">';

                $content .= '<div class="books-shortcode__header">';
                $content .= '<a class="books-shortcode__title" href="' . $permalink . '" title="' . $title . '">' . $thumbnail . $title . '</a>';
                $content .= '</div>';

                $content .= '<div class="books-shortcode__content">' . $short_description . '</div>';

                $content .= '<div class="books-shortcode__footer">';
                $content .= '<div class="books-shortcode__footer-meta">' . __(
                        'ID',
                        'eholin_books_test'
                    ) . ': ' . $book_id . '</div>';
                $content .= '<div class="books-shortcode__footer-meta">' . __(
                        'Authors',
                        'eholin_books_test'
                    ) . ': ' . $book->get_authors() . '</div>';
                $content .= '<div class="books-shortcode__footer-meta">' . __(
                        'Date of Issue',
                        'eholin_books_test'
                    ) . ': ' . $book->get_date_issue() . '</div>';
                $content .= '<div class="books-shortcode__footer-meta">' . __(
                        'Publishing House Name',
                        'eholin_books_test'
                    ) . ': ' . $book->get_publishing_house() . '</div>';
                $content .= '</div>';
            }
            $content .= '</div>';

            $content .= '</div>';
        }
        wp_reset_postdata();

        return $content;
    }

    private function truncate_description($description)
    {
        $str = strip_tags($description);

        if (strlen($str) > $this->description_length) {
            $short = substr($str, 0, $this->description_length);
            $short = rtrim($short, '!,.-');
            $short = substr($short, 0, strrpos($short, ' '));
            $next = substr($str, strlen($short));

            $description = '<span class="text-short">' . $short . '</span><span class="text-ellipsis">...</span><span class="text-next">' . $next . '</span>';
            $description .= '<a href="javascript:void(0);" class="text-more">';
            $description .= __('Read more!', 'eholin_books_test');
            $description .= '</a>';
        }

        return $description;
    }

    public function frontend_enqueue_scripts()
    {
        wp_enqueue_script('jquery');
    }

    public function shortcode_js()
    {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                'use strict';

                $(document).on('click', '.text-more', function (e) {
                    e.preventDefault();
                    let $more = $(this),
                        $description = $more.closest('.books-shortcode__content'),
                        $next = $description.find('.text-next'),
                        $ellipsis = $description.find('.text-ellipsis');

                    $more.css('display', 'none');
                    $ellipsis.css('display', 'none');
                    $next.css('display', 'inline');
                });
            });
        </script>
        <?php
    }

}
