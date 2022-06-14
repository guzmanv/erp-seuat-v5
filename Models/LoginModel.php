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
		$sql = "SELECT per.nombre_persona,per.ap_paterno,per.ap_materno,us.id_roles,r.nombre_rol,r.clave_rol FROM t_personas AS per 
		INNER JOIN t_usuarios AS us ON us.id_personas = per.id
		INNER JOIN t_roles AS r ON us.id_roles = r.id 
		WHERE us.id = $idUser LIMIT 1";
		$request = $this->select($sql);
		return $request;
	}

	/* public function selelectPermisos(int $idUser){
		$sql = "SELECT per.nombre_persona,per.ap_paterno,per.ap_materno,per.id_roles,r.nombre_rol,r.clave_rol,pg.id_permiso,pg.id_plantel FROM t_personas AS per 
		INNER JOIN t_usuarios AS us ON us.id_persona = per.id
		INNER JOIN t_roles AS r ON per.id_rol = r.id 
		RIGHT JOIN t_permisos_globales AS pg ON pg.id_usuario = us.id 
		WHERE us.id = $idUser";
		$request = $this->select_all($sql);
		return $request;
	} */
}
?>