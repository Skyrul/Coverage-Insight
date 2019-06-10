<?php
class EmailpreviewController extends BaseController 
{
    /**
     * Preview
     */
    public function actionPreview($id=0,$secret='')
    {
        if ($secret == 'engagex') {
            $model = EmailTemplate::model()->find('id=:id', array(
                ':id'=>$id,
            ));
            if ($model != null) {
                $this->renderPartial('/emailtemplate/preview', array('model'=>$model));
            }
        }
    }

}
