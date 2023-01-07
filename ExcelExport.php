<?php

/**
 * Author: Mahmoud Reda
 * Date: 07-01-2023
 */

namespace App\Traits;

trait ExcelExport
{
    public function exportCsv(array $data)
    {
        $fileName = $this->getFileName();

        $filePath = $this->getFilePath();

        $handler = fopen($filePath, 'w');

        fputcsv($handler, array_keys($data[0]));

        foreach (array_chunk($data, 500) as $items) {
            foreach ($items as $item) {
                fputcsv($handler, $item);
            }
        }

        fclose($handler);

        return response()->download($filePath, $fileName)->deleteFileAfterSend();
    }

    private function getFileName(): string
    {
        return 'excel_export_' . time() . '.csv';
    }

    private function getFilePath(): string
    {
        return storage_path('app/public/' . $this->getFileName());
    }
}
