<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class PDF
{
    static function createPDF($html, $filename = '', $download = true, $paper = 'A4', $orientation = 'portrait')
    {
        $option = new Options();
        $option->setIsRemoteEnabled(true);
        $option->isPhpEnabled(true);
        $dompdf = new Dompdf($option);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($download === true) {
            $dompdf->stream($filename, array('Attachment' => 1));
        } else {
            $dompdf->stream($filename, array('Attachment' => 0));
            // $output = $dompdf->output();
            // file_put_contents(public_path('assets/pdf/' . $filename), $output);
            // $path = $filename;
            // return $path;
        }
    }

    static function createDownloadPDF($html, $filename = '', $download = true, $paper = 'A4', $orientation = 'portrait')
    {
        $option = new Options();
        $option->setIsRemoteEnabled(true);
        $option->isPhpEnabled(true);
        $dompdf = new Dompdf($option);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($download === true) {
            $dompdf->stream($filename, array('Attachment' => 1));
        } else {
            // $dompdf->stream($filename, array('Attachment' => 0));
            $output = $dompdf->output();
            file_put_contents(public_path('assets/pdf/' . $filename), $output);
            $path = $filename;
            return $path;
        }
    }
}
