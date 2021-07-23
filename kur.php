<?php
$head = <<<HTML
<!doctype html>
<html>
<head>
    <title>OpenMCWeb Kur</title>

    <link rel="stylesheet" href="data/css/bootstrap.min.css">
    <link rel="stylesheet" href="data/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" href="data/css/ripples.min.css">

    <style>
    </style>
</head>
<body>
HTML;

$foot = <<<HTML
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script defer src="data/js/material.min.js"></script>
    <script defer src="data/js/ripples.min.js"></script>
    <script defer src="data/js/openmcweb.min.js"></script>
</body>
</html>
HTML;

// Zaten yüklenmiş mi ona bakıyoruz.
if (file_exists(__DIR__ . "/data/config.php")) {
    header("Location: index.php");
    return;
}

// Composer Autoloader Var mı diye bakıyoruz, varsa kullanıyoruz, yoksa kullanıcıdan composer'ı çalıştırmalarını
// istiyoruz.
if (file_exists(__DIR__ . "/vendor/autoload.php")) {
    require_once(__DIR__ . "/vendor/autoload.php");
} else {
    die(<<<HTML
<b style="color: red;">Hata:</b> <span>Lütfen <a href="https://getcomposer.org">Composer</a> indirip sitenin klasöründe
 <code>composer install</code> komudunu çalıştırın.
</span>
HTML
    );
}

// Kurulum başlayınca yapılacaklar
if (isset($_POST["yap"])) {
    //MySQL Bağlantısı açıyoruz.

    try {
        $db = @new PDO(
            "mysql:host=". $_POST["db_host"] .";dbname=". $_POST["db_name"],
            $_POST["db_user"],
            $_POST["db_pass"]
        );
        $db->exec(file_get_contents(__DIR__ . "/openmcweb.sql"));
    } catch (PDOException $e) {
        echo($head);
        echo(<<<"HTML"
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-inverse">
            <div class="panel-heading">
                <h2 class="panel-title">Kur</h2>
            </div>
            <div class="panel-body">
                <h1 style="text-align: center;">HATA!</h1>
                <p>OpenMCWeb kurulurken bir MySQL hatası ile karşılaştı.</p>
                <pre>{$e->getMessage()}</pre>
            </div>
        </div>
    </div>
</div>
HTML
        );
        echo($foot);
        die();
    }

    $config = fopen(__DIR__ . "/data/config.php", "w"); // /data/config.php dosyasını açıyoruz

    //POST array'ini BasicTemplate kullanarak config dosyasını oluşturup yukarıda açtığımız dosyaya yazıyoruz.
    fwrite($config, \OpenMCWeb\BasicTemplate::arrayReplace(__DIR__ . "/data/config.template", $_POST));

    fclose($config); // Config dosyasını yazıp kapatıyoruz.

    //Kurulumun bittiğini belirten HTML'yi gösteriyoruz.
    echo($head);
    echo(<<<HTML
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-inverse">
            <div class="panel-heading">
                <h2 class="panel-title">Kur</h2>
            </div>
            <div class="panel-body">
                <h1 style="text-align: center;">KURULDU!</h1>
                <p>OpenMCWeb başarıyla kuruldu. Hatalar çıkarsa <code>/data/config.php</code> 
                dosyasından bilgileri düzenleyebilirsiniz. <br><br>
                Bu kur.php dosyasını hemen silmeniz önerilmektedir.</p>
                <a href="index.php" class="btn btn-success btn-raised btn-block center-block">Sitene Git!</a>
            </div>
        </div>
    </div>
</div>
HTML
    );
    echo($foot);
} else {
    //Kurulum formunu gösteriyoruz
    echo($head);
    echo(<<<HTML
<div class="col-md-8 col-md-offset-2">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h2 class="panel-title">Kur</h2>
            </div>
            <div class="panel-body">
                <form action="kur.php" method="post">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" required
                                   class="form-control"
                                   placeholder="MySQL Veritabanı Sunucusu"
                                   name="db_host">
                        </div>
                        <div class="form-group">
                            <input type="text" required
                                   class="form-control"
                                   placeholder="MySQL Veritabanı Kullanıcı Adı"
                                   name="db_user">
                        </div>
                        <div class="form-group">
                            <input type="password"
                                   class="form-control"
                                   placeholder="MySQL Veritabanı Kullanıcı Şifresi"
                                   name="db_pass">
                        </div>
                        <div class="form-group">
                            <input type="text" required
                                   class="form-control"
                                   placeholder="MySQL Veritabanı Adı"
                                   name="db_name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" required
                                   class="form-control"
                                   placeholder="Minecraft Sunucu Adı"
                                   name="serv_ad">
                        </div>
                        <div class="form-group">
                            <input type="text" required
                                   class="form-control"
                                   placeholder="Minecraft Sunucu IPsi"
                                   name="serv_ip">
                        </div>
                        <div class="form-group">
                            <input type="number" required
                                   class="form-control"
                                   placeholder="MCWSC Portu"
                                   name="serv_port"
                                   value="1337">
                            <span class="help-block">
                                OpenMCWeb'in Minecraft sunucunuz ile iletişime geçebilmesi için
                                <a href="https://github.com/Admicos/MCWSC/releases">MCWSC</a>
                                gerekmektedir. (Port normal bir kurulumda <code>1337</code> dir.)
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="number" required
                                   class="form-control"
                                   placeholder="Bir blog sayfasındaki yazı limiti"
                                   name="blog_limit"
                                   value="10">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" name="yap" value="ok">
                            <input type="submit"
                                   class="btn btn-success btn-raised btn-block center-block"
                                   value="OpenMCWeb'i Kur">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
HTML
    );
    echo($foot);
}
