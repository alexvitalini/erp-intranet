<?php
/*
1	Recursos humanos
2	Ventas
3	Contabilidad
4	Cobranza
5	Servicios Generales
6	Sistemas
7	Diseño
8	Dirección
9	Edecanes
10	Expositores
11	Gerencia

select
	idUsuario,
	usuario,
	nombre,
	apellido,
	clave,
	activo,
	correo,
	administrador,
	usuario_erp.departamento as numero_departamento,
	p_cobranza,
	p_ventas,
	p_contabilidad,
	p_rrhh,p_edecanes,
	p_expositores,
	p_ssgg,
	p_disenio,
	p_direccion,
	p_sistemas,
	p_gerencia,
	erp_departamentos.departamento as nombre_departamento,
	erp_departamentos.jefe=idUsuario as es_jefe_departamente
from  
	usuario_erp left join erp_departamentos on (erp_departamentos.id_departamento = usuario_erp.departamento)
where 
	correo = 'vitalini@cefa.com.mx' && activo
	
id_departamento
departamento
jefe

SELECT 
armado.id_departamento,
departamento.departamento,
armado.id_menu as armado_id_menu,
menu.id as menu_id_menu,
menu.nombre as menu,
menu.posicion as menu_posicion,
armado.nombre as opcion,
armado.posicion as opcion_posicion,
armado.id_modulo as armado_id_modulo,
modulo.id as modulo_id_modulo,
modulo.archivo_modulo,
destino
 FROM erp_menu_armado as armado   left join erp_departamentos as departamento using ( id_departamento )   left join erp_menus as menu on ( menu.id = armado.id_menu ) left join erp_modulos as modulo on ( armado.id_modulo=modulo.id) where armado.id_departamento='4' order by menu.posicion,armado.posicion

SELECT 
menu.nombre as menu,
menu.nivel='jefe' as solo_jefes,
armado.nombre as opcion,
modulo.archivo_modulo,
destino
 FROM erp_menu_armado as armado   left join erp_departamentos as departamento using ( id_departamento )   left join erp_menus as menu on ( menu.id = armado.id_menu ) left join erp_modulos as modulo on ( armado.id_modulo=modulo.id) where armado.id_departamento='4' order by menu.posicion,armado.posicion


*/
$cTextoDrodown = <<<TEXTO
\t\t\t<li class="nav-item dropdown">
\t\t\t\t<a href="#" class="nav-link dropdown-toggle" id="menu-categorias" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-%s'></i>%s</a>
	\t\t\t<div class="dropdown-menu" aria-labelledby="menu-categorias">

TEXTO;

$cTextoOpcionMenu = "\t\t\t\t\t<a href=\"javascript:menuOpcion('%s','%s')\" title=\"%s\" class='dropdown-item' ><i class='fa fa-%s'></i>%s</a>\r\n";

$cQueryMenuLimpio = <<<HEREDOC
SELECT 
menu.nombre as menu,
menu.glypho as menu_glypho,
menu.nivel='jefe' as solo_jefes,
armado.nombre as opcion,
modulo.archivo_modulo,
modulo.descripcion,
modulo.glypho as modulo_glypho,
modulo.destino
 FROM erp_menu_armado as armado   left join erp_departamentos as departamento using ( id_departamento ) left join erp_menus as menu on ( menu.id = armado.id_menu ) left join erp_modulos as modulo on ( armado.id_modulo=modulo.id)
where
 armado.id_departamento in ('%s', '%s' )
 %s 
order by
 menu.posicion,armado.posicion
HEREDOC;


function cQueryMenu( $nDepartamento , $nIdUsuario , $lJefeDepto = false ) {
	global $cQueryMenuLimpio;
	$cRespuesta = sprintf( $cQueryMenuLimpio ,  $nDepartamento , ( $nIdUsuario+10000 ) , ( ( $lJefeDepto ) ? "" : "HAVING not solo_jefes"  ) );
	//echo( $cRespuesta );
	return $cRespuesta ;
}

function finalizaUL_LI( $cTexto ) {
	if ( !empty( $cTexto) ) {
		$cTexto.="\t\t\t\t</div>\r\n\t\t\t</li>\r\n";
	}
	return $cTexto;
}

function iniciaDropdown( $cTexto , $cMenu , $cGlypho = "th" ){
	global $cTextoDrodown;
	$cTexto = finalizaUL_LI( $cTexto );
	return $cTexto.sprintf(  $cTextoDrodown , $cGlypho , $cMenu );
	
}

function cCreaMenu( $sConsulta ){
	global $usuario,$cTextoOpcionMenu;
	$cRespuesta = "";
	$cMenu="$%&#$%&";
	while( $oConsulta = MySQL_fetch_object( $sConsulta ) ){
		if ( $oConsulta->menu <> $cMenu ){
			$cMenu	= $oConsulta->menu;
			$cGlypho= $oConsulta->menu_glypho;
			$cRespuesta = iniciaDropdown( $cRespuesta, $cMenu , $cGlypho );
		}
		$cRespuesta.= sprintf( $cTextoOpcionMenu , $oConsulta->archivo_modulo , $oConsulta->destino, $oConsulta->descripcion , $oConsulta->modulo_glypho , $oConsulta->opcion );
	}
	return finalizaUL_LI( $cRespuesta );
}

