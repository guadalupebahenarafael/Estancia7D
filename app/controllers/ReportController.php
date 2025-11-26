<?php

include_once "app/models/ReportModel.php";
include_once "config/db_connection.php";
include_once "public/libraries/fpdf/fpdf.php";
include_once "public/libraries/phplot/phplot.php";

/* ============================================================
   PLANTILLA PDF – portada, encabezado, pie, tarjetas, secciones
   ============================================================ */
class PDF_Report extends FPDF
{
    private $mainTitle = '';
    private $subTitle  = '';

    public function setTitles($main, $sub = '')
    {
        $this->mainTitle = $main;
        $this->subTitle  = $sub;
    }

    /* Encabezado */
    function Header()
    {
        // Logo opcional
        $logoPath = 'public/media/img/logo.png';
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 10, 8, 18);
        }

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 7, utf8_decode($this->mainTitle), 0, 1, 'C');

        if ($this->subTitle !== '') {
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 5, utf8_decode($this->subTitle), 0, 1, 'C');
        }

        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, "Fecha de emisión: " . date("d/m/Y H:i"), 0, 1, "R");

        $this->Ln(3);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(4);
    }

    /* Pie */
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 5, 'Sistema de Objetos Perdidos', 0, 1, 'L');
        $this->Cell(0, 5, 'Página '.$this->PageNo().'/{nb}', 0, 0, 'R');
    }

    /* Sección */
    public function sectionTitle($title)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(30, 30, 30);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 8, utf8_decode($title), 0, 1, 'L', true);
        $this->Ln(2);
        $this->SetTextColor(0, 0, 0);
    }

    /* Tarjeta de resumen */
    public function summaryCard($x, $y, $w, $h, $label, $value)
    {
        $this->SetXY($x, $y);
        $this->SetFillColor(245, 245, 245);
        $this->Rect($x, $y, $w, $h, 'DF');

        $this->SetXY($x + 3, $y + 2);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell($w - 6, 5, utf8_decode($label), 0, 2, 'L');

        $this->SetFont('Arial', 'B', 14);
        $this->Cell($w - 6, 10, $value, 0, 0, 'L');
    }
}

/* ============================================================
   CONTROLADOR DE REPORTES
   ============================================================ */
class ReportController
{
    private $model;

    public function __construct($connection)
    {
        $this->model = new ReportModel($connection);
    }

    /* ============================================================
       UTILIDAD: contar totales (recuperados / pendientes)
       ============================================================ */
    private function contarEstados($datos)
    {
        $total = $datos->num_rows;
        $recuperados = 0;
        $pendientes  = 0;

        while ($r = $datos->fetch_assoc()) {
            if ($r['recuperado'] == 1 || $r['recuperado'] == 'si')
                $recuperados++;
            else
                $pendientes++;
        }
        $datos->data_seek(0);

        return [$total, $recuperados, $pendientes];
    }

    /* ============================================================
       UTILIDAD: generar encabezado de PDF + tarjetas
       ============================================================ */
    private function generarTarjetas($pdf, $total, $rec, $pen)
    {
        $y = $pdf->GetY();
        $pdf->summaryCard(20,  $y, 55, 20, "Total objetos", $total);
        $pdf->summaryCard(85,  $y, 55, 20, "Recuperados",   $rec);
        $pdf->summaryCard(150, $y, 55, 20, "Pendientes",    $pen);
        $pdf->Ln(30);
    }

    /* ============================================================
       VISTAS (PANTALLA)
       ============================================================ */

    public function vistaReportePorGenero()
    {
        $generos = $this->model->obtenerGeneros();
        $todos_los_objetos = $this->model->obtenerTodosConGenero();
        include "app/views/reportes/reporte_objetos_por_genero.php";
    }

    public function vistaReportePorCategoria()
    {
        $categorias = $this->model->obtenerCategorias();
        $todos_los_objetos = $this->model->obtenerTodosConCategoria();
        include "app/views/reportes/reporte_objetos_por_categoria.php";
    }

    public function vistaReportePorEdificio()
    {
        $areas = $this->model->obtenerAreas();
        $todos_los_objetos = $this->model->obtenerTodosConArea();
        include "app/views/reportes/reporte_objetos_por_edificio.php";
    }

