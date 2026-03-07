<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
class Dompdffile extends DOMPDF{

    protected function ci()
    {
        return get_instance();
    }

    public function load_view($view, $data = array())
    {
        $dompdf = new Dompdf();
        $html = $this->ci()->load->view($view, $data, TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $time = time();
        $dompdf->stream($time, array("Attachment" => false));
    }
}