function menusOpciones() {
	global $connect, $usuario;
	$nIdUsuario 	= $usuario['idUsuario'];
	$nDepartamento 	= $usuario['numero_departamento'];
	$lJefeDepto 	= $usuario['es_jefe_departamento'];
	$cRespuesta 	= "";
	
	$sConsulta = $connect->sQuery( cQueryMenu( $nDepartamento , $nIdUsuario , $lJefeDepto ) );
	if ( mysql_num_rows( $sConsulta ) > 0) {
		$cRespuesta = cCreaMenu( $sConsulta );
	}
	
	mysql_free_result( $sConsulta );
	return $cRespuesta;
}


?>
	<nav class="navbar fixed-top navbar-expand-md navbar-dark p-0" >
	<div class="container-fluid">
		<a href="#" class="navbar-brand"><img src="imagenes/logocefa01.jpg"></a>
		
		<!-- Nos permite usar el componente collapse para dispositivos moviles -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Menu de Navegacion">
			<span class="navbar-toggler-icon"></span>
		</button>

		<!-- Inica menú -->
		<div class="collapse navbar-collapse" id="navbar">
			<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a href="javascript:menuOpcion('cuerpo.php','cuerpo')" class="nav-link"><i class='fa fa-home'></i>Inicio</a>
			</li>
		<!-- Arma el menú dinámico -->
<?php echo( menusOpciones() ); ?>
			<!--<li class="nav-item dropdown">
				<a href="#" class="nav-link dropdown-toggle" id="menu-categorias" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-sitemap'></i> Catálogos</a>
				<div class="dropdown-menu" aria-labelledby="menu-categorias">
					<a href="javascript:menuOpcion('catalogo_gastos.php','grande')" title="Íconos disponibles" class="dropdown-item"><i class="fa fa-credit-card"></i>Gastos</a>
				</div>
			</li>-->
		<!-- Menús de adminitración -->
			<li class="nav-item dropdown">
				<a href="#" class="nav-link dropdown-toggle" id="menu-categorias" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-cog'></i></a>
				<div class="dropdown-menu" aria-labelledby="menu-categorias">
					<a href="#" class="dropdown-item"><i class='fa fa-user'></i><?php echo($usuario['nombre_completo']) ?></a>
					<a href="#" class="dropdown-item"><i class='fa fa-users'></i><?php echo($usuario['nombre_departamento']) ?></a>
					<div class="dropdown-divider"></div>
					<a href="javascript:menuOpcion('fa_iconos.php','cuerpo')" title="Íconos disponibles" class="dropdown-item"><i class="fa fa-th"></i>Muestrario de íconos</a>
					<a href="javascript:muestraIni()" class="dropdown-item"><i class='fa fa-eye-slash'></i>Contenido Ini</a>
					<a href="javascript:muestraPermisos()" class="dropdown-item"><i class='fa fa-eye-slash'></i>Permisos</a>
					<div class="dropdown-divider"></div>
					<a href="cerrar.php" class="dropdown-item"><i class='fa fa-sign-out fa-lg'></i>Cerrar</a>
				</div>
			</li>
			</ul>
		</div><!-- .navbar-collapse -->
	  </div><!-- .container-fluid -->
	</nav>

	<script>
	
	function muestraIni(){
		$('#dialogo_ini').modal( { show:true } );
	}
	
	function muestraPermisos(){
		$('#dialogo_permisos').modal( { show:true } );
	}
	
	function menuOpcion($cArchivo,$cDestino){
		var $jDialogo;
		
		if ( $cDestino=="cuerpo" ) {
			
			$("#cuerpo_principal").hide()
			console.log(cHoraCompleta()+"=>"+$cArchivo+"->Principal");
			$("#cuerpo_principal").load( $cArchivo , function(  data , $cEstatus , $xhr  ){
				console.log(cHoraCompleta()+"<=("+$cEstatus+")");
				if ( $cEstatus =="success" )
					$("#cuerpo_principal").show();
			});
		} else if( $cDestino=="blank" ) {
			alert($cArchivo+"->"+$cDestino);
		} else {
			console.log(cHoraCompleta()+"=> "+$cArchivo+"->Diálogo:"+$cDestino);
			$jDialogo = $( "#dialogo_modal_"+$cDestino);
			$jDialogo.find(".modal-content").load( $cArchivo, { 'dlg':$cDestino }, function( data , $cEstatus , $xhr ) {
				console.log(cHoraCompleta()+"<=("+$cEstatus+")");
				if ( $cEstatus =="success" )
					$jDialogo.modal( { show:true } );
			});
		}
	}
	</script>