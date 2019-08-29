<?php
class Example
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getResult()
    {
        $arrAlg = include_once ROOT . '/config/algorithm.php';

        if (count($this->data) > 1 && $class = $arrAlg[$this->data['algorithm']]) {
            $calc = new $class();
            $calc->setData($this->data);
            $result = [
                'error' => false,
                'data' => $calc->getResult(),
            ];
        } else {
            $result = [
                'error' => true,
            ];
        }

        return $result;
    }
}