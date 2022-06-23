<?php
class RenovacionBecas extends Controllers{
    public function __construct(){
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
            die();
        }
    }

    public function asignacion_becas()
    {
        $data['page_tag'] = 'Asignación becas';
        $data['page_name'] = 'Asignación becas';
        $data['page_title'] = 'Asignación becas';
        //$data['page_functions_js'] = 'functions_turnos.js';
        $this->views->getView($this,'asignacion_becas',$data);
    }
}