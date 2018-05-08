<?php
/**
 * Created by PhpStorm.
 * User: 555
 * Date: 29.04.2018
 * Time: 18:01
 */

namespace app\controllers;


use yii\web\Controller;

class ShopController extends Controller
{

    public $layout = 'main-magazin';

    public function actionIndex()
    {
        return $this->render('index');
    }
}