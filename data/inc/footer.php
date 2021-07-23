<?php

//"footer.twig" şablonunu gösteriyoruz.
echo $twig->render('footer.twig', array(
    'current_url' => dirname(\OpenMCWeb\Helpers::curPageURL())
));

//MySQL Veritabanı bağlantısını kapatıyoruz.
$db->close();
