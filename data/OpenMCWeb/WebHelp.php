<?php

namespace OpenMCWeb;

class WebHelp
{
    public static function isUp($host, $port)
    {
        //Eğer socket hatasız açıldıysa, sunucu açıktır.
        if ($socket = @fsockopen($host, $port, $errno, $errstr, 10)) {
            fclose($socket);
            return true;
        } else {
            return false;
        }
    }

    public static function getMcwscApiFunction($host, $port, $apiFunc)
    {
        //MCWSC bize JSON verdiği için o JSON'u PHPnin anlayabileceği bir hale getiriyoruz.
        return json_decode(file_get_contents("http://" . $host . ":" . $port . "/" . $apiFunc));
    }
}