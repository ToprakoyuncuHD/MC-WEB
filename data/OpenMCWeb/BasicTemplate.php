<?php
namespace OpenMCWeb;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class BasicTemplate
{
    /**
     * @param $ite RecursiveIteratorIterator JSON RecursiveArrayIterator
     * @param $sayfa string HTML String
     * @return string Replaced HTML String
     */
    private static function doReplace($ite, $sayfa)
    {
        foreach ($ite as $key => $val) { //JSONdaki bütün değişkenler ve değerlerini $ite ile iterate ediyoruz.
            if (is_array($val)) { //Eğer bir array'imiz varsa...
                $val_a = $val;
                $val = "";
                for ($i = 0; $i < sizeof($val_a); $i++) { //İçindekilerilerden geçiyoruz...
                    $val .= $val_a[$i] . ", "; //İçeridekileri virgüllerle ayrılmış bir stringe alıyoruz.
                }
                $val = substr($val, 0, -2); //Sondaki gereksiz virgülü siliyoruz.
            }

            //Ve sayfada {{ }} içindeki değişken adını değişkenin değeri ile değiştiriyoruz.
            $sayfa = str_replace("{{ $key }}", $val, $sayfa);
            $sayfa = str_replace("{{" . $key . "}}", $val, $sayfa);
        }

        return $sayfa;
    }

    public static function arrayReplace($html, $array)
    {
        //Gerekli dosyaları okuyoruz.
        $sayfa = file_get_contents($html); //Gönderilecek sayfayı alıyoruz.

        $ite = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($array),
            RecursiveIteratorIterator::SELF_FIRST
        ); //Array iterate edecek bir iterator hazırlıyoruz.

        return self::doReplace($ite, $sayfa); //Ve sayfayı gönderiyoruz.
    }

    public static function jsonReplace($html, $json)
    {
        //Gerekli dosyaları okuyoruz.
        $sayfa = file_get_contents($html); //Gönderilecek sayfayı alıyoruz.
        $ayar  = json_decode(file_get_contents($json), true); //JSON dosyasını alıyoruz.

        if ($ayar == null) {
            echo("JSON ERROR: <br>");

            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    echo ' - No errors. Probably empty';
                    break;
                case JSON_ERROR_DEPTH:
                    echo ' - Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    echo ' - Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    echo ' - Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    echo ' - Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    echo ' - Unknown error';
                    break;
            }

            die();
        }

        $ite = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($ayar),
            RecursiveIteratorIterator::SELF_FIRST
        ); //JSON iterate edecek bir iterator hazırlıyoruz.

        return self::doReplace($ite, $sayfa); //Ve sayfayı gönderiyoruz.
    }
}
