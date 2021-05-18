<?php
/**
 * Plugin Name: Каталог книг
 * Plugin URI: https://github.com/eholin/wp-test-books
 * Description: Тестовый плагин для управления каталогом книг.
 * Version: 1.0.0
 * Author: Eugene Holin
 * Author URI: https://github.com/eholin
 * License: GPL2
 */

$plugin_dir = plugin_dir_path(__FILE__);
$plugin_url = plugin_dir_url(__FILE__);

require_once $plugin_dir . 'vendor/autoload.php';

add_action(
    'admin_enqueue_scripts',
    function () use ($plugin_url) {
        wp_enqueue_style('test-books-admin', $plugin_url . 'css/test-books-admin.css');
    },
    99
);

add_action(
    'wp_enqueue_scripts',
    function () use ($plugin_url) {
        wp_enqueue_style('test-books-front', $plugin_url . 'css/test-books-front.css');
    },
    99
);

new \app\BookPostType();

new \app\metabox\MetaBoxTextarea(
    array(
        'meta_name' => 'short_description',
        'meta_name_label' => __('Short Description', 'eholin_books_test'),
        'post_type' => 'book',
        'priority' => 'high'
    )
);

new \app\metabox\MetaBoxTextarea(
    array(
        'meta_name' => 'authors',
        'meta_name_label' => __('Authors', 'eholin_books_test'),
        'post_type' => 'book',
    )
);

new \app\metabox\MetaBoxTextarea(
    array(
        'meta_name' => 'publishing',
        'meta_name_label' => __('Publishing House Name', 'eholin_books_test'),
        'post_type' => 'book',
    )
);

new \app\metabox\MetaBoxDate(
    array(
        'meta_name' => 'date_issue',
        'meta_name_label' => __('Date of Issue', 'eholin_books_test'),
        'post_type' => 'book',
    )
);

new \app\shortcode\ShortcodeBooksList();
