<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Disable autoloading from DOMPDF
define('DOMPDF_ENABLE_AUTOLOAD', false);

// Load Composer's autoloader
require_once FCPATH . 'vendor/autoload.php';

class Pdfgenerator {

    public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
    {
        // Initialize DOMPDF
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }
}

