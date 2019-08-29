<?php

include_once ROOT . '/models/Test.php';

class IndexController
{

	public function actionIndex()
	{
        $testList = [];
        $testList = Test::getTestList();

		require_once(ROOT.'/views/index.php');
		return true;
	}

}