<?php

class Cook extends ResultTest
{
    protected $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    protected function calc()
    {
        return $this->data;
    }

    public function getResult()
    {
        return $this->calc();
    }
}