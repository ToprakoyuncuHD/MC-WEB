<?php

namespace OpenMCWeb;

class Helpers
{
    public static function curPageURL()
    {
        $pageURL = 'http';

        if (isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on") {
            $pageURL .= "s";
        }

        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }

    public static function removeUnneccesaryURLParts($string)
    {
        if (strpos($string, "#")) {
            $string1 = substr($string, 0, strpos($string, "#"));
            return substr($string1, 0, strpos($string1, "?"));
        } else {
            if (strpos($string, "?")) {
                return substr($string, 0, strpos($string, "?"));
            } else {
                return $string;
            }
        }
    }

    public static function curURLDir()
    {
        $pageURL = self::curPageURL();

        if (self::endsWith(self::removeUnneccesaryURLParts($pageURL), ".php")) {
            return dirname($pageURL);
        }

        return $pageURL;
    }

    public static function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    public static function endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === "" ||
            (($temp = strlen($haystack) - strlen($needle)) >= 0 &&
            strpos($haystack, $needle, $temp) !== false);
    }
}
