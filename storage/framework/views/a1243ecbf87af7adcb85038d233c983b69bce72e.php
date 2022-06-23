<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php if(Auth::check()): ?>
            <?php if(session('message')): ?>
                <div class="alert alert-success">
                    <h2><?php echo e(session('message')); ?></h2>

                </div>
            <?php endif; ?>
            <div class="row">
                <h2>Edición de Información de Equipo</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });

                </script>

            </div>
            <form action="<?php echo e(route('equipos.update',$equipo->id)); ?>" method="post" enctype="multipart/form-data" class="col-12">
                <?php echo method_field('PUT'); ?>
                <div class="row">
                    <div class="col">
                        <?php echo csrf_field(); ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <br>
		   </div>

		</div>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <label for="id">Id SIGE</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?php echo e($equipo->id); ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="udg_id">Id UdeG</label>
                                <input type="text" class="form-control" id="udg_id" name="udg_id" value="<?php echo e($equipo->udg_id); ?>" >
                            </div>
                              <div class="col-md-6">
                                  <label for="id_resguardante">Resguardante</label>
                                  <select class="form-control" class="form-control" id="js-example-basic-single" name="id_resguardante">
                                      <option value="<?php echo e($resguardante->id); ?>" selected><?php echo e($resguardante->nombre); ?> <?php echo e($resguardante->codigo); ?></option>
                                      <option value="No Aplica">Elegir otro resguardante</option>
                                      <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($empleado->id); ?>"><?php echo e($empleado->nombre); ?> - <?php echo e($empleado->codigo); ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </select>
                              </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <label for="tipo_equipo">Tipo de Equipo </label>
                                <select class="form-control" id="tipo_equipo" name="tipo_equipo">
                                    <option selected value="<?php echo e($equipo->tipo_equipo); ?>" ><?php echo e($equipo->tipo_equipo); ?></option>
                                    <?php $__currentLoopData = $tipo_equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($tipos->tipo_equipo); ?>"><?php echo e($tipos->tipo_equipo); ?></option>
				    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="marca">Marca </label>
                                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo e($equipo->marca); ?>" >
                            </div>

                            <div class="col-md-3">
                                <label for="modelo">Modelo </label>
                                <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo e($equipo->modelo); ?>" >
                            </div>
                            <div class="col-md-3">
                                <label for="numero_serie">Número de Serie </label>
                                <input type="text" class="form-control" id="numero_serie" name="numero_serie" value="<?php echo e($equipo->numero_serie); ?>" >
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="mac">MAC separado por ":" ej 18:AB:34:45 </label>
                                <input type="text" class="form-control" id="mac" name="mac" value="<?php echo e($equipo->mac); ?>" >
                            </div>
                            <div class="col-md-4">
                                <label for="ip">IP </label>
				<select class="form-control" id="ip" name="ip">
                        <?php if($ip_equipo!=null): ?>
                            <option value="<?php echo e($ip_equipo->id); ?>" selected><?php echo e($ip_equipo->ip); ?></option>
                            <option value="null">No Especificado</option>
                        <?php else: ?>
                            <option value="null" selected>No Especificado</option>
                        <?php endif; ?>



					<?php $__currentLoopData = $ips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($ip->id); ?>"><?php echo e($ip->ip); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</select>                            </div>
                            <div class="col-md-4">
                                <label for="tipo_conexion">Tipo de Conexión</label>
                                <select class="form-control" id="tipo_conexion" name="tipo_conexion">
                                    <option value="<?php echo e($equipo->tipo_conexion); ?>" selected><?php echo e($equipo->tipo_conexion); ?></option>
                                    <option disabled>Elegir otra opción</option>
                                    <option value="No Aplica">No Aplica</option>
                                    <option value="Red Cableada">Red Cableada</option>
                                    <option value="Solo Wifi<">Solo Wifi</option>
                                    <option value="Wifi y Ethernet">Wifi y Ethernet</option>
                                    <option value="Sin conexión">Sin conexión</option>
                                </select>
                            </div>
                        </div>
			<br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <label for="resguardante">Resguardante</label>
                                <select name="resguardante" id="resguardante" class="form-control">
				                    <option selected="">Elegir</option>
                                    <option value="<?php echo e($equipo->resguardante); ?>" selected><?php echo e($equipo->resguardante); ?></option>
                                    <option value="Otra dependencia">Otra dependencia</option>
                                    <option value="CTA">CTA</option>
                                    <option value="No inventariable">No inventariable</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="localizado_sici">localizado entrega recepción</label>
                                <select name="localizado_sici" id="localizado_sici" class="form-control">
                                    <option value="<?php echo e($equipo->localizado_sici); ?>" selected><?php echo e($equipo->localizado_sici); ?></option>
				    <option disable>Elegir</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="detalles">Detalles</label>
                                <textarea class="form-control" id="detalles" name="detalles"><?php echo e($equipo->detalles); ?></textarea>
                            </div>
                        </div>
                        <br>
                        <br>

                <br>
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar datos</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row g-3 align-items-center">

                <br>
                <h5>En caso de inconsistencias enviar un correo a victor.ramirez@academicos.udg.mx</h5>
                <hr>

            </div>
    </div>

    <?php else: ?>
        El periodo de Registro de Proyectos a terminado
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/mamp/htdocs/sige/resources/views/equipo/edit.blade.php ENDPATH**/ ?>