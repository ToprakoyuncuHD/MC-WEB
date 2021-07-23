<?php
require_once(__DIR__ . "/data/inc/header.php"); //Header'ı alıyoruz

$kullanicilaraAcikSayfalar = array(
    "degistirsifre",
    "silhesap"
);

//Sayfayı, sayfa ayarlanmamışsa veya admin girişi yapılmamışsa admin girişine ayarla

if (isset($_GET["sayfa"]) && $_GET["sayfa"] == "kayit") {
    $sayfa = "kayit";
} else {
    $sayfa = "giris";
}

if (ADMIN_GIRISI) {
    if (isset($_GET["sayfa"])) {
        $sayfa = $_GET['sayfa'];
    } else {
        $sayfa = "anamenu";
    }
} elseif (KULLANICI_GIRISI) {
    if (isset($_GET["sayfa"]) && in_array($_GET["sayfa"], $kullanicilaraAcikSayfalar)) {
        $sayfa = $_GET["sayfa"];
    } else {
        $sayfa = "anamenu";
    }
}

//Olaylarda bir hata olduysa onu ayarla
$hata = (isset($_GET['hata'])) ? $_GET['hata'] : 0;

//Hata varsa kodunu alıp hatayı anlaşılabilecek bir şekilde gösteriyoruz
switch ($hata) {
    case -1:
        echo (<<<HTML
<div class="alert alert-success">Başarıyla kayıt oldunuz.<br>
Bu kullanıcı adı ve şifre ile Oyun içinden sunucumuza giriş yapabilirsiniz.</div>
HTML
        );
        break;

    case 1:
        echo (<<<HTML
<div class="alert alert-danger">Kullanıcı adı veya şifre boş.</div>
HTML
        );
        break;
    case 2:
        echo (<<<HTML
<div class="alert alert-danger">Kullanıcı adı veya şifre yanlış.</div>
HTML
        );
        break;
    case 3:
        echo (<<<HTML
<div class="alert alert-danger">Başlık veya içerik boş.</div>
HTML
        );
        break;
    case 4:
        echo (<<<HTML
<div class="alert alert-danger">Böyle bir kullanıcı zaten var. <br>
Eğer oyun içinden kayıt olduysanız aynı kullanıcı adı ve şifre ile giriş yapabilirsiniz.</div>
HTML
        );
        break;
    case 5:
        echo (<<<HTML
<div class="alert alert-danger">Şifre tekrarı eşleşmiyor</div>
HTML
        );
        break;
    default:
        break;
}

//Hangi template'i gösterceğimize bakıyoruz
if ($sayfa == "giris") {
    echo $twig->render('panel/giris.twig');
} elseif ($sayfa == "kayit") {
    echo $twig->render('panel/kayit.twig');
} else {
    if (file_exists("data/templates/panel/incl/" . $sayfa . ".twig")) {
        echo $twig->render('panel/anamenu.twig', array(
            "hesap" => $_SESSION["giris"],
            "incl" => $sayfa
        ));
    } else {
        echo $twig->render('404.twig', array());
    }
}


require_once(__DIR__ . "/data/inc/footer.php"); //Footer'ı alıyoruz
