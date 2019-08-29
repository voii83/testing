<?php

class Debug
{
    public static function dd($value)
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }

    public static function ddf($value, $filename)
    {
        $path = ROOT . '/debug/' . $filename;
        ob_start();
        var_dump($value);
        $str_value = ob_get_clean();
        $f = fopen($path, 'a');
        fwrite($f, $str_value);
        fclose($f);
    }
}