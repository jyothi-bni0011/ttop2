<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    public function __construct()
    {
        // parent::__construct();
    }

    public function setFormat($orientation='P', $unit='mm', $format, $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false)
    {
    	parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }
}
