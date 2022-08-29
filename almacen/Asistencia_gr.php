<?php
	require_once('conexion.php');
	require_once('ObjetoRegistro.php');

	class Asistencia_gr{
		private $conn = null; // Variable de conexion.

		function __construct(){
			$this->conn = new Conexion(); // Inicializacion de la conexion.
			gc_enable(); // Forzando el garbage collector.
			date_default_timezone_set('America/Mexico_City');
			set_time_limit(60);
		}

		function getRegistros($fecha){
			// Estos arrays se manejan como pilas (stacks).
			$rawData = array(); // Almacena los registros sin filtrar.
			$ready = array(); // Almacena los registros filtrados.
			$mesAnio = explode('-',$fecha);
			$mes = $mesAnio[1];
			$anio = $mesAnio[0];

			$sql = "SELECT DISTINCT idAsistencia, codigo, fecha, idEmpleado FROM asistencia_empleado a
			INNER JOIN empleado e ON a.codigo = e.codigoUDG
			WHERE MONTH(fecha) = $mes AND YEAR(fecha) = $anio
			ORDER BY idEmpleado, fecha";

			$rs = $this->conn->query($sql);

			if ($rs->rowCount() > 0) {
				// Vaciar la informacion de la consulta en la pila $rawData.
				while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
					$nuevoRegistro = new ObjetoAsistencia();
					$d = new DateTime($row['fecha']);

					$nuevoRegistro->setAsistencia($row['idAsistencia']);
					$nuevoRegistro->setCodigoUDG($row['codigo']);
					$nuevoRegistro->setFecha($d->format('Y/m/d'));
					$nuevoRegistro->setHora($d->format('H:i:s'));
					$nuevoRegistro->setEmpleado($row['idEmpleado']);

					array_push($rawData, $nuevoRegistro);
				}
			}
			$x = 0;
			while (sizeof($rawData) > 0){ // Recorre la los registros sin filtrar.
				$data = array_shift($rawData); // Hace pop desde el primer elemento.
				$codigoUDG = $data->getCodigoUDG();
				$empleado = $data->getEmpleado();
				$fecha = $data->getFecha();
				$hora = new DateTime($data->getHora());
				/*
				Si la pila $ready esta vacia, la inicializa tomando
				el primer registro de la pila $rawData. De lo contrario,
				compara el nuevo registro con el registro anterior de
				$ready.
				*/
				if (sizeof($ready) > 0) { // Condicion 1
					$anterior = $ready[$x-1];
					if ($anterior['empleado'] == $data->getEmpleado() &&
						$anterior['fecha'] == $data->getFecha()) { // Condicion 2.
							/*
							Si tanto el empleado como la fecha coinciden,
							significa que es otro registro del mismo empleado
							en el mismo dia por lo que debe de determinar
							la diferencia entre las horas para saber si
							corresponde a la entrada o a la salida.
							*/
							$horaAux = new DateTime($anterior['horaEntrada']);
							$horaNueva = new DateTime($data->getHora());
							// Comparacion de las horas.
							if ($horaNueva >= $horaAux) {
								$ready[$x-1]['horaSalida'] = $horaNueva->format('H:i:s');
							}else {
								$ready[$x-1]['horaSalida'] = $ready[$x-1]['horaEntrada'];
								$ready[$x-1]['horaEntrada'] = $horaNueva->format('H:i:s');
							}
					}else{ // Else de la condicion 2.
						$registro = array();
						$registro['empleado'] = $empleado;
						$registro['fecha'] = $fecha;
						$registro['horaEntrada'] = $hora->format('H:i:s');
						$registro['horaSalida'] = "00:00:00";
						$registro['diff'] = "00:00:00";
						$ready[$x] = $registro;
						$x++;
					} // Fin de la condicion 2.
				}else{ // Else de la condicion 1.
					$registro = array();
					$registro['empleado'] = $empleado;
					$registro['fecha'] = $fecha;
					$registro['horaEntrada'] = $hora->format('H:i:s');
					$registro['horaSalida'] = "00:00:00";
					$registro['diff'] = "00:00:00";
					$ready[$x] = $registro;
					$x++;
				} // Fin de la condicion 1.
			}
			/*
			Calcular la diferencia de horas entre la entrada y la salida.
			Si falta una hora para calcular la diferencia, el registro se
			separa para ser llenado manualmente.
			*/
			$readyAux = array();
			while (sizeof($ready) > 0) {
				$data = array_shift($ready);

				$entrada = new DateTime($data['horaEntrada']);
				$salida = new DateTime($data['horaSalida']);
				$diff = date_diff($entrada, $salida);
				$data['diff'] = $diff->format('%H:%I:%S');

				array_push($readyAux, $data);
			}
			$ready = $readyAux;
			$readyAux = null;
			/* Fragmento de prueba
			foreach ($readyAux as $data) {
				$b = $data['empleado'];
				$c = $data['fecha'];
				$d = $data['horaEntrada'];
				$e = $data['horaSalida'];
				$f = sizeof($ready);
				$g = $data['diff'];
				echo "$f |$b | $c | $d | $e | $g<br>";
			}*/
			return $ready;
		}

		function cargar(array $data){
			$repetidos = 0;
			while (sizeof($data) > 0) {
				$registro = array_shift($data);

				$idEmpleado = $registro['empleado'];
				$fecha = $registro['fecha'];
				$horaEntrada = $registro['horaEntrada'];
				$horaSalida = $registro['horaSalida'];
				$diferencia = $registro['diff'];

				$qst = "SELECT * FROM horariocumplido WHERE idEmpleado = $idEmpleado AND fecha = '$fecha'";
				$rs = $this->conn->query($qst);

				// Par comprobar si el registro aun no existe.
				if ($rs->rowCount() == 0) {
					if ($registro['horaSalida'] == null) {
						$st = $this->conn->prepare("INSERT INTO horariocumplido (idEmpleado, fecha, horaEntrada, diferencia) VALUES
						(:idEmpleado, :fecha, :horaEntrada, :diferencia)");
						$diferencia = "00:00:00";
						$st->bindparam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
						$st->bindparam(':fecha', $fecha, PDO::PARAM_STR, 10);
						$st->bindparam(':horaEntrada', $horaEntrada, PDO::PARAM_STR, 8);
						$st->bindparam(':diferencia', $diferencia, PDO::PARAM_STR, 8);
						$st->execute();

					}else {
						$st = $this->conn->prepare("INSERT INTO horariocumplido (idEmpleado, fecha, horaEntrada, horaSalida, diferencia) VALUES
						(:idEmpleado, :fecha, :horaEntrada, :horaSalida, :diferencia)");
						$st->bindparam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
						$st->bindparam(':fecha', $fecha, PDO::PARAM_STR, 10);
						$st->bindparam(':horaEntrada', $horaEntrada, PDO::PARAM_STR, 8);
						$st->bindparam(':horaSalida', $horaSalida, PDO::PARAM_STR, 8);
						$st->bindparam(':diferencia', $diferencia, PDO::PARAM_STR, 8);
						$st->execute();
					}
				}else {
					$repetidos++;
				}
			}
			return $repetidos;
		}
	}
?>
