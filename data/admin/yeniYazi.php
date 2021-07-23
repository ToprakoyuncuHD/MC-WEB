<?php

require_once(__DIR__ . "/../main.php");

$hataKodu = 0;

//Admin girişi yapılıp yapılmadığına bakıyoruz
if (!ADMIN_GIRISI) {
    header("Location: ../../panel.php");
}

//CSRF tokeninin doğru olup olmadığına bakıyoruz
if (isset($_POST["csrf_token"]) && !($_POST["csrf_token"] == $_SESSION["giris"]["csrf_token"])) {
    header("Location: ../../panel.php?sayfa=yeniyazi");
}

//Yazı başlığının ve içeriğinin boş olup olmadığına bakıyoruz
if ((isset($_POST["baslik"]) && $_POST["baslik"] != "") &&
    (isset($_POST["icerik"]) && $_POST["icerik"] != "")) {
    //SQL veritabanına bilgilerini aktarıyoruz
    $db->makeQuery("INSERT INTO blogyazisi(yazar_id, baslik, icerik, eklenme_zamani) VALUES (?, ?, ?, NOW())");
    $db->bind(1, $_SESSION["giris"]["id"]);
    $db->bind(2, $_POST["baslik"]);
    $db->bind(3, $_POST["icerik"]);
    $db->executeHandle();

    $_SESSION["giris"]["csrf_token"] = md5(uniqid(rand(0, PHP_INT_MAX), true));
    header("Location: ../../index.php");
} else {
    $hataKodu = 3;
}

header("Location: ../../panel.php?sayfa=yeniyazi&hata=" . $hataKodu);
