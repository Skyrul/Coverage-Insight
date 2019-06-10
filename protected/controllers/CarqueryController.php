<?php

class CarqueryController extends Controller
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
                    'getyears',
                    'getmakes',
                    'getmodels'
                ),
                'users' => array('*')
            ),
        );
    }

    /* Actions */
    public function actionGetyears()
    {
        $records = null;
        $records[] = array(
            'id' => '0',
            'text' => '-- Select Year --'
        );
        for ($i = date('Y'); $i >= 1960; $i--) {
            $records[] = array(
                'id' => $i,
                'text' => $i
            );
        }
        $this->dd($records);
    }

    public function actionGetmakes($year = 0)
    {
        $cr = new CDbCriteria();
        $cr->select = "DISTINCT model_make_id, model_make_display";
        $cr->condition = "model_year = :year AND model_sold_in_us = 1";
        $cr->distinct = true;
        $cr->params = array(
            ':year' => $year
        );
        $cr->order = 'model_make_display ASC';
        $model = CarQuery::model()->findAll($cr);
        $records = [];
        if (! empty($model)) {
            array_push($records, array(
                'id' => 'none',
                'text' => '-- Select Make --'
            ));
            foreach ($model as $k => $v) {
                array_push($records, array(
                    'id' => $v->model_make_id,
                    'text' => $v->model_make_display
                ));
            }
            $this->dd($records);
        }
    }

    public function actionGetmodels($make = '')
    {
        $cr = new CDbCriteria();
        $cr->select = "DISTINCT model_name";
        $cr->distinct = true;
        $cr->condition = "model_make_id = :mk AND model_sold_in_us = 1";
        $cr->params = array(
            ':mk' => $make
        );
        $cr->order = "model_name ASC";
        $model = CarQuery::model()->findAll($cr);
        $records = [];
        if (! empty($model)) {
            array_push($records, array(
                'id' => 'none',
                'text' => '-- Select Model --'
            ));
            foreach ($model as $k => $v) {
                array_push($records, array(
                    'id' => $v->model_name,
                    'text' => $v->model_name
                ));
            }
            $this->dd($records);
        }
    }
}