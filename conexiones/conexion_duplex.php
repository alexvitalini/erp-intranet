<?php
	require_once('php_funciones.php');

	$cConsultaUsuarioStatic	= "select
	idUsuario,
	usuario,
	nombre,
	apellido,
	concat( nombre, ' ' ,apellido) as nombre_completo ,
	clave,
	activo,
	correo,
	administrador,
	supervisor,
	usuario_erp.departamento as numero_departamento,
	erp_departamentos.departamento as nombre_departamento,
	usuario_erp.pagina_inicio as usuario_pagina,
	erp_departamentos.pagina_inicio as departamento_pagina, 
	erp_departamentos.jefe=idUsuario as es_jefe_departamento,
	vista_principal
from  
	usuario_erp left join erp_departamentos on (erp_departamentos.id_departamento = usuario_erp.departamento)
where 
	correo = '%s' && activo";

	$cValidaUsuarioStatic	= "SELECT idUsuario, departamento, correo, concat( nombre, ' ' ,apellido) as nombre_completo FROM usuario_erp WHERE usuario ='%s' AND clave = '%s' && activo";

	$cQueryPermisos ="select departamento,permiso from erp_permisos left join erp_departamentos using ( id_departamento ) where id_usuario='%s'";

function urls_amigables($url) {

    $url = strtolower($url);
     
     //Reemplazamos caracteres especiales latinos
     $find = array('á','é','í','ó','ú','à','è','ì','ò','ù','ä','ö','ç','ñ');
     $repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
     $url = str_replace($find, $repl, $url);
     
     //Añadimos los guiones
     $find = array(' ', '&amp;', '\r\n', '\n','+');
     $url = str_replace($find, '_', $url);
      
     //Eliminamos y Reemplazamos los demas caracteres especiales
     // $find = array('/[^a-z0-9\-&lt;&gt;]/', '/[\-]+/', '/&lt;{^&gt;*&gt;/');
     // $repl = array('', '-', '');
     // $url = preg_replace($find, $repl, $url);
    
    return $url;
    
}


function mysql_assoc_all( $res ) { 
	$aNuevo = array(); 
	while ( $oRow = mysql_fetch_object( $res ) ) 
		$aNuevo[ urls_amigables( $oRow->departamento ) ] = $oRow->permiso;
	return $aNuevo; 
}
	
