<?php


namespace app;


class BookPostType
{
    public $post_type;
    public $templates_path;

    public function __construct()
    {
        $this->post_type = 'book';
        $file_dir_path = plugin_dir_path(__FILE__);
        $this->templates_path = str_replace('/app', '', $file_dir_path) . '/templates';

        add_action('init', array($this, 'register_post_type'));
        add_filter('template_include', array($this, 'custom_post_templates'));
    }

    public function register_post_type()
    {
        register_post_type(
            $this->post_type,
            array(
                'label' => _x('Books', 'post type label', 'eholin_books_test'),
                'labels' => array(
                    'name' => _x('Books', 'post type name', 'eholin_books_test'),
                    'singular_name' => _x('Book', 'post type singular name', 'eholin_books_test'),
                    'menu_name' => _x('Books', 'post type menu name', 'eholin_books_test'),
                    'name_admin_bar' => _x('Books', 'post type name admin bar', 'eholin_books_test'),
                    'archives' => _x('Books', 'post type archives', 'eholin_books_test'),
                    'all_items' => __('All Books', 'eholin_books_test'),
                    'add_new_item' => __('Add Book', 'eholin_books_test'),
                    'add_new' => __('Add', 'eholin_books_test'),
                    'new_item' => __('New Book', 'eholin_books_test'),
                    'edit_item' => __('Edit Book', 'eholin_books_test'),
                    'update_item' => __('Update', 'eholin_books_test'),
                    'view_item' => __('View', 'eholin_books_test'),
                    'search_items' => __('Find', 'eholin_books_test'),
                    'not_found' => __('Not found', 'eholin_books_test'),
                    'not_found_in_trash' => __('Not found in the Trash', 'eholin_books_test'),
                ),
                'description' => _x('Catalog of books ', 'description', 'eholin_books_test'),
                'public' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => false,
                'show_in_menu' => true,
                'show_in_rest' => false,
                'menu_icon' => 'dashicons-book',
                'capability_type' => 'page',
                'supports' => array('title', 'editor', 'page-attributes', 'thumbnail', 'author'),
                'has_archive' => true,
            )
        );
    }

    public function custom_post_templates($template)
    {
        if (is_singular($this->post_type) && file_exists($this->templates_path . '/single-book.php')) {
            $template = $this->templates_path . '/single-book.php';
        }


        if (is_post_type_archive($this->post_type) && file_exists($this->templates_path . '/archive-book.php')) {
            $template = $this->templates_path . '/archive-book.php';
        }

        return $template;
    }
}
