<?php

include_once "config/db_connection.php";
include_once "app/models/ObjetoModel.php";

/**
 * CONTROLADOR DE OBJETOS
 * CRUD completo con validaciones + código estandarizado
 */
class ObjetoController
{
    private $model;

    public function __construct($connection)
    {
        $this->model = new ObjetoModel($connection);
    }

    /* ============================================================
       FUNCIONES AUXILIARES
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
       INSERTAR OBJETO
       ============================================================ */
    public function insertarObjeto()
    {
        // Consulta de áreas para llenar el <select>
        $objetos = $this->model->consultarArea();

        // Si enviaron el formulario
        if (isset($_POST['enviar'])) {

            $nombre          = trim($_POST['nombre'] ?? '');
            $categoria       = trim($_POST['categoria'] ?? '');
            $ID_Area         = (int) ($_POST['ID_Area'] ?? 0);
            $caracteristicas = trim($_POST['caracteristicas'] ?? '');
            $marca           = trim($_POST['marca'] ?? '');

            // Validación
            if ($nombre === '' || $categoria === '' || $ID_Area <= 0 ||
                $caracteristicas === '' || $marca === '') {

                $this->alertRedirect(
                    "Todos los campos son obligatorios.",
                    "index.php?controller=objeto&action=insertarObjeto"
                );
            }

            // Insertar
            $insert = $this->model->insertarObjeto(
                $nombre, $categoria, $ID_Area, $caracteristicas, $marca
            );

            if ($insert) {
                echo "<script>
                    alert('Registro exitoso');
                  </script>";
            } else {
                echo "<script>
                    alert('Error al registrar');
                  </script>";
            }
        }

        // Cargar vista del formulario
        include "app/views/form_insertObjeto.php";
    }

    /* ============================================================
       CONSULTAR OBJETOS
       ============================================================ */
    public function consultarObjeto()
    {
        $objetos = $this->model->consultarObjeto();
        include "app/views/consult_objeto.php";
    }

    /* ============================================================
       ACTUALIZAR OBJETO
       ============================================================ */
    public function actualizarObjeto()
    {
        $objetos = $this->model->consultarArea();

        // Mostrar datos en formulario
        if (isset($_GET['id'])) {

            $id = (int) $_GET['id'];
            $row = $this->model->consultarPorID($id);

            if (!$row) {
                $this->alertRedirect(
                    "Objeto no encontrado.",
                    "index.php?controller=objeto&action=consultarObjeto"
                );
            }

            include "app/views/editar_objeto.php";
            return;
        }

        // Guardar cambios
        if (isset($_POST['editar'])) {

            $btn_rol        = (int) ($_POST['rol'] ?? 0);
            $ID_Objeto      = (int) ($_POST['id'] ?? 0);

            $nombre         = trim($_POST['nombre']);
            $categoria      = trim($_POST['categoria']);
            $ID_Area        = (int) $_POST['ID_Area'];
            $recuperado     = trim($_POST['recuperado']);
            $caracteristicas= trim($_POST['caracteristicas']);
            $marca          = trim($_POST['marca']);
            $genero         = trim($_POST['genero']);

            if (
                $ID_Objeto <= 0 || $nombre === '' || $categoria === '' ||
                $ID_Area <= 0 || $recuperado === '' ||
                $caracteristicas === '' || $marca === '' || $genero === ''
            ) {
                $this->alertRedirect(
                    "Todos los campos son obligatorios.",
                    "index.php?controller=objeto&action=consultarObjeto&rol={$btn_rol}"
                );
            }

            $update = $this->model->actualizarObjeto(
                $ID_Objeto, $nombre, $categoria, $ID_Area,
                $recuperado, $caracteristicas, $marca, $genero
            );

            $msg = $update ? "Actualización exitosa" : "Error al actualizar";

            $this->alertRedirect(
                $msg,
                "index.php?controller=objeto&action=consultarObjeto&rol={$btn_rol}"
            );
        }

        $this->alertRedirect(
            "No se recibió información válida.",
            "index.php?controller=objeto&action=consultarObjeto"
        );
    }

    /* ============================================================
       ELIMINAR OBJETO
       ============================================================ */
    public function eliminarObjeto()
    {
        if (!isset($_GET['id']) || !isset($_GET['rol'])) {
            $this->alertRedirect(
                "Datos incompletos para eliminar.",
                "index.php?controller=objeto&action=consultarObjeto"
            );
        }

        $id      = (int) $_GET['id'];
        $btn_rol = (int) $_GET['rol'];

        if ($id <= 0) {
            $this->alertRedirect(
                "ID inválido.",
                "index.php?controller=objeto&action=consultarObjeto&rol={$btn_rol}"
            );
        }

        $delete = $this->model->eliminarObjeto($id);

        $msg = $delete ? "Eliminación exitosa" : "Error al eliminar";

        $this->alertRedirect(
            $msg,
            "index.php?controller=objeto&action=consultarObjeto&rol={$btn_rol}"
        );
    }

}
