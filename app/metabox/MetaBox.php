<?php


namespace app\metabox;

/**
 * Class MetaBox
 * @package app\metabox
 */
abstract class MetaBox
{
    public $meta_name;
    public $meta_name_label;
    public $post_type;
    public $context;
    public $priority;

    /**
     * @param $data
     * @return mixed
     */
    abstract public function validate_meta_data($data);

    /**
     * @param $post
     * @param $meta
     * @return mixed
     */
    abstract public function meta_box_callback($post, $meta);

    /**
     * MetaBox constructor.
     * @param array $args
     * @throws \Exception
     */
    public function __construct($args = array())
    {
        if (count($args) == 0) {
            throw new \Exception('Metabox arguments are required');
        }

        if (!isset($args['meta_name'])) {
            throw new \Exception('Argument "meta_name" is required');
        }

        if (!isset($args['meta_name_label'])) {
            throw new \Exception('Argument "meta_name_label" is required');
        }

        if (!isset($args['post_type'])) {
            throw new \Exception('Argument "post_type" is required');
        }

        $this->meta_name = $args['meta_name'];
        $this->meta_name_label = $args['meta_name_label'];
        $this->post_type = $args['post_type'];
        $this->context = (isset($args['context'])) ? $args['context'] : 'normal';
        $this->priority = (isset($args['priority'])) ? $args['priority'] : 'default';

        add_action('add_meta_boxes', array($this, 'meta_box_register'));
        add_action('save_post', array($this, 'meta_box_save'));
    }

    public function meta_box_register()
    {
        add_meta_box(
            $this->meta_name . '_metabox',
            $this->meta_name_label,
            array($this, 'meta_box_callback'),
            $this->post_type,
            $this->context,
            $this->priority
        );
    }

    /**
     * @param $post_id
     */
    public function meta_box_save($post_id)
    {
        $nonce_field = 'metabox_' . $this->meta_name . '_nonce';

        if (!isset($_POST[$nonce_field])) {
            return;
        }

        $nonce = $_POST[$nonce_field];

        if (!wp_verify_nonce($nonce, $nonce_field)) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['post_type']) && $_POST['post_type'] == $this->post_type) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        $meta_raw = $_POST[$this->meta_name . '_field'];
        $meta_validated = $this->validate_meta_data($meta_raw);

        update_post_meta($post_id, $this->meta_name, $meta_validated);
    }
}
