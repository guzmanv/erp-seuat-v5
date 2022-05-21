<?php
    class SistemasEducativosModel extends Mysql{
        
        public $nomSistema;
        public $abreviacionSistema;
        public $logoSistema;
        public $estatus;
        public $idDatosFiscales;
        public $idUser;
        public function __construct()
        {
            parent::__construct();
        }
        //Select sistemas
        public function selectSistemas()
        {
            $sql = "SELECT *FROM t_sistemas_educativos WHERE estatus != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        //Insert Sistema
        public function insertSistema(string $nombreSistema,string $abreviacionSistema, string $nomImagen, int $idUser)
        {
            $this->nomSistema = $nombreSistema;
            $this->abreviacionSistema = $abreviacionSistema;
            $this->logoSistema = $nomImagen;
            $this->idUser = $idUser;
            $sql = "INSERT INTO t_sistemas_educativos(nombre_sistema,abreviacion_sistema,logo_sistema,estatus,fecha_creacion,id_usuario_creacion) VALUES(?,?,?,?,NOW(),?)";
            $request = $this->insert($sql,array($this->nomSistema,$this->abreviacionSistema,$this->logoSistema,1,$this->idUser));
            return $request;
        }

        //Select Sistema by ID
        public function selectSistema(int $idSistema)
        {
            $sql = "SELECT *FROM t_sistemas_educativos WHERE id = $idSistema LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }

        public function selectSistemaExist(int $idSistema,string $strNombreSistema,string $strAbreviacion,int $intEstatus,int $idUser)
        {
            $this->nomSistema = $strNombreSistema;
            $this->abreviacionSistema = $strAbreviacion;
            $this->estatus = $intEstatus;
            $this->idUser = $idUser;
            return "jose";
        }
        
        public function updateSistema(int $idSistema,string $strNombreSistema,string $strAbreviacion,int $intEstatus,$nombreImagenSistema,int $idUSer)
        {
            $this->nomSistema = $strNombreSistema;
            $this->abreviacionSistema = $strAbreviacion;
            $this->estatus = $intEstatus;
            $this->logoSistema = $nombreImagenSistema;
            $this->idUser = $idUSer;
            if($this->logoSistema == null){
                $sql = "UPDATE t_sistemas_educativos SET nombre_sistema = ?,abreviacion_sistema = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id = $idSistema";
                $request = $this->update($sql,array($this->nomSistema,$this->abreviacionSistema,$this->estatus,$this->idUser)); 
            }else{
                $sql = "UPDATE t_sistemas_educativos SET nombre_sistema = ?,abreviacion_sistema = ?,logo_sistema = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id = $idSistema";
                $request = $this->update($sql,array($this->nomSistema,$this->abreviacionSistema,$this->logoSistema,$this->estatus,$this->idUser));
            }
            return $request;
        }

        public function delSistema(int $idSistema,int $idUSer)
        {
            $this->idUser = $idUSer;
            $sql = "UPDATE t_sistemas_educativos SET estatus = ? WHERE id = $idSistema";
            $request = $this->update($sql,array(0));
            return $request;
        }
    }
?>