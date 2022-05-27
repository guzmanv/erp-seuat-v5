<?php

class LoginModel extends Mysql
{
	private $intIdUsuario;
	private $strUsuario;
	private $strPassword;
    private $strNomConexion;
	private $strToken;

	public function __construct()
	{
		parent::__construct();
	}

	public function loginUSer(string $usuario, string $password)
	{
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$sql = "SELECT id,estatus FROM t_usuarios WHERE 
		nickname = '$this->strUsuario' and 
		password = '$this->strPassword' and 
		estatus != 0 ";
		$request = $this->select($sql);
		return $request;
	}
	public function selectDateUser(int $idUser){
        $this->intIdUsuario = $idUser;
		$sql = "SELECT per.nombre_persona,per.ap_paterno,per.ap_materno, per.id_rol,r.nombre_rol,r.clave_rol,adm.id_plantel  FROM t_personas AS per 
		INNER JOIN t_usuarios AS us ON us.id_persona = per.id 
		INNER JOIN t_roles AS r ON per.id_rol = r.id 
		INNER JOIN t_administrativo AS adm ON adm.id_usuario  = us.id 
		WHERE us.id = $idUser LIMIT 1";
		$request = $this->select($sql);
		return $request;
	}
}
?>