<?php
require_once(__DIR__ . "/../main.php");

$hataKodu = 0;

//Kullanıcı adı ve şifrenin boş olup olmadığına bakıyoruz
if ((isset($_POST["username"]) && $_POST["username"] != "") &&
    (isset($_POST["password"]) && $_POST["password"] != "")) {
    //SQL veritabanından kullanıcı bilgilerini alıyoruz
    $db->makeQuery("SELECT * FROM hesaplar WHERE isim = ?");
    $db->bind(1, strtolower($_POST["username"]));
    $db->executeHandle();
    $admin = $db->returnResult();

    //Eğer böyle bir kullanıcı varsa ve şifre doğruysa...
    if (isset($admin[0]) && password_verify($_POST["password"], $admin[0]["sifre"])) {
        //Session'da ki admin değişkenini admin'e atıyoruz.
        $_SESSION["giris"] = $admin[0];
        $_SESSION["giris"]["sifre"] = "Ne Bekliyodun güzel kardeşim?";
        $_SESSION["giris"]["csrf_token"] = md5(uniqid(rand(0, PHP_INT_MAX), true));

        //Admin Paneline gönderiyoruz
        header("Location: ../../panel.php");
    } else {
        $hataKodu = 2;
    }
} else {
    $hataKodu = 1;
}

header("Location: ../../panel.php?hata=" . $hataKodu);
