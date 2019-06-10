<?php

class MYPDF extends TCPDF 
{
    public $logo = '';
    public $logo_pos = 'R';

    //Page header
    public function Header() {
         if (count($this->pages) === 1) {
            // Logo
            //$image_file = '/images/agencythrive.png';
            $image_file = ($this->logo != null) ? $this->logo : '/images/company.png';

            // Get image size
            $imageinfo = getimagesize($image_file);
          
            $ix=$imageinfo[0];
            $iy=$imageinfo[1];
            if ($ix >= 400 && $ix <= 448) {
                $ix = 60;
            } else {
                $ix = 30;
            }

            $this->Image($image_file, 8, 8, $ix, '', 'PNG', '', 'T', false, 300, $this->logo_pos, false, false, 0, false, false, false);
            // Set font
            $this->SetFont('merriweather', 'R', 10);

            // Title
            //$this->Cell(0, 0, 'Joven', 0, false, 'R', 0, '', 0, false, 'M', 'B');
         }
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
//        $this->SetFont('helvetica', 'I', 8);
        $this->SetFont('merriweather', 'I', 8);
        
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $foot_text1 = 'Date: ' . date("m/d/Y h:i A");
        $foot_text2 = 'Page '. $this->getAliasNumPage().' of '.$this->getAliasNbPages();
        $this->Cell(0, 10, $foot_text1, 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(10, 10, $foot_text2, 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
 
    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }
 
    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
