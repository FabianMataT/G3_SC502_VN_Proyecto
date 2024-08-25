<?php

class Carnet {

    private $id_carnet;
    private $id_usuario;
    private $id_estado;
    private $nombre_animal;
    private $raza;
    private $anio_rescate;
    private $descripcion;
    private $estado;
    private $imagen;



    public function getId_carnet() {
        return $this->id_carnet;
    }

    public function setId_carnet($id_carnet): void {
        $this->id_carnet = $id_carnet;
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function setId_usuario($id_usuario): void {
        $this->id_usuario = $id_usuario;
    }

    public function getId_estado() {
        return $this->id_estado;
    }

    public function setId_estado($id_estado): void {
        $this->id_estado = $id_estado;
    }
    
    
    public function getNombre_animal() {
        return $this->nombre_animal;
    }

    public function setNombre_animal($nombre_animal): void {
        $this->nombre_animal = $nombre_animal;
    }

    public function getRaza() {
        return $this->raza;
    }

    public function setRaza($raza): void {
        $this->raza = $raza;
    }

    public function getAnio_rescate() {
        return $this->anio_rescate;
    }

    public function setAnio_rescate($anio_rescate): void {
        $this->anio_rescate = $anio_rescate;
    }


    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }
    
    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen): void {
        $this->imagen = $imagen;
    }

}