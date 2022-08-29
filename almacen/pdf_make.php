<?php
    // Clase para dar formato al pdf.
    class pdf_make{
        private $logo64;

        // Inicializacion de los elementos necesarios
        function __construct(){
            // Obtener la ruta del logo que se va a utilizar.
            $path = 'images/BIBLIOTECA_300.jpg';
            $data = file_get_contents($path);
            $this->logo64 = 'data:image/jpeg;base64,'.base64_encode($data);
        }

        // Generar PDF del reporte mensual
        function getMonthEncode($data, $ID){
            $encode = "";
            foreach ($data as $reg) {
                $dia = strip_tags($reg[1]);
                $entrada = strip_tags($reg[2]);
                if (strlen($reg[3]) > 8) {
                    $reg[3] = "Sin capturar";
                }
                if (strlen($reg[2]) > 8) {
                    $encode = $encode."['$ID', '$dia', {stack:[
                        { text: 'Con retardo', style: 'distinct' },
                        { text: '$entrada' }
                        ]}
                        , '$reg[3]' ,'$reg[4]', '$reg[5]'],";
                }else {
                    $encode = $encode."['$ID', '$dia', '$entrada', '$reg[3]' ,'$reg[4]', '$reg[5]'],";
                }

            }
            $encode = substr($encode, 0, -1);
            return $encode;
        }

        function permisoEncode($data){
            $encode = "";
            foreach ($data as $reg) {
                $str = strip_tags($reg);
                $encode = $encode."['$str'],";
            }
            $encode = substr($encode, 0, -1);
            return $encode;
        }

        // Generar PDF del reporte semanal
        function getWeekEncode($data){
            $encode = "";
            /*
            Proceso para quitarle las etiquetas html
            a los registros y acomodarlos para que se
            vean bien en la table del pdf
            */
            $dataFormat = array();
            foreach ($data as $reg){
                // El registro de horas comienza en el index 3
                $x = 3;
                // Mete los datos principales a un nuevo arreglo para guardar el formato
                $newReg = array(
                    $reg[0],
                    $reg[1],
                    $reg[2]
                );
                // Por cada uno de los dias de la semana, del index 3 al 9
                while($x < 10){
                    /*
                    Si no es un registro del Agua Azul o en blanco
                    hay que quitarle las etiquetas html y acomodar el texto
                    para el pdf.
                    */
                    if(strlen($reg[$x]) > 1 && $reg[$x] != "Agua Azul"){
                        $t = strip_tags($reg[$x]);
                        $reg[$x] = substr($t, 0, -13)."!".substr($t, -13);
                        $partes = explode("!", $reg[$x]);
                        $newReg[$x] = $partes;
                    }elseif(strlen($reg[$x]) == 1){
                        $newReg[$x] = array("-","");
                    }elseif ($reg[$x] == "Agua Azul") {
                        $newReg[$x] = array("","Agua Azul");
                    }
                    /*
                    Guarda el registro ya formateado en el nuevo arreglo
                    */

                    $x++;
                }
                array_push($dataFormat, $newReg);
            }

            foreach($dataFormat as $reg){
                $encode = $encode."[
                    '$reg[0]',
                    '$reg[1]',
                    '$reg[2]',
                    {stack:[{text: '".$reg[3][0]."', bold: true}, {text: '".$reg[3][1]."'}]},
                    {stack:[{text: '".$reg[4][0]."', bold: true}, {text: '".$reg[4][1]."'}]},
                    {stack:[{text: '".$reg[5][0]."', bold: true}, {text: '".$reg[5][1]."'}]},
                    {stack:[{text: '".$reg[6][0]."', bold: true}, {text: '".$reg[6][1]."'}]},
                    {stack:[{text: '".$reg[7][0]."', bold: true}, {text: '".$reg[7][1]."'}]},
                    {stack:[{text: '".$reg[8][0]."', bold: true}, {text: '".$reg[8][1]."'}]},
                    {stack:[{text: '".$reg[9][0]."', bold: true}, {text: '".$reg[9][1]."'}]}
                ],";
            }
            $encode = substr($encode, 0, -1);
            return $encode;
        }

        public function monthName($date){
            $months = array(
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre");
            $dateTime = new DateTime($date);
            $format = $months[intval($dateTime->format('n')) -1]." ".$dateTime->format('Y');
            return $format;
        }

        public function getImage64(){
            return $this->logo64;
        }
    }
 ?>
