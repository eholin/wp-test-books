<?php


namespace app;


class Book
{

    public $book_id;
    public $book;

    public function __construct($book_id)
    {
        if (!$book_id) {
            throw new \Exception('ID is required');
        }

        $this->book_id = $book_id;
        $this->book = get_post($book_id);
    }

    public function get_thumbnail($size = null, $attr = null)
    {
        return get_the_post_thumbnail($this->book_id, $size, $attr);
    }

    public function get_permalink()
    {
        return get_the_permalink($this->book_id);
    }

    public function get_title()
    {
        return $this->book->post_title;
    }

    public function get_short_description()
    {
        return get_post_meta($this->book_id, 'short_description', true);
    }

    public function get_authors()
    {
        return get_post_meta($this->book_id, 'authors', true);
    }

    public function get_publishing_house()
    {
        return get_post_meta($this->book_id, 'publishing', true);
    }

    public function get_date_issue()
    {
        return get_post_meta($this->book_id, 'date_issue', true);
    }

}
