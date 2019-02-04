<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php require_once "php/gestionScripts.php";  ?>
</head>
<body>
	<div class="container pt-1">
		<img src="img/logo.jpg" alt="CUSur" class="mb-5">
		<div class="row">
			<div class="col-sm-12">
				<div class="card text-left" style="box-shadow: 0px 0px 10px rgba(0,0,0,1);">
					<div class="card-header">
						Gestión de Instancias
					</div>
          <div class="card-body">
						<span class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
							Agregar Nuevo Instancia <span class="fa fa-plus-circle"></span>
						</span>
						<hr>
						<div id="tablaDatatable"></div>
					</div>
					<div class="card-footer text-muted">
						Gestión de Instancia
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Agregar Nueva Instancia</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevo">
						<!-- Nombre del Instancia-->
						<label for="nombreInstancia">Nombre Instancia</label>
						<input id="nombreInstancia" class="form-control input-sm mb-3" type="text" placeholder="Ingresa la nombre del Instancia" name="nombre" required>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" id="btnAgregarnuevo" class="btn btn-primary">Agregar nuevo</button>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal -->
	<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Editar Instancia</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevoU">
						<!-- ID DEL USUARIO, SE MANTENDRA ESCONDIDO, PERO SU VALOR PUEDE SEGUIR SIENDO ACCESADO-->
						<input type="text" hidden="" id="idInstanciaEditar" name="idInstanciaEditar">
						<!-- Nombre del Instancia-->
						<label>Nombre Instancia</label>
						<input id="nombreEditar" class="form-control input-sm mb-3" type="text" name="nombreEditar" required>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
				</div>
			</div>
		</div>
	</div>


</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#btnAgregarnuevo').click(function(){
			datos=$('#frmnuevo').serialize();

			$.ajax({
				type:"POST",
				data:datos,
				url:"php/procesosInstancias/agregar.php",
				success:function(r){
					if(r==1){
						$('#frmnuevo')[0].reset();
						$('#tablaDatatable').load('php/procesosInstancias/tabla_instancias.php');
						alertify.success("Instancia Agregada");
					}else{
						alertify.error("Error al Agregar Instancia");
					}
				}
			});
		});

		$('#btnActualizar').click(function(){
			datos=$('#frmnuevoU').serialize();
			console.log(datos);

			$.ajax({
				type:"POST",
				data:datos,
				url:"php/procesosInstancias/actualizar.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('php/procesosInstancias/tabla_instancias.php');
						alertify.success("Instancia Actualizada");
					}else{
						alertify.error("Error al actualizar la Instancia");
					}
				}
			});
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tablaDatatable').load('php/procesosInstancias/tabla_instancias.php');
	});
</script>

<script type="text/javascript">
	function agregaFrmActualizar(idinstancia){
		$.ajax({
			type:"POST",
			data:"idinstancia=" + idinstancia,
			url:"php/procesosInstancias/obtenDatos.php",
			success:function(r){
				datos=jQuery.parseJSON(r);
				$('#idInstanciaEditar').val(datos['instancia_id']);
				$('#nombreEditar').val(datos['nombre']);
			}
		});
	}

		function eliminarDatos(idinstancia){
		alertify.confirm('Eliminar Instancia', '¿Seguro que deseas eliminar la Instancia?', function(){

			$.ajax({
				type:"POST",
				data:"idinstancia=" + idinstancia,
				url:"php/procesosInstancias/eliminar.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('php/procesosInstancias/tabla_instancias.php');
						alertify.success("Instancia Eliminada");
					}else{
						alertify.error("Error al eliminar la Instancia");
					}
				}
			});

		}
		, function(){

		});
	}

</script>
