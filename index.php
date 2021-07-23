<?php
require_once(__DIR__ . "/data/inc/header.php"); //Header'ı alıyoruz

//"index.twig" şablonunu gösteriyoruz.
echo $twig->render('index.twig', array(
    'yazi_onizleme_limit' => 440,
    'serv_ip' => $serv_ip,
    'serv_oyuncular' => (SERVER_ONLINE) ?
        //Sunucu online ise oyuncuları alıyoruz, açık değilse boş bir array gönderiyoruz
        \OpenMCWeb\WebHelp::getMcwscApiFunction($serv_ip, $serv_port, "players") :
        array(),
    'son_blog' => \OpenMCWeb\BlogPosts::getRecentTwo($db),
));

require_once(__DIR__ . "/data/inc/footer.php"); //Footer'ı alıyoruz