function mysql_fetch_all($res) { 
	$data = array(); 
	while ($row = mysql_fetch_array( $res , MYSQLI_ASSOC)) 
	$data[] = $row; 
	return $data; 
}

	class connect{
		private	$USER = "root";
		private	$PASS = "cplcceta";
		private	$HOST = "localhost";
		private	$DB	= "test";
		private	$connect; 
		
		private	$servidorRemoto = "162.221.202.181";
		private	$usuarioRemoto = "cefacomm";
		private	$contrasenaRemota = "cplcceta";
		private	$baseRemota = "cefa";
		public	$conexionRemotaLi;
		public	$lConexionRemota 	= false;
		public	$nIdUsuario 		= false;
		public	$nIdDepartamento	= false;
		public	$cCorreoValidado;
		public	$cNombreValidado;
		public	$aDatosUsuario; 
		public	$aIni = array();
		public	$aPermisos = array();
		public  $nVista_principal;
		
		public $lUsuarioValido = false;

		public function lSupervisor() {
				return $this->aPermisos['supervisor']=="1";
			}

		public function connect_db( $lRemoto = false ){
			$this->connect = mysql_connect($this->HOST, $this->USER, $this->PASS) or die(mysql_error());	
			mysql_select_db($this->DB,$this->connect);
			mysql_query("SET names UTF8");
			if ( $lRemoto ){
				$this->conectarLi();
			}
		}
		
		public function conectarLi(){
			$this->conexionRemotaLi = new mysqli( $this->servidorRemoto , $this->usuarioRemoto , $this->contrasenaRemota, $this->baseRemota);
			
			if ($this->conexionRemotaLi->connect_errno) {
				echo "Fallo al contenctar a MySQL: (" . $this->conexionRemotaLi->connect_errno . ") " . $this->conexionRemotaLi->connect_error;
			} else {
				$this->conexionRemotaLi->query("SET names UTF8");
				$this->lConexionRemota = true;
			}
			//echo $this->conexionRemotaLi->host_info . "\n";
		}

		public function desconectarLi() {
			if ( $this->lConexionRemota ) {
				$this->conexionRemotaLi->close();
				$this->lConexionRemota = false;
			}
		}
		
		public function affected_rows() {
			return mysql_affected_rows( $this->connect );
		}
		
		public function insert_id() {
			return mysql_insert_id( $this->connect );
		}

		public function sQuery( $cQuery ) {
			//echo("sQuery:".$cQuery);
			return mysql_query( $cQuery , $this->connect );
		}

		public function QueryLi( $cQuery ) {

			return $this->conexionRemotaLi->query( $cQuery );
		}

		public function close( $lRemoto = false ){
			mysql_close($this->connect);
			if ( $lRemoto) {
				$this->desconectarLi();
			}
		}

		public function real_scape( $cString ) {
			return mysql_real_escape_string( $cString , $this->connect );
		}

		public function CargaPermisos( $nIdUsuario ){
			global $cQueryPermisos;
			
			$aRespuesta = array();
			$cQuery = sprintf( $cQueryPermisos , $nIdUsuario );
			$sQuery = $this->sQuery( $cQuery );
			$this->aPermisos = mysql_assoc_all( $sQuery );
			mysql_free_result($sQuery);
		}

		public function nPermiso( $cDepartamento ) {
			$cDepartamento = urls_amigables( $cDepartamento );
			if ( array_key_exists( $cDepartamento , $this->aPermisos ) ) 
				return (int) ( $this->aPermisos[ $cDepartamento ] );
			else
				return 0;
		}

		public function SetIni( $nIdUsuario , $cSeccion , $cEntrada , $xValor , $lHistoria = false , $lRecarga = false ) {
			
			if ( !isset( $nIdUsuario ) ) 
				$nIdUsuario = $this->nIdUsuario;
			
			if ( $lHistoria )
				$this->SetHistoria( $nIdUsuario, $cSeccion ,$cEntrada.":".$xValor );

			$nIdUsuario+=10000;
			
			$cSetIni ="replace INTO erp_ini (depto_usuario, seccion, entrada, valor ) VALUES ('$nIdUsuario', '$cSeccion', '$cEntrada', '$xValor')" ;
			$this->sQuery( $cSetIni );
			
			if ( $lRecarga ){
				$this->CargaIni( $this->nIdUsuario , $this->nIdDepartamento );
			}
		}
		
		public function CargaIni( $nIdUsuario , $id_departamento ){
			$aRespuesta = array();
			$nIdUsuario+=10000;
			$sql  = "select seccion,entrada,valor,actualizado from erp_ini where depto_usuario in ('$id_departamento','$nIdUsuario')";
			$sIni = $this->sQuery( $sql );
			$this->aIni = mysql_fetch_all( $sIni );
			mysql_free_result($sIni);
		}
		
		public function nValorIni( $cSeccion , $cEntrada ) {
			$nI = 0;
			$cRespuesta = "";
			$lOk = false ;
			$nTamanio = count( $this->aIni );
			for ($nI = 0 ; $nI < $nTamanio ; $nI++ ) {
				$lOk = ( $this->aIni[$nI]["seccion"] == $cSeccion  && $this->aIni[$nI]["entrada"] == $cEntrada  );
				break;
			}
			return ($lOk)? $nI : false ;
		}

		public function cValorIni( $cSeccion , $cEntrada , $cDefault = "" ) {
			$nI = 0;
			$cRespuesta = "";
			$lOk = false ;
			$nTamanio = count( $this->aIni );
			for ($nI = 0 ; $nI < $nTamanio ; $nI++ ) {
				$lOk = ( $this->aIni[$nI]["seccion"] == $cSeccion  && $this->aIni[$nI]["entrada"] == $cEntrada  );
				break;
			}
			return  ( ($lOk) ? $this->aIni[$nI]["valor"] : $cDefault );
		}
		
		public function cFechaUltimoLogin() {
			return $this->cValorIni("sistema","login");
		}

		public function SetHistoria( $nIdUsuario , $cSeccion , $cTexto ) {
			$cSetHistoria ="insert into erp_historia (id_usuario,seccion,valor) values ('$nIdUsuario','$cSeccion','$cTexto')";
			$this->sQuery( $cSetHistoria );
		}

		public function lConsultaUsuario( $cCorreo ) {
			global $cConsultaUsuarioStatic;

			$sConsulta = $this->sQuery( sprintf( $cConsultaUsuarioStatic , $cCorreo ) );
			if ( $this->lUsuarioValido 	= ( mysql_num_rows( $sConsulta ) == 1 ) ) {
				$this->aDatosUsuario 	=  mysql_fetch_assoc( $sConsulta );
				$this->nIdUsuario 		= $this->aDatosUsuario['idUsuario'];
				$this->nVista_principal = $this->aDatosUsuario['vista_principal'];
				$this->nIdDepartamento	= $this->aDatosUsuario['numero_departamento'];
				$this->CargaIni( $this->nIdUsuario , $this->nIdDepartamento); 
				$this->CargaPermisos( $this->aDatosUsuario['idUsuario'] );
				$this->SetHistoria( $this->aDatosUsuario['idUsuario'] , "sistema", "abriendo:".$_SERVER['PHP_SELF'] ); //array_pop( explode('/', $_SERVER['PHP_SELF'] ) )
			}
			return $this->lUsuarioValido;
		}

		public function validaUsuario( $cUsuario , $cClave ) {
			global $cValidaUsuarioStatic;
			
			$cUsuario	= $this->real_scape( $cUsuario );
			$cClave		= $this->real_scape( $cClave );
			
			$cConsulta = sprintf( $cValidaUsuarioStatic , $cUsuario , $cClave ) ;
			$sConsulta = $this->sQuery( $cConsulta );
			$this->lUsuarioValido = ( mysql_num_rows( $sConsulta ) == 1 );
			if( $this->lUsuarioValido ){
				$oConsulta = mysql_fetch_assoc( $sConsulta );
				$this->nIdUsuario 		= $oConsulta['idUsuario'];
				$this->nIdDepartamento	= $oConsulta['departamento'];
				$this->cCorreoValidado	= $oConsulta['correo'];
				$this->cNombreValidado	= $oConsulta['nombre_completo'];
				$this->SetIni( $oConsulta['idUsuario'] , "sistema" , "login" , cGetIpCliente() , true );
				$this->SetHistoria( $this->nIdUsuario , "sistema" , "LOGIN:".$cUsuario );
			} else {
				$this->SetHistoria( $this->nIdUsuario , "sistema" , "NoLogin:".$cUsuario );
			}
			return $this->lUsuarioValido;
		}
		
		public function vistasXGrupos( $cGruposPermitidos , &cGrupos,&cFiltros,&$cDialogos ) {
			$cSQL = "select id_grupo,nombre_grupo,descripcion_grupo from erp_grupos_usuarios left join erp_grupos using ( id_grupo ) where id_usuario='$this->nIdUsuario' && nombre_grupo IN ($cGruposPermitidos)";
			
			$sSQL = $this->sQuery( $cSQL );
			
			
			return $cSQL;
		}
	}
?>