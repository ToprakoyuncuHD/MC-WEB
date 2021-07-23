<?php
// Yüklenmiş mi ona bakıyoruz.
if (file_exists(__DIR__ . "/config.php")) {
    require_once(__DIR__ . "/config.php");
} else {
    header("Location: kur.php");
    return;
}

define("OMCW_SURUM", "1.0.0-beta");

// Composer Autoloader Var mı diye bakıyoruz, varsa kullanıyoruz, yoksa kullanıcıdan composer'ı çalıştırmalarını
// istiyoruz.
if (file_exists(__DIR__ . "/../vendor/autoload.php")) {
    require_once(__DIR__ . "/../vendor/autoload.php");
} else {
    die(<<<HTML
<b style="color: red;">Hata:</b> <span>Lütfen <a href="https://getcomposer.org">Composer</a> indirip sitenin klasöründe
 <code>composer install</code> komudunu çalıştırın.
</span>
HTML
    );
}

//Twig'i ayarlıyoruz.
$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates'); //Şablonlar "data/templates" ta bulunacaktır.
$twig = new Twig_Environment($loader, array(
    'debug' => true
));
$twig->addExtension(new Twig_Extension_Debug());

//PDO Kullanarak MySQL bağlantımızı kuruyoruz.
$db = new \OpenMCWeb\DBConnections(new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass));

//Session'ı başlatıyoruz ki girişler vs. sayfalar arasında paylaşılabilsin
session_start();

//Sunucunun açık olup olmadığına bakyoruz.
define("SERVER_ONLINE", \OpenMCWeb\WebHelp::isUp($serv_ip, $serv_port));

//Bir kullanıcı girişi var mı bakıyoruz.
define("KULLANICI_GIRISI", isset($_SESSION["giris"]));

//Giriş bir admin girişi mi ona bakıyoruz
define("ADMIN_GIRISI", KULLANICI_GIRISI &&
                       (strpos($_SESSION["giris"]["degiskenler"], 'admin') !== false));
                        //$_SESSION["giris"]["degiskenler"] değişkeninin içinde "admin" geçiyor mu ona bakıyoruz.

//Şu anki URL'nin klasörünü ayarlıyoruz
define("CURRENT_URL", \OpenMCWeb\Helpers::curURLDir());
