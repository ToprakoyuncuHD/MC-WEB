<?php
require_once(__DIR__ . "/data/inc/header.php"); //Header'ı alıyoruz

//Sayfayı ayarlıyoruz. Sayfa yoksa ilk sayfa oluyor.
$sayfa = (isset($_GET['sayfa']) && $_GET['sayfa'] > 0) ? $_GET['sayfa'] : 1;

//"blog.twig" şablonunu gösteriyoruz.
echo $twig->render('blog.twig', array(
    'yazi_onizleme_limit' => 440,
    'blog_yazilari' => \OpenMCWeb\BlogPosts::getBlogPosts($sayfa, $db, $blog_limit),
    'blog_sayfalari' => \OpenMCWeb\BlogPosts::blogPageCount($db, $blog_limit),
    'suanki_sayfa' => $sayfa
));

require_once(__DIR__ . "/data/inc/footer.php"); //Footer'ı alıyoruz