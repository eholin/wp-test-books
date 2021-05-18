<?php


namespace app;


class InitPlugin
{
    public $plugin_dir_path;
    public $plugin_dir_url;

    public function __construct()
    {
        $this->plugin_dir_path = plugin_dir_path( __FILE__ );
        $this->plugin_dir_url = plugin_dir_url( __FILE__ );


    }

}
