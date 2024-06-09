<?php
$documentLocation = $_SERVER['PHP_SELF'];
if ( $_SERVER['QUERY_STRING'] ) {
  $documentLocation .= "?" . $_SERVER['QUERY_STRING'];
}
include_once("clases/cls_estructura.php");
$estructura = new cls_estructura();
$ruta = $estructura->cls_ruta();

//$url = 'http://tresmedia.com.mx/integradora/admin/';
?>
<!DOCTYPE html>
<html lang="en">

    <head>




        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $estructura->cls_titulo(); ?></title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->

        <div class="top-content">
          <?php
          if(isset($message)){ ?>
              <div class="description">
                  <h5><?php echo $message;?> </h5>
              </div>
          <?php } ?>
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>|Bienvenido</strong> Iniciar Sesión|</h1>
                            <div class="description">
                            	<p>
	                            	<h4>Portal de Administración de Operaciones </h4>
	                            	 <a href="https://www.facebook.com/p/Transportes-Olmedo-100069489226441/"><strong>Transportes Olmedo</strong></a>
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Inicie sesión</h3>
                            		<p>Ingrese su usuario y contraseña para continuar:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" method="post" action="<?php echo $ruta ?>">
									<fieldset>
										<div class="form-group">
											<input class="form-control" placeholder="Usuario" name="usuario" type="usuario" autofocus>
										</div>
										<div class="form-group">
											<input class="form-control" placeholder="Password" name="password" type="password" value="">
										</div>
										<!-- Change this to a button or input when using this as a form -->
										<!--a href="index.html" class="btn btn-lg btn-success btn-block">Login</a-->
										<input type="submit" class="btn btn-lg btn-danger btn-block" value="Login" />
									</fieldset>
								</form>
		                    </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>

        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>
