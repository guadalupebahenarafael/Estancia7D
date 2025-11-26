<?php

include_once "config/db_connection.php";
include_once "app/models/ProgramaModel.php";

/**
 * CONTROLADOR DE PROGRAMAS
 * CRUD completo + validaciones
 */
class ProgramaController
{
    private $model;

    /** Constructor: recibe la conexión e inicializa el modelo */
    public function __construct($connection)
    {
        $this->model = new ProgramaModel($connection);
    }

    /* ============================================================
       INSERTAR PROGRAMA
       ============================================================ */
    public function insertarPrograma()
    {
        // Consultar áreas para llenar el <select>
        $areas = $this->model->consultarArea();

        // --------- Si se envía formulario ---------
        if (isset($_POST['enviar'])) {

            // Validaciones básicas
            $nombre          = trim($_POST['nombre'] ?? '');
            $vigencia        = trim($_POST['vigencia'] ?? '');
            $certificaciones = trim($_POST['certificaciones'] ?? '');
            $nivel           = trim($_POST['nivel'] ?? '');
            $ID_Area         = (int) ($_POST['ID_Area'] ?? 0);

            if ($nombre === '' || $vigencia === '' || $certificaciones === '' || 
                $nivel === '' || $ID_Area <= 0) {

                echo "<script>
                        alert('Todos los campos son obligatorios.');
                        window.location.href = 'index.php?controller=programa&action=insertarPrograma';
                      </script>";
                return;
            }

            // Insertar BD
            $insert = $this->model->insertarPrograma(
                $nombre, $vigencia, $certificaciones, $nivel, $ID_Area
            );

            $msg = $insert ? 'Registro exitoso' : 'Error al registrar';

            echo "<script>
                    alert('$msg');
                    window.location.href = 'index.php?controller=programa&action=insertarPrograma';
                  </script>";
            return;
        }

        // Cargar vista si NO se envió formulario
        include "app/views/form_insertPrograma.php";
    }

    /* ============================================================
       CONSULTAR PROGRAMAS
       ============================================================ */
    public function consultarPrograma()
    {
        $programas = $this->model->consultarPrograma();
        include "app/views/consult_programa.php";
    }

    /* ============================================================
       ACTUALIZAR PROGRAMA
       ============================================================ */
    public function actualizarPrograma()
    {
        // Consultar áreas para la vista
        $areas = $this->model->consultarArea();

        // --------- Mostrar datos en formulario ---------
        if (isset($_GET['id'])) {

            $id = (int) $_GET['id'];
            $row = $this->model->consultarPorID($id);

            if (!$row) {
                echo "<script>
                        alert('Programa no encontrado.');
                        window.location.href = 'index.php?controller=programa&action=consultarPrograma';
                      </script>";
                return;
            }

            include "app/views/editar_programa.php";
            return;
        }

        // --------- Procesar actualización ---------
        if (isset($_POST['editar'])) {

            $ID_Programa     = (int) $_POST['id'];
            $nombre          = trim($_POST['nombre'] ?? '');
            $vigencia        = trim($_POST['vigencia'] ?? '');
            $certificaciones = trim($_POST['certificaciones'] ?? '');
            $nivel           = trim($_POST['nivel'] ?? '');
            $ID_Area         = (int) ($_POST['ID_Area'] ?? 0);

            // Validaciones
            if ($ID_Programa <= 0 || $nombre === '' || $vigencia === '' ||
                $certificaciones === '' || $nivel === '' || $ID_Area <= 0) {

                echo "<script>
                        alert('Todos los campos son obligatorios.');
                        window.location.href = 'index.php?controller=programa&action=consultarPrograma';
                      </script>";
                return;
            }

            // Actualizar
            $update = $this->model->actualizarPrograma(
                $ID_Programa, $nombre, $vigencia, 
                $certificaciones, $nivel, $ID_Area
            );

            $msg = $update ? 'Actualización exitosa' : 'Error al actualizar';

            echo "<script>
                    alert('$msg');
                    window.location.href = 'index.php?controller=programa&action=consultarPrograma';
                  </script>";
            return;
        }

        // Si no hay POST ni GET, evita cargar vista vacía
        echo "<script>
                alert('No se recibió información válida.');
                window.location.href = 'index.php?controller=programa&action=consultarPrograma';
              </script>";
    }

    /* ============================================================
       ELIMINAR PROGRAMA
       ============================================================ */
    public function eliminarPrograma()
    {
        if (!isset($_GET['id'])) {
            echo "<script>
                    alert('No se especificó el registro a eliminar.');
                    window.location.href = 'index.php?controller=programa&action=consultarPrograma';
                  </script>";
            return;
        }

        $id = (int) $_GET['id'];

        if ($id <= 0) {
            echo "<script>
                    alert('ID no válido.');
                    window.location.href = 'index.php?controller=programa&action=consultarPrograma';
                  </script>";
            return;
        }

        $delete = $this->model->eliminarPrograma($id);

        $msg = $delete ? 'Eliminación exitosa' : 'Error al eliminar';

        echo "<script>
                alert('$msg');
                window.location.href = 'index.php?controller=programa&action=consultarPrograma';
              </script>";
    }

}
