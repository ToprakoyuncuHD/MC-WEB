<?php

namespace OpenMCWeb;

use PDO;

class BlogPosts
{
    /**
     * @param $db DBConnections Veritabanı bağlantısı
     * @param $limit int Bir sayfaya yazı limiti
     * @return int Kaç sayfa var
     */
    public static function blogPageCount($db, $limit)
    {
        $db->makeQuery("SELECT COUNT(1) FROM blogyazisi");
        $db->executeHandle();

        $kacYaziVar = $db->returnResult()[0]["COUNT(1)"];

        return (int) ceil($kacYaziVar / $limit);
    }

    /**
     * @param $sayfa int Yazıların olduğu sayfa
     * @param $db DBConnections Veritabanı bağlantısı
     * @param $limit int Bir sayfaya yazı limiti
     * @return array Sayfadaki blog yazıları
     */
    public static function getBlogPosts($sayfa, $db, $limit)
    {
        //Eklenme zamanları azalan (En yeniden en eskiye) ve bu sayfada olan $blog_limit yazıyı seçiyoruz.
        $db->makeQuery("SELECT * FROM blogyazisi ORDER BY eklenme_zamani DESC LIMIT ? OFFSET ?");
        $db->bind(1, $limit, PDO::PARAM_INT);
        $db->bind(2, $limit * ($sayfa - 1), PDO::PARAM_INT);
        $db->executeHandle();

        $yazilar = $db->returnResult();

        //Yazılara gerekli bilgileri ekleyiyoruz
        foreach ($yazilar as &$yazi) {
            $db->makeQuery("SELECT isim FROM hesaplar WHERE id = ?");
            $db->bind(1, $yazi["yazar_id"]);
            $db->executeHandle();
            $yazar = $db->returnResult()[0]["isim"];
            
            $yazi["yazar_ad"] = $yazar;
        }

        return $yazilar;
    }

    /**
     * @param $db DBConnections Veritabanı bağlantısı
     * @return array En sonki 2 blog yazısı
     */
    public static function getRecentTwo($db)
    {
        //Eklenme zamanları azalan (En yeniden en eskiye) 2 yazıyı seçiyoruz.
        $db->makeQuery("SELECT * FROM blogyazisi ORDER BY eklenme_zamani DESC LIMIT 2");
        $db->executeHandle();
        $yazi = $db->returnResult();

        //İki yazıya da gerekli bilgileri ekleyiyoruz
        foreach ($yazi as &$tekYazi) {
            $db->makeQuery("SELECT isim FROM hesaplar WHERE id = ?");
            $db->bind(1, $tekYazi["yazar_id"]);
            $db->executeHandle();
            $yazar = $db->returnResult()[0]["isim"];

            $tekYazi["yazar_ad"] = $yazar;
        }

        return $yazi;
    }
}