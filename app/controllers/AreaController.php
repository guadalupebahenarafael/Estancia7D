<?php

include_once "config/db_connection.php";
include_once "app/models/AreaModel.php";

/**
 * CONTROLADOR DE AREAS
 * CRUD + validaciones + código limpio
 */
class AreaController
{
    private $model;

    public function __construct($connection)
    {
        $this->model = new AreaModel($connection);
    }

    /* ============================================================
       FUNCIONES AUXILIARES REUTILIZABLES
       ============================================================ */

    private function alertBack($msg)
    {
        echo "<script>alert('$msg'); window.history.back();</script>";
        exit;
    }

    private function alertRedirect($msg, $ruta)
    {
        echo "<script>alert('$msg'); window.location.href='$ruta';</script>";
        exit;
    }

    /* ============================================================
       INSERTAR AREA
       ============================================================ */
    public function insertarArea()
    {
        if (isset($_POST['enviar'])) {

            $nombre      = trim($_POST['nombre']);
            $salon       = (int) $_POST['salon'];
            $laboratorio = (int) $_POST['laboratorio'];
            $piso        = (int) $_POST['piso'];

            // ============================
            // VALIDACIONES
            // ============================

            if ($nombre === "") {
                $this->alertBack("El nombre del área es obligatorio.");
            }

            if ($salon < 0) {
                $this->alertBack("El número de salón no puede ser negativo.");
            }

            if ($laboratorio < 0) {
                $this->alertBack("El valor de laboratorio no puede ser negativo.");
            }

            if ($piso < 0 || $piso > 10) {
                $this->alertBack("El número de piso debe estar entre 0 y 10.");
            }

            // INSERTAR
            $insert = $this->model->insertarArea($nombre, $salon, $laboratorio, $piso);

            if ($insert) {
                $this->alertRedirect("Registro exitoso", "index.php?controller=area&action=insertarArea");
            } else {
                $this->alertRedirect("Error al registrar el área", "index.php?controller=area&action=insertarArea");
            }
        }

        include "app/views/form_insertArea.php";
    }

    /* ============================================================
       CONSULTAR AREAS
       ============================================================ */
    public function consultarArea()
    {
        $areas = $this->model->consultarArea();
        include "app/views/consult_area.php";
    }

    /* ============================================================
       ACTUALIZAR AREA
       ============================================================ */
    public function actualizarArea()
    {
        // ── 1. Cargar formulario ───────────────────────────────
        if (isset($_GET['id'])) {

            $id = (int) $_GET['id'];
            $row = $this->model->consultarPorID($id);

            if (!$row) {
                $this->alertRedirect("El área no existe.", "index.php?controller=area&action=consultarArea");
            }

            include "app/views/editar_area.php";
            return;
        }

        // ── 2. Guardar cambios ────────────────────────────────
        if (isset($_POST['editar'])) {

            $ID_Area     = (int) $_POST['id'];
            $nombre      = trim($_POST['nombre']);
            $salon       = (int) $_POST['salon'];
            $laboratorio = (int) $_POST['laboratorio'];
            $piso        = (int) $_POST['piso'];

            // VALIDACIONES
            if ($ID_Area <= 0) {
                $this->alertBack("ID de área inválido.");
            }

            if ($nombre === "") {
                $this->alertBack("El nombre del área es obligatorio.");
            }

            if ($salon < 0) {
                $this->alertBack("El número de salón no puede ser negativo.");
            }

            if ($laboratorio < 0) {
                $this->alertBack("El valor de laboratorio no puede ser negativo.");
            }

            if ($piso < 0 || $piso > 10) {
                $this->alertBack("El número de piso debe estar entre 0 y 10.");
            }

            // ACTUALIZAR
            $update = $this->model->actualizarArea($ID_Area, $nombre, $salon, $laboratorio, $piso);

            if ($update) {
                $this->alertRedirect("Actualización exitosa", "index.php?controller=area&action=consultarArea");
            } else {
                $this->alertRedirect("Error al actualizar", "index.php?controller=area&action=consultarArea");
            }
        }

        include "app/views/editar_area.php";
    }

    /* ============================================================
       ELIMINAR AREA
       ============================================================ */
    public function eliminarArea()
    {
        if (isset($_GET['id'])) {

            $id = (int) $_GET['id'];

            if ($id <= 0) {
                $this->alertBack("ID inválido.");
            }

            $delete = $this->model->eliminarArea($id);

            if ($delete) {
                $this->alertRedirect("Eliminación exitosa", "index.php?controller=area&action=consultarArea");
            } else {
                $this->alertRedirect("Error al eliminar", "index.php?controller=area&action=consultarArea");
            }
        }
    }
}
