<?php


namespace app\metabox;


class MetaBoxDate extends MetaBox
{

    public function __construct($args = array())
    {
        parent::__construct($args);

        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('admin_footer', array($this, 'init_datepicker'));
    }

    public function admin_enqueue_scripts()
    {
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('jqueryui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', false, null);
    }

    public function init_datepicker()
    {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                'use strict';
                $.datepicker.setDefaults({
                    dateFormat: 'dd.mm.yy',
                    firstDay: 1,
                    showAnim: 'slideDown',
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''
                });

                $('input[name="<?php echo $this->meta_name . '_field';?>"], .datepicker').datepicker();
            });
        </script>
        <?php
    }

    /**
     * @param $data
     * @return mixed
     */
    public function validate_meta_data($data)
    {
        return sanitize_text_field($data);
    }


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
        echo '<input class="test-books__input" id="' . $this->meta_name . '" name="' . $this->meta_name . '_field" value="' . esc_attr(
                $meta_value
            ) . '" />';
    }
}
