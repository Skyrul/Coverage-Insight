<?php
class AccountItemController extends Controller 
{
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array(
                    'export_action_item',
                ),
                'roles' => array(EnumRoles::ADMINISTRATOR, EnumRoles::STAFF),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Actions 
     */
    public function actionExport_action_item()
    {
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
            
            $objPHPExcel = new PHPExcel();
            
            // Add some data
            $account_item = ActionItem::model()->findAll('account_id = :account_id', array(':account_id'=> Yii::app()->session['account_id']));
            if (!empty($account_item)) {
                // Header
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Completed')
                ->setCellValue('B1', 'Name')
                ->setCellValue('C1', 'Secondary Name')
                ->setCellValue('D1', 'Owner')
                ->setCellValue('E1', 'Opportunity')
                ->setCellValue('F1', 'Description')
                ->setCellValue('G1', 'Created Date')
                ->setCellValue('H1', 'Due Date');
                
                // Body
                $ctr = 2;
                foreach($account_item as $k=>$v) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$ctr, (($v->is_completed == 1) ? 'Yes':'No') );
                    
                    $customer = Customer::model()->find('id = :id', array(':id'=>$v->customer_id));
                    if ($customer != null) {
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B'.$ctr, $customer->primary_firstname . ' ' . $customer->primary_lastname)
                            ->setCellValue('C'.$ctr, $customer->secondary_firstname . ' ' . $customer->secondary_lastname);
                    }
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('D'.$ctr, $v->owner)
                        ->setCellValue('E'.$ctr, (($v->is_opportunity == 1) ? 'Yes':'No') )
                        ->setCellValue('F'.$ctr, $v->description )
                        ->setCellValue('G'.$ctr, date('m/d/Y', strtotime($v->created_date)))
                        ->setCellValue('H'.$ctr, date('m/d/Y', strtotime($v->due_date)));
                    
                    $ctr += 1;
                }
            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Action Item');
            
            
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            
            
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="download.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            Yii::app()->end();        
    }

}
