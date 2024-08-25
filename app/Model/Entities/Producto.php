<?php

class Producto {

    private $id_producto;
    private $id_usuario;
    private $id_ubicacion;
    private $titulo_publi;
    private $descripcion;
    private $imagen;
    private $estado;

    public function getId_producto() {
        return $this->id_producto;
    }

    public function setId_producto($id_producto): void {
        $this->id_producto = $id_producto;
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function setId_usuario($id_usuario): void {
        $this->id_usuario = $id_usuario;
    }

    public function getId_ubicacion() {
        return $this->id_ubicacion;
    }

    public function setId_ubicacion($id_ubicacion): void {
        $this->id_ubicacion = $id_ubicacion;
    }
    
    
    public function getTitulo_publi() {
        return $this->titulo_publi;
    }

    public function setTitulo_publi($titulo_publi): void {
        $this->titulo_publi = $titulo_publi;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen): void {
        $this->imagen = $imagen;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }
}