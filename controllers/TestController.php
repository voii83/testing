<?php

include_once ROOT . '/models/Test.php';


class TestController
{
    public function actionView($id) {
        $test = [];
        $test = Test::getTest($id);

        require_once(ROOT.'/views/test/view.php');
        return true;
    }

    public function actionResult()
    {
        $data = $_POST;
        $calc = new Example($data);
        $result = $calc->getResult();

        require_once(ROOT.'/views/test/result.php');
        return true;
    }
}