<?php
    class ObjetoAsistencia{
        private $idAsistencia;
        private $codigoUDG;
        private $fecha;
        private $hora;
        private $idEmpleado;

        function __construct(){}

        public function setAsistencia($idAsistencia){
            $this->idAsistencia = $idAsistencia;
            return $this;
        }
        public function setCodigoUDG($codigoUDG){
            $this->codigoUDG = $codigoUDG;
            return $this;
        }
        public function setFecha($fecha){
            $this->fecha = $fecha;
            return $this;
        }
        public function setHora($hora){
            $this->hora = $hora;
            return $this;
        }
        public function setEmpleado($idEmpleado){
            $this->idEmpleado = $idEmpleado;
            return $this;
        }



        public function getAsistencia(){
            return $this->idAsistencia;
        }
        public function getFecha(){
            return $this->fecha;
        }
        public function getHora(){
            return $this->hora;
        }
        public function getCodigoUDG(){
            return $this->codigoUDG;
        }
        public function getEmpleado(){
            return $this->idEmpleado;
        }

    }

//----------------------------------------------------------------------------

    class ObjetoHorario{
        private $idEmpleado;
        private $fecha;
        private $horaEntrada;
        private $horaSalida;
        private $diff;

        function __construct(){}

        public function setEmpleado($idEmpleado){
            $this->idEmpleado = $idEmpleado;
            return $this;
        }
        public function setFecha($fecha){
            $this->fecha = $fecha;
            return $this;
        }
        public function setHoraEntrada($horaEntrada){
            $this->horaEntrada = $horaEntrada;
            return $this;
        }
        public function setHoraSalida($horaSalida){
            $this->horaSalida = $horaSalida;
            return $this;
        }
        public function setDiff($diff){
            $this->diff = $diff;
            return $this;
        }



        public function getEmpleado(){
            return $this->idEmpleado;
        }
        public function getFecha(){
            return $this->fecha;
        }
        public function getHoraEntrada(){
            return $this->horaEntrada;
        }
        public function getHoraSalida(){
            return $this->horaSalida;
        }
        public function getDiff(){
            return $this->diff;
        }
    }
 ?>
