<?php

class MedioCaptacion extends Controllers{

    function __construct()
    {
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
            die();
        }
    }

    public function MedioCaptacion(){
        $data['page_tag'] = "Medios de captación";
        $data['page_title'] = "Medios de captación";
        $data['page_name'] = "medio_captacion";
        $data['page_functions_js'] = "functions_mediocaptacion.js";
        $this->views->getView($this,"mediocaptacion",$data);
    }

    public function getMediosCaptacion(){
        
    }
}