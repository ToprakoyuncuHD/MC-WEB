<?php
require_once(__DIR__ . "/../main.php");

$hataKodu = -1;

//Kullanıcı adı ve şifrenin boş olup olmadığına bakıyoruz
if ((isset($_POST["username"]) && $_POST["username"] != "") &&
    (isset($_POST["password"]) && $_POST["password"] != "") &&
    (isset($_POST["password2"]) && $_POST["password2"] != "")) {
    if ($_POST["password2"] === $_POST["password"]) {
        //SQL veritabanından kullanıcı bilgilerini alıyoruz
        $db->makeQuery("SELECT * FROM hesaplar WHERE isim = ?");
        $db->bind(1, strtolower($_POST["username"]));
        $db->executeHandle();
        $admin = $db->returnResult();

        //Eğer böyle bir kullanıcı yoksa yeni hesap açalım.
        if (!isset($admin[0])) {
            $db->makeQuery("INSERT INTO hesaplar(isim, sifre) VALUES (?, ?)");
            $db->bind(1, strtolower($_POST["username"]));
            $db->bind(2, password_hash($_POST["password"], PASSWORD_BCRYPT));
            $db->executeHandle();

            header("Location: ../../panel.php?sayfa=giris&hata=" . $hataKodu);
        } else {
            $hataKodu = 4;
        }
    } else {
        $hataKodu = 5;
    }
} else {
    $hataKodu = 1;
}

header("Location: ../../panel.php?sayfa=kayit&hata=" . $hataKodu);
