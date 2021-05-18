<?php

namespace app\metabox;

/**
 * Class MetaBoxTextarea
 * @package app\metabox
 */
class MetaBoxTextarea extends MetaBox
{

    /**
     * @param $post
     * @param $meta
     * @return mixed|void
     */
    public function meta_box_callback($post, $meta)
    {
        $meta_value = get_post_meta($post->ID, $this->meta_name, true);

        wp_nonce_field('metabox_' . $this->meta_name . '_nonce', 'metabox_' . $this->meta_name . '_nonce');

        echo '<label class="screen-reader-text test-books__label" for="' . $this->meta_name . '">' . $this->meta_name_label . '</label> ';
        echo '<textarea class="test-books__textarea" id="' . $this->meta_name . '" name="' . $this->meta_name . '_field" rows="1" cols="40">' . esc_textarea(
                $meta_value
            ) . '</textarea>';
    }

    /**
     * @param $data
     * @return mixed
     */
    public function validate_meta_data($data)
    {
        return sanitize_textarea_field($data);
    }

}
