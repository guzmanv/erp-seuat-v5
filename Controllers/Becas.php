<?php

class Becas extends Controllers{

    public function __construct()
    {
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
            die();
        }
    }

    public function becas(){
        $data['page_tag'] = "Catálogo de becas";
        $data['page_title'] = "Catálogo de becas";
        $data['page_name'] = "Catálogo de becas";
        $this->views->getView($this,"becas",$data);
    }
}