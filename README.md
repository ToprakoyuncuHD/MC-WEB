OpenMCWeb
----------
Minecraft Sunucunuz için internet sitesi

## Gereksinimler
1. PHP (5.5.0 ve üstü) ve şu modüller aktif bir sunucu:
    - PDO
2. MySQL sunucusu
3. MCWSC plugini ([Buradan](https://github.com/Admicos/MCWSC/releases) indirilebilir)
4. Composer ([Buradan](https://getcomposer.org/download/) indirilebilir) (Eğer composer gerektirmeyen zip'i indirdiyseniz gerekli değildir.)

## Kurulum
1. Klasörü FTP veya başka yöntemler web sunucunuza yükleyin.
2. *(Composer gerektiren zip'i indirdiyseniz)*  Terminale `composer install` yazın.
3. `siteniz.com/kur.php` adresine giderek sunucunuz ile ilgili bilgileri girin.
4. Her şey tamam!
5. [Kurulumdan Sonra yapmak isteyebilecekleriniz](#kurulumdan-sonra-yapmak-isteyebilecekleriniz) kısmına göz atın.

## Özelleştirilebilecek şeyler
- `data/templates` klasöründeki *.twig dosyaları, HTML'e yakın [Twig](http://twig.sensiolabs.org/) ile yaratılmıştır ve kolayca düzenlenebilir.
- `data/css` klasöründeki *.sass dosyaları, CSS'e yakın [Sass](http://sass-lang.com/) ile yaratılmıştır ve kolayca düzenlenebilir. (Bir Sass compiler'a ihtiyacınız olacaktır. Online bir tane [burada](http://www.sassmeister.com/) bulabilirsiniz. Compiler'in verdiği css'i `/data/css/openmcweb.min.css` dosyasına yapıştırın.)
- `ekstra` klasöründeki arkaplan değiştirilebilir.

## Kullanılmış araçlar
- [Sass](http://sass-lang.com)
- [Twig](http://twig.sensiolabs.org/)
- [Composer](https://getcomposer.org)
- [MCWSC](https://github.com/Admicos/MCWSC)
- [CKEditor](http://ckeditor.com/)

## Lisans
OpenMCWeb, MIT Lisansı ile lisanslanmıştır. (https://opensource.org/licenses/MIT veya [LISANS.txt](./LISANS.txt) dosyasında bulabilirsiniz)

Kurulumdan Sonra yapmak isteyebilecekleriniz
--------------------------------------------
### Admin Kullanıcısı Yaratmak
1. PHPMyAdmin veya benzeri bir şey kullanarak `hesaplar` tablosuna girip istediğiniz kullanıcının `degiskenler` sütünuna `admin` yazın.
2. Çıkış yapıp yeniden giriş yapın
3. Admin panelini ve blog yazısı ekleme butonunu görmelisiniz, artık adminsiniz.

### AuthMe-Reloaded Bağlantısını açmak
1. AuthMe-Reloaded configinizi site ile gelen authme_config.yml dosyası ile değiştirin
2. Şu satırları MySQL sunucunuza göre düzenleyin:
    - 10
    - 12
    - 14
    - 16
    - 18
3. Öbür MySQL ayarlarını ellemeyin.
4. Config'e ekstra ayar yapacaksanız yapın
5. Sunucunuzu başlatın!