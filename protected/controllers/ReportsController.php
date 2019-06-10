<?php
define('DOC_ROOT', preg_replace("!{$_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']));

require_once (DOC_ROOT . '/protected/extensions/tcpdf/tcpdf.php');
require_once (DOC_ROOT . '/protected/extensions/tcpdf/MYPDF.php');

class ReportsController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl' // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'renderpdf'
                ),
                'roles' => array(
                    'admin',
                    'staff'
                )
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            )
        );
    }

    public function actionRenderpdf($report_name = '', $report_tpl = 'basic')
    {
        if ($report_name == '') {
            die('Invalid access');
        }
        
        // Set maximum execution time and memory usage
        ini_set('memory_limit', '512M');
        set_time_limit(0);
        
        $report_filename = DOC_ROOT . '/template_reports/' . $report_tpl . '.html';
        if (! @file_exists($report_filename)) {
            echo 'Report template not found';
            die();
        }
        $html = file_get_contents($report_filename, FILE_USE_INCLUDE_PATH);
        
        // composed data - Check the get_data() function
        $data = self::get_data($report_name);
        if ($data == null) {
            die('Report does not exists');
        }
        
        // swap value from templates
        $html = str_replace('%head%', $data['head'], $html);
        $html = str_replace('%body%', $data['body'], $html);
        $html = str_replace('%foot%', $data['foot'], $html);
        // echo $html; exit;
        
        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set application logo
        $pdf->logo_pos = $data['logo_pos'];
        $pdf->logo = $this->applicationLogo(EnumLogo::CLIENT);
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Engagex');
        $pdf->SetTitle('Engagex');
        $pdf->SetSubject('Engagex');
        $pdf->SetKeywords('report');
        
        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(
            PDF_FONT_NAME_MAIN,
            '',
            PDF_FONT_SIZE_MAIN
        ));
        $pdf->setFooterFont(Array(
            PDF_FONT_NAME_DATA,
            '',
            PDF_FONT_SIZE_DATA
        ));
        
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter(false);
        
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        
        // ---------------------------------------------------------
        
        // set default font
        // $pdf->SetFont('dejavusans', '', 9);
        
        // // generate font
        // $fontname = TCPDF_FONTS::addTTFfont('C:\xampp\htdocs\tools.agencythriveprogram.com\protected\extensions\tcpdf\fonts\Merriweather-Italic.ttf', 'TrueTypeUnicode', '', 32);
        // // use the font
        // $pdf->SetFont($fontname, '', 14, '', false);
        //
        // set default font
        $pdf->AddFont('merriweather', '', 'merriweather.php');
        $pdf->SetFont('merriweather', '', 10, false);
        
        // add a page
        $pdf->AddPage();
        
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // reset pointer to the last page
        $pdf->lastPage();
        
        // Close and output PDF document
        $pdf_location = $this->normalize_path($_SERVER['DOCUMENT_ROOT'] . '/pdf/');
        $pdf_output = $report_name . '.pdf';
        if (isset($_GET['customer_id'])) {
            $pdf_output = $report_name . '_' . $_GET['customer_id'] . '.pdf';
        }
        // File Output
        $pdf->Output($pdf_location . $pdf_output, 'F');
        // Browser Output
        $pdf->Output($pdf_output, 'I');
        
        // ============================================================+
        // END OF FILE
        // ============================================================+
        
        Yii::app()->end();
    }

    public function get_data($report_name)
    {
        // Action Item
        switch ($report_name) {
            case 'action_item':
                require_once (DOC_ROOT . '/protected/reports/RptActionItem.php');
                return RptActionItem::Content();
                break; // END: Action Item
            case 'cir':
                require_once (DOC_ROOT . '/protected/reports/RptCIR.php');
                return RptCIR::Content($_GET);
                break;
            case 'billing':
                require_once (DOC_ROOT . '/protected/reports/RptSOA.php');
                return RptSOA::Content($_GET);
                break;
        } // END: switch
          
        // empty result
        return null;
    }
}