    /* ============================================================
       PDF: REPORTE POR GÉNERO
       ============================================================ */
    public function ReporteObjetosPorGenero()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "<script>alert('Debe seleccionar un género.');</script>";
            $this->vistaReportePorGenero();
            return;
        }

        $genero = trim($_POST['genero'] ?? '');
        if ($genero === '') {
            echo "<script>alert('Debe seleccionar un género.');</script>";
            $this->vistaReportePorGenero();
            return;
        }

        $valid = $this->model->validarGenero($genero);
        if ($valid->num_rows === 0) {
            echo "<script>alert('El género no existe.');</script>";
            $this->vistaReportePorGenero();
            return;
        }

        $datos = $this->model->consultarObjetosPorGenero($genero);
        list($total, $recuperados, $pendientes) = $this->contarEstados($datos);

        if (ob_get_length()) ob_clean();

        $pdf = new PDF_Report('P','mm','Letter');
        $pdf->AliasNbPages();
        $pdf->setTitles("Reporte de Objetos por Género", "Género: ".utf8_decode($genero));
        $pdf->AddPage();

        $this->generarTarjetas($pdf, $total, $recuperados, $pendientes);

        $pdf->sectionTitle("Listado de Objetos");

        // Encabezado tabla
        $pdf->SetFont('Arial','B',9);
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(15,8,"ID",1,0,'C',true);
        $pdf->Cell(35,8,"Objeto",1,0,'C',true);
        $pdf->Cell(30,8,"Categoria",1,0,'C',true);
        $pdf->Cell(25,8,"Marca",1,0,'C',true);
        $pdf->Cell(25,8,"Estado",1,0,'C',true);
        $pdf->Cell(45,8,"Area",1,1,'C',true);

        $pdf->SetFont('Arial','',9);
        $pdf->SetTextColor(0,0,0);
        $fill = false;

        while ($row = $datos->fetch_assoc()) {
            $estado = ($row['recuperado']=='si'||$row['recuperado']==1) ? "Recuperado" : "Pendiente";
            $pdf->SetFillColor($fill ? 235 : 255);

            $pdf->Cell(15,8,$row['ID_Objeto'],1,0,'C',$fill);
            $pdf->Cell(35,8,utf8_decode($row['nombre_objeto']),1,0,'C',$fill);
            $pdf->Cell(30,8,utf8_decode($row['categoria']),1,0,'C',$fill);
            $pdf->Cell(25,8,utf8_decode($row['marca']),1,0,'C',$fill);
            $pdf->Cell(25,8,$estado,1,0,'C',$fill);
            $pdf->Cell(45,8,utf8_decode($row['nombre_area']),1,1,'C',$fill);

            $fill = !$fill;
        }

        $pdf->Output("D", "Reporte_Genero_$genero.pdf");
        exit;
    }

    /* ============================================================
       PDF: REPORTE POR CATEGORÍA
       ============================================================ */
    public function ReporteObjetosPorCategoria()
    {
        if (!isset($_POST['categoria']) || $_POST['categoria'] === '') {
            echo "<script>alert('Seleccione una categoría.');</script>";
            $this->vistaReportePorCategoria();
            return;
        }

        $categoria = $_POST['categoria'];
        $datos = $this->model->consultarObjetosPorCategoria($categoria);
        list($total,$rec,$pen) = $this->contarEstados($datos);

        if (ob_get_length()) ob_clean();

        $pdf = new PDF_Report('P','mm','Letter');
        $pdf->AliasNbPages();
        $pdf->setTitles("Reporte de Objetos por Categoría", "Categoría: ".utf8_decode($categoria));
        $pdf->AddPage();

        $this->generarTarjetas($pdf, $total,$rec,$pen);
        $pdf->sectionTitle("Listado de Objetos");

        // Encabezado
        $pdf->SetFont('Arial','B',9);
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(15,8,"ID",1,0,'C',true);
        $pdf->Cell(40,8,"Objeto",1,0,'C',true);
        $pdf->Cell(30,8,"Género",1,0,'C',true);
        $pdf->Cell(30,8,"Marca",1,0,'C',true);
        $pdf->Cell(25,8,"Estado",1,0,'C',true);
        $pdf->Cell(35,8,"Área",1,1,'C',true);

        $pdf->SetFont('Arial','',9);
        $pdf->SetTextColor(0,0,0);
        $fill = false;

        while ($row = $datos->fetch_assoc()) {
            $estado = ($row['recuperado']==1 || $row['recuperado']=='si') ? "Recuperado" : "Pendiente";
            $pdf->SetFillColor($fill ? 235 : 255);

            $pdf->Cell(15,8,$row['ID_Objeto'],1,0,'C',$fill);
            $pdf->Cell(40,8,utf8_decode($row['nombre_objeto']),1,0,'C',$fill);
            $pdf->Cell(30,8,utf8_decode($row['genero']),1,0,'C',$fill);
            $pdf->Cell(30,8,utf8_decode($row['marca']),1,0,'C',$fill);
            $pdf->Cell(25,8,$estado,1,0,'C',$fill);
            $pdf->Cell(35,8,utf8_decode($row['nombre_area']),1,1,'C',$fill);

            $fill = !$fill;
        }

        $pdf->Output("D", "Reporte_Categoria_$categoria.pdf");
        exit;
    }

    /* ============================================================
       PDF: REPORTE POR EDIFICIO / ÁREA
       ============================================================ */
    public function ReporteObjetosPorEdificio()
    {
        if (!isset($_POST['ID_Area']) || $_POST['ID_Area'] == '') {
            echo "<script>alert('Seleccione un edificio o área.');</script>";
            $this->vistaReportePorEdificio();
            return;
        }

        $ID_Area = (int) $_POST['ID_Area'];
        $datos = $this->model->consultarObjetosPorEdificio($ID_Area);

        // Obtener nombre del área
        $nombreArea = "Desconocido";
        if ($tmp = $datos->fetch_assoc()) {
            $nombreArea = $tmp['nombre_area'];
            $datos->data_seek(0);
        }

        list($total,$rec,$pen) = $this->contarEstados($datos);

        if (ob_get_length()) ob_clean();

        $pdf = new PDF_Report('P','mm','Letter');
        $pdf->AliasNbPages();
        $pdf->setTitles("Reporte de Objetos por Área/Edificio", "Área: ".utf8_decode($nombreArea));
        $pdf->AddPage();

        $this->generarTarjetas($pdf,$total,$rec,$pen);
        $pdf->sectionTitle("Listado de Objetos");

        // Encabezado
        $pdf->SetFont('Arial','B',9);
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(15,8,"ID",1,0,'C',true);
        $pdf->Cell(40,8,"Objeto",1,0,'C',true);
        $pdf->Cell(30,8,"Categoría",1,0,'C',true);
        $pdf->Cell(30,8,"Marca",1,0,'C',true);
        $pdf->Cell(25,8,"Estado",1,0,'C',true);
        $pdf->Cell(35,8,"Género",1,1,'C',true);

        $pdf->SetFont('Arial','',9);
        $pdf->SetTextColor(0,0,0);
        $fill = false;

        while ($row = $datos->fetch_assoc()) {

            $estado = ($row['recuperado']==1||$row['recuperado']=='si') ? "Recuperado" : "Pendiente";

            $pdf->SetFillColor($fill ? 235 : 255);

            $pdf->Cell(15,8,$row['ID_Objeto'],1,0,'C',$fill);
            $pdf->Cell(40,8,utf8_decode($row['nombre_objeto']),1,0,'C',$fill);
            $pdf->Cell(30,8,utf8_decode($row['categoria']),1,0,'C',$fill);
            $pdf->Cell(30,8,utf8_decode($row['marca']),1,0,'C',$fill);
            $pdf->Cell(25,8,$estado,1,0,'C',$fill);
            $pdf->Cell(35,8,utf8_decode($row['genero']),1,1,'C',$fill);

            $fill = !$fill;
        }

        $pdf->Output("D", "Reporte_Area_$nombreArea.pdf");
        exit;
    }



    /* ============================================================
       GRAFICAS DE PASTEL (GENERO / CATEGORIA / EDIFICIO)
       ============================================================ */

    private function generarGrafica($data, $titulo, $archivo, $titulo_pdf)
    {
        $plot = new PHPlot(600, 400);
        $plot->SetDataValues($data);
        $plot->SetPlotType('pie');
        $plot->SetDataType('text-data-single');
        $plot->SetShading(30);
        $plot->SetTitle($titulo);
        $plot->SetLegend(array_column($data, 0));

        $plot->SetOutputFile($archivo);
        $plot->SetIsInline(true);
        $plot->DrawGraph();

        if (ob_get_length()) ob_clean();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,$titulo_pdf,0,1,'C');
        $pdf->Image($archivo, 30, 40, 150, 100);
        $pdf->Output();
        exit;
    }

    public function generarPastel()
    {
        $data = $this->model->consultarGenero();
        $this->generarGrafica(
            $data,
            "Porcentaje de generos",
            "public/media/graphs/pastel_genero.png",
            "Reporte por género"
        );
    }

    public function generarPastelCategoria()
    {
        $data = $this->model->consultarCategoria();
        $this->generarGrafica(
            $data,
            "Porcentaje por categoría",
            "public/media/graphs/pastel_categoria.png",
            "Reporte de Categorías"
        );
    }

    public function generarPastelEdificio()
    {
        $data = $this->model->consultarEdificio();
        $this->generarGrafica(
            $data,
            "Porcentaje por edificio",
            "public/media/graphs/pastel_edificio.png",
            "Reporte de Edificios"
        );
    }

}

?>
