<?php
defined('MR') or exit('No direct script access allowed');

require_once './vendor/dompdf/autoload.inc.php';


use Dompdf\Dompdf;

class Pdf extends Dompdf{
	public function __construct() {
        parent::__construct();
    }

}

?>