<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
class Pdf extends DOMPDF
{
    function __construct()
    {
	   parent::__construct();
    }

	function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){    
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
		$dompdf->set_option('isRemoteEnabled', TRUE);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        if($download)
            $dompdf->stream($filename.'.pdf', array('Attachment' => 1));
        else
            $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }

	function createPDFEmail($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
		$dompdf->set_option('isRemoteEnabled', TRUE);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        return $dompdf->output();
    }
}
/*Author:Tutsway.com */
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
?>
