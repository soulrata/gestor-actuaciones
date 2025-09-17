<?php

namespace App\Exports\Traits;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

trait ExcelStylesTrait
{
    /**
     * Aplicar estilos estándar para todos los exports de Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Obtener el rango total de la hoja
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();
        $range = 'A1:' . $highestColumn . $highestRow;
        
        // Estilos para los encabezados (fila 1)
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Texto blanco
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3A8A'], // Azul #1e3a8a
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Borde negro
                ],
            ],
        ];
        
        // Estilos para el contenido (resto de filas)
        $contentStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Borde negro
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Aplicar estilos
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray($headerStyle);
        
        // Solo aplicar estilos de contenido si hay más de una fila
        if ($highestRow > 1) {
            $sheet->getStyle('A2:' . $highestColumn . $highestRow)->applyFromArray($contentStyle);
        }
        
        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', $highestColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Configurar altura de la fila de encabezados
        $sheet->getRowDimension(1)->setRowHeight(25);
        
        return [];
    }
}
