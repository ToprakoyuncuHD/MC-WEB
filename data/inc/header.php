<?php
require_once(__DIR__ . "/../main.php");

//"header.twig" şablonunu gösteriyoruz.
echo $twig->render('header.twig', array(
    'current_url' => CURRENT_URL,
    'bg_resim' => $bg_resim,
    'serv_ad' => $serv_ad,

    //Admin girişi yapılmışsa admin bilgilerini alıyoruz, yapılmamışsa boş bir array gönderyoruz
    'hesap' => (isset($_SESSION["giris"])) ?
        $_SESSION["giris"] :
        array(),

    //Sunucu online ise MOTD'yi alıyoruz, açık değilse sunucunun açık olmadığını belirtiyoruz
    'serv_motd' => (SERVER_ONLINE) ?
        \OpenMCWeb\WebHelp::getMcwscApiFunction($serv_ip, $serv_port, "motd") :
        "Sunucu Kapalıdır.",
));
