<?php
//originalmente era horariosr

include_once 'conexion.php';
session_start();
class arte {

    
    
    
    private $IdCatalogoM;
    private $descripcion;
    private $origenMueble;
    private $medidas;
    private $imgFrente;
    private $imgLateral;
    private $estadoCatalogoMueble;
    private $tipo;
    private $categoria;
    private $informacion;
    
    public function getIdCatalogoM(){
		return $this->IdCatalogoM;
	}

	public function setIdCatalogoM($IdCatalogoM){
		$this->IdCatalogoM = $IdCatalogoM;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function getOrigenMueble(){
		return $this->origenMueble;
	}

	public function setOrigenMueble($origenMueble){
		$this->origenMueble = $origenMueble;
	}

	public function getMedidas(){
		return $this->medidas;
	}

	public function setMedidas($medidas){
		$this->medidas = $medidas;
	}

	public function getImgFrente(){
		return $this->imgFrente;
	}

	public function setImgFrente($imgFrente){
		$this->imgFrente = $imgFrente;
	}

	public function getImgLateral(){
		return $this->imgLateral;
	}

	public function setImgLateral($imgLateral){
		$this->imgLateral = $imgLateral;
	}

	public function getEstadoCatalogoMueble(){
		return $this->estadoCatalogoMueble;
	}

	public function setEstadoCatalogoMueble($estadoCatalogoMueble){
		$this->estadoCatalogoMueble = $estadoCatalogoMueble;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getCategoria(){
		return $this->categoria;
	}

	public function setCategoria($categoria){
		$this->categoria = $categoria;
	}

	public function getInformacion(){
		return $this->informacion;
	}

	public function setInformacion($informacion){
		$this->informacion = $informacion;
	}
    
    
    function arteConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM arte ");
        $query->execute();
                
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            if($value['imgFrente']!='No Disponible') $imgFrente = "<a href='imgMuebles/".$value['imgFrente']."'  target='_blank'><img       src=\"imgMuebles/".$value['imgFrente']."\" width=\"150\"></a>"; else $imgFrente =$value['imgFrente'];
            if($value['imgLateral']!='No Disponible') $imgLateral ="<a href='imgMuebles/".$value['imgLateral']."'  target='_blank'><img src=\"imgMuebles/".$value['imgLateral']."\" width=\"150\"></a>"; else $imgLateral =$value['imgLateral'];
            
            $modificar='<a href="arteModificar.php?id='.$value['idCatalogoM'].'" class="btn btn-default">Modificar</a>';
            $arte[$key] = array(
                
              $value['idCatalogoM'],
              $value['origenMueble'],            
              $value['descripcion'], 
              $value['medidas'],
              $value['categoria'],
              $imgFrente,
              $imgLateral,
              $value['informacion']
             // '<a href="arteModificar.php?id='.$value['idCatalogoM'].'" class="btn btn-default">Modificar</a>'
            );
           
            
        }
        return $arte;    
    }
    
    
    function arteAlta() {
        try {
        $pdo = new Conexion();
         $query = $pdo->prepare("INSERT INTO arte (descripcion, origenMueble, medidas, imgFrente, imgLateral, estadoCatalogoMueble, tipo, categoria, informacion) VALUES ('".$this->getDescripcion()."', "
                ."'".$this->getOrigenMueble()."', "
                ."'".$this->getMedidas()."', "
                ."'".$this->getImgFrente()."', "
                ."'".$this->getImgLateral()."', "
                ."'".$this->getEstadoCatalogoMueble()."', "
                ."'".$this->getTipo()."', "
                ."'".$this->getCategoria()."', "
                . $this->getInformacion().");");
        
        echo    "INSERT INTO arte (descripcion, origenMueble, medidas, imgFrente, imgLateral, estadoCatalogoMueble, tipo, categoria, informacion) 
        VALUES (
        '".$this->getDescripcion()."',"
        ."'".$this->getOrigenMueble()."',"
        ."'".$this->getMedidas()."',"
        ."'".$this->getImgFrente()."',"
        ."'".$this->getImgLateral()."',"
        ."'".$this->getEstadoCatalogoMueble()."',"
        ."'".$this->getTipo()."',"
        ."'".$this->getCategoria()."',"
        ."'".$this->getInformacion()."');";
        
        //."'". $this->getFichaTecnica()."', "
        //."'". $this->getCategoria()."', "
            
            $query->execute();
            
            echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<center><br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    
    
    function arteModificar() {
        try {
        
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM arte WHERE idCatalogoM=".$this->getIdCatalogoM().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setIdCatalogoM($value['idCatalogoM']);
            $this ->setOrigenMueble($value['origenMueble']);
            $this ->setDescripcion($value['descripcion']);
            $this ->setMedidas($value['medidas']);
            $this ->setCategoria($value['categoria']);
            $this ->setInformacion($value['informacion']);
            
        }
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    
}
?>