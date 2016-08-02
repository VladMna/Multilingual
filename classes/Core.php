<?php

class Core {
    public $objLanguage;
    public $lang_menu;

    public $objUrl;
    public $objNavigation;

    public $objAdmin;
    public $admin;

    public $navigation;

    public $navigation1;
    public $navigation2;
    public $navigation3;

    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    public $content;
    public $column;

    public $script;



    public function run(){

        $this->objLanguage = new Language();
        $this->lang_menu = Helper::getPlug(
            'language',
            array('objLanguage' => $this->objLanguage)
        );

        $this->objUrl = new Url();
        $this->objNavigation = new Navigation($this->objUrl, $this->objLanguage);


        switch($this->objUrl->module){
            case 'panel':
                set_include_path(implode(PATH_SEPARATOR, array(
                    realpath(TEMPLATE_PATH.DS.'admin'),
                    get_include_path()
                )));
                $this->runAdmin();
            break;
            default:
                set_include_path(implode('PATH_SEPARATOR', array(
                    realpath(TEMPLATE_PATH.DS.'front'),
                    get_include_path()
                    )));
                $this->runFront();

        }
    }
}