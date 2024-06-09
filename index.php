<?php
//ULTIMA MODIFICACION 25-Jul-17
//Código Fuente App/Web Let´s doc
//Ernesto Hernández Barrón & Héctor Arturo Hernández Sánchez
//Index.php
session_start();
include_once("clases/con_mysql.php");
$mysql = new con_mysql();
$link = $mysql->connect();
include ('secure.php');
$FiltraRevision=0;
include_once("clases/cls_estructura.php");
$estructura = new cls_estructura();
$es_repse=0;
$ruta = $estructura->cls_ruta();
$id_perfil_login=$_SESSION['pe_user'];
$id_usuario_login=$_SESSION['id_user'];
$Todate=date('Y-m-d');
$Fromdate=date('Y-m-01');
if (isset($_SESSION['id_estatus_doctos'])){
  $id_estatus_doctos_login=$_SESSION['id_estatus_doctos'];
}else {
  $id_estatus_doctos_login=0;
}
//Sección Notificación
$RegistrosActivos=0;
if($id_perfil_login==1){//Administrador
    $Sql = "SELECT count(*) as NoRegistros FROM tb_administrador WHERE id_estatus_doctos=2 and id_estatus_doctos=2";
    $res = $mysql->query($Sql);
    $row = $mysql->f_row($res);
    $RegistrosActivos=$row[0];
    if($RegistrosActivos==0){
      $TitleNotification="No hay Operaciones pendientes por Facturar";
      $MessageNotification="Operaciones Facturadas";
      $StyleNotification="success";
      $FiltraRevision=0;
    }else {
      $TitleNotification="¡Atención: Aviso de Revisión de Documentos!";
      $MessageNotification="Hay ".$RegistrosActivos." proveedores que solicitarón la revisión de Documentos.";
      $FiltraRevision=1;
      $StyleNotification="danger";
    }
    $Sql = "SELECT count(*) as NoRegistros FROM tb_cfdi WHERE solicita_repse=1 AND tipodecomprobante='K' AND id_estatus_documentacion_repse IN (1,2)";
    $res = $mysql->query($Sql);
    $row = $mysql->f_row($res);
    $RegistrosActivos=$row[0];
    if($RegistrosActivos==0){
      $TitleNotificationRepse="No hay Operaciones con Saldo Vencido";
      $MessageNotificationRepse="Operaciones al día";
      $FiltraRevisionRepse=0;
      $StyleNotificationRepse="success";
    }else {
      $TitleNotificationRepse="¡Atención: Aviso de Revisión de Documentos REPSE!";
      $MessageNotificationRepse="Hay ".$RegistrosActivos." Pagos que requieren revisar información del REPSE.";
      $FiltraRevisionRepse=1;
      $StyleNotificationRepse="danger";
    }
}else {//Proveedores
  //Repse
  $Sql = "SELECT count(*) as NoRegistros FROM tb_cfdi WHERE solicita_repse=1 AND id_proveedor=".$id_usuario_login." and tipodecomprobante='K' AND id_estatus_documentacion_repse IN (1,2)";
  $res = $mysql->query($Sql);
  $row = $mysql->f_row($res);
  $RegistrosActivos=$row[0];
  if($RegistrosActivos==0){
    $TitleNotificationRepse="No hay Pagos con información del REPSE Pendiente";
    $MessageNotificationRepse="Proveedor sin Pendientes";
    $FiltraRevisionRepse=0;
    $StyleNotificationRepse="success";
  }else {
    $TitleNotificationRepse="¡Atención: Aviso de Revisión de Documentos REPSE!";
    $MessageNotificationRepse="Hay ".$RegistrosActivos." Pagos que requieren cargar información del REPSE.";
    $FiltraRevisionRepse=1;
    $StyleNotificationRepse="danger";
  }
  switch ($id_estatus_doctos_login) {
    case '1'://Documentación Pendiente
      $TitleNotification="¡Atención: Aún no puedes cargar Documentos";
      $MessageNotification="Tu cuenta aún no cumple con la documentación necesaria para cargar Facturas al portal, por favor carga la documentación aquí.";
      $StyleNotification="warning";
      break;
    case '2';//Documentación en Proceso de Validación
      $TitleNotification="Tu documentación está en proceso de validación.";
      $MessageNotification="Estamos validando tu información, recibirás una notificación cuando puedas cargar Facturas al Portal.";
      $StyleNotification="warning";
      break;
    case '3'://Documentación Aprobada
      $TitleNotification="Tu documentación ha sido validada y aprobada";
      $MessageNotification="Ahora puedes cargar documentos al portal.";
      $StyleNotification="success";
      break;
    case '4'://Documentos renovar
      $TitleNotification="Es Necesario Cargar Documentos Actualizados del Periodo";
      $MessageNotification="Aún no puede cargar documentos en el portal.";
      $StyleNotification="info";
      break;
    default:
      $TitleNotification="Tu documentación está en proceso de validación.";
      $MessageNotification="Estamos validando tu información, recibirás una notificación cuando puedas cargar Facturas al Portal.";
      $StyleNotification="warning";
      break;
  }
  $Sql = "SELECT es_repse FROM tb_administrador WHERE id_admin='".$id_usuario_login."'";
  $res = $mysql->query($Sql);
  $row = $mysql->f_row($res);
  $es_repse=$row[0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo $estructura->cls_titulo(); ?></title>
<?php echo $estructura->cls_css();

//Sección Permisos
//Todas Visibles

$DisabledOption01='';
$DisabledOption02='';
$DisabledOption03='';
$DisabledOption04='';
$DisabledOption05='';
$DisabledOption06='';
$DisabledOption07='';
$DisabledOption08='';
$DisabledOption09='';
$DisabledOption10='';
$DisabledOption11='';
$DisabledOption12='';
$DisabledOption13='';
switch ($_SESSION['pe_user']) {
    case 1://Admin
				$DisabledOption01='';
				$DisabledOption02='';
				$DisabledOption03='';
				$DisabledOption04='';
				$DisabledOption05='style="display: none;"';
				$DisabledOption06='style="display: none;"';
				$DisabledOption07='style="display: none;"';
				$DisabledOption08='style="display: none;"';
        $DisabledOption09='style="display: none;"';
        $DisabledOption10='';
        $DisabledOption11='style="display: none;"';
        $DisabledOption12='style="display: none;"';
        $DisabledOption13='';
        break;
    case 2://Proveedor
				$DisabledOption01='style="display: none;"';
				$DisabledOption02='style="display: none;"';
				$DisabledOption03='style="display: none;"';
				$DisabledOption04='style="display: none;"';
        $DisabledOption10='style="display: none;"';
				$DisabledOption05='';
				$DisabledOption06='';
				$DisabledOption07='';
				$DisabledOption08='';
        $DisabledOption09='';
        $DisabledOption11='style="display: none;"';
        $DisabledOption13='style="display: none;"';
        if ($es_repse==1){
            $DisabledOption12='';
        }else {
          $DisabledOption12='style="display: none;"';
        }
        break;
}
?>
</head>

<body>
<input type="hidden" class="form-control" id="FiltraRevision" name="FiltraRevision" value="<?php echo $FiltraRevision ?>">
<input type="hidden" class="form-control" id="es_repse" name="es_repse" value="<?php echo $es_repse ?>">
<input type="hidden" class="form-control" id="FiltraRevisionRepse" name="FiltraRevisionRepse" value="<?php echo $FiltraRevisionRepse ?>">
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
		<a class="navbar-brand" href="index.php"><?php echo $estructura->cls_logo(); ?></a></div>
	<ul class="nav navbar-top-links navbar-right">
		<?php echo $estructura->cls_menu_header($_SESSION['pe_user']); ?>
	</ul>

	<div class="navbar-default sidebar" role="navigation" id="menu_nav">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
				<?php	echo $estructura->cls_menu_side($_SESSION['pe_user']); ?>
			</ul>
		</div>
	</div>
</nav>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12"> <?php echo $estructura->cls_ruta_pagina(); ?> </div>
	</div>
  <div class="alert alert-<?php echo$StyleNotification; ?> fade in" id="success-alert">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><?php echo $TitleNotification; ?></h4>
      <p><?php echo $MessageNotification;?></p>
      <p>
        <button type="button" class="btn btn-danger" onclick="ShowBalance(<?php echo $_SESSION['pe_user'].','.$_SESSION['id_user'] ?>)" >Ver Detalles </button>
      </p>
  </div>
  <div class="alert alert-<?php echo$StyleNotificationRepse; ?> fade in" id="success-alert-repse">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><?php echo $TitleNotificationRepse; ?></h4>
      <p><?php echo $MessageNotificationRepse;?></p>
      <p>
        <button type="button" class="btn btn-danger" onclick="ShowBalanceRepse(<?php echo $_SESSION['pe_user'].','.$_SESSION['id_user'] ?>)" >Ver Detalles </button>
      </p>
  </div>
	<div class="row">
    <div <?php echo$DisabledOption01; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-users fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Clientes</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>cliente/cliente.php/">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
		<div <?php echo $DisabledOption02; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-cubes fa-4x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Listado de Operaciones</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listadodoctos.php?Type=F">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
		<div <?php echo$DisabledOption03; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-cube fa-4x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Nueva Operación</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listadodoctos.php?Type=P">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
    <div <?php echo $DisabledOption10; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-road fa-4x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Asignar Operador</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listadodoctos.php?Type=O">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
    <div <?php echo $DisabledOption10; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-warning fa-4x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Registrar Incidencias</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listadodoctos.php?Type=N">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
    <div <?php echo$DisabledOption10; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-file-pdf-o fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Facturar Operación</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listadodoctos.php?Type=K">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
    <div <?php echo$DisabledOption10; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-money fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Pagos CXC</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listadodoctos.php?Repse=1&Type=K">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
    <div <?php echo$DisabledOption10; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-files-o fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Documentar Operación</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listadodoctossat.php?IdP=0&FechaInicio=<?php echo$Fromdate ?>&FechaFin=<?php echo$Todate?>&FiltrarSalida=true&DefaultCboD=1&Type=F&VerificarCFDiSAT=0">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
    <div <?php echo$DisabledOption10; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-flag-o fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Liquidación</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listadodoctossat.php?IdP=0&FechaInicio=<?php echo$Fromdate ?>&FechaFin=<?php echo$Todate?>&FiltrarSalida=true&DefaultCboD=1&Type=F&VerificarCFDiSAT=0">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>

    <div <?php echo$DisabledOption10; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-file-excel-o fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Reporte de Operaciones Excel</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/listado_proveedores.php">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>

		<div <?php echo$DisabledOption04; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-pie-chart fa-4x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Reporte Gráfico</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/report_01.php">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
		<div <?php echo$DisabledOption05; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-laptop fa-4x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Mis Datos</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta."SysAdmin/users_cap.php/".base64_encode($_SESSION['id_user'])."" ?>"/"">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>


		<div <?php echo$DisabledOption06; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-upload fa-4x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Cargar Factura</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>SysAdmin/listadodoctos.php?Type=F">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
		<div <?php echo$DisabledOption07; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-cloud-upload fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Cargar REP</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>SysAdmin/listadodoctos.php?Type=P">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
    <div <?php echo$DisabledOption09; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-cloud-upload fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Cargar Orden de Compra</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>SysAdmin/listadodoctos.php?Type=O">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>

    <div <?php echo$DisabledOption09; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-cloud-upload fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Cargar Nota Crédito</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>SysAdmin/listadodoctos.php?Type=N">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>
    <div <?php echo$DisabledOption12; ?>class="col-lg-3 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-4"> <i class="fa fa-laptop fa-4x"></i> </div>
            <div class="col-xs-8 text-right">
              <div class="huge">&nbsp;</div>
              <div>Empleados REPSE</div>
            </div>
          </div>
        </div>
        <a href="<?php echo $ruta."catalogo/empleados.php/".base64_encode($_SESSION['id_user'])."" ?>"/"">
        <div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
          <div class="clearfix"></div>
        </div>
        </a> </div>
    </div>
    <div <?php echo$DisabledOption13; ?>class="col-lg-3 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-4"> <i class="fa fa-truck fa-4x"></i> </div>
            <div class="col-xs-8 text-right">
              <div class="huge">&nbsp;</div>
              <div>Catálogo de Unidades</div>
            </div>
          </div>
        </div>
        <a href="<?php echo $ruta."catalogo/unidades.php/" ?>"/"">
        <div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
          <div class="clearfix"></div>
        </div>
        </a> </div>
    </div>

    <div <?php echo$DisabledOption12; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-cloud-upload fa-5x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Documentación REPSE</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>SysAdmin/listadodoctos.php?Repse=1&Type=K">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>

		<div <?php echo$DisabledOption08; ?>class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4"> <i class="fa fa-pie-chart fa-4x"></i> </div>
						<div class="col-xs-8 text-right">
							<div class="huge">&nbsp;</div>
							<div>Reporte Gráfico</div>
						</div>
					</div>
				</div>
				<a href="<?php echo $ruta ?>reports/report_01.php">
				<div class="panel-footer"> <span class="pull-left">Entrar!</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a> </div>
		</div>

	</div>
</div>

<?php echo $estructura->cls_jquery(); ?>
<script>
function ShowBalanceRepse(IdPerfil,Id_admin){
  var FiltraRevision=document.getElementById("FiltraRevisionRepse").value;
  if (IdPerfil==1){//Ir al módulo de Usuarios
    window.location.href='<?php	echo $ruta ?>reports/listadodoctos.php?Repse=1&Type=K';
  }else {//Ir a la sección de documentos
    window.location.href='<?php	echo $ruta ?>SysAdmin/listadodoctos.php?Repse=1&Type=K';
  }
};
function ShowBalance(IdPerfil,Id_admin){
  var FiltraRevision=document.getElementById("FiltraRevision").value;
  if (IdPerfil==1){//Ir al módulo de Usuarios
    window.location.href='<?php	echo $ruta ?>SysAdmin/users.php?FiltraRevision='+FiltraRevision;
  }else {//Ir a la sección de documentos
    window.location.href='<?php	echo $ruta ?>SysAdmin/archivero.php/?id='+btoa(Id_admin)+'&To=2';
  }
};
$(document).ready(function(){
	<?php echo $estructura->cls_datatable("dataTables-catalogo"); ?>
});
$("#success-alert").fadeTo(8000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});

$("#success-alert-repse").fadeTo(8000, 500).slideUp(500, function(){
  $("#success-alert-repse").slideUp(500);

});

</script>
</body>
</html>
