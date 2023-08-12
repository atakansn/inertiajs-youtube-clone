
# InertiaJS Youtube Klon

Bu proje, Laravel, Tailwind CSS, Vue 3 ve Inertia.js teknolojilerini kullanarak, YouTube'a benzer bir video paylaşım platformu oluşturmayı amaçlamaktadır. Modern web geliştirme araçlarıyla güçlendirilmiş bu proje, kullanıcılara dinamik içerik oluşturma ve paylaşma imkanı sunmaktadır. Laravel'in esnek arka plan yeteneklerini kullanarak, Tailwind CSS ile etkileyici bir tasarım oluşturarak, Vue 3 ile zengin kullanıcı arayüzleri tasarlayarak ve Inertia.js ile hızlı ve akıcı sayfa geçişleri ile, özgün bir video paylaşım deneyimi sunmayı amaçlar.


## Kullanılan Teknolojiler

**İstemci:** Vue3(Composition API), InertiaJS, TailwindCSS

**Sunucu:** Laravel 10.x, MySQL 8.x, PHP 8.2, Laravel Scout, FFMPEG

## FFMPEG
Video yükleme ve işleme için sunucuzda veya yerel geliştirme ortamınızda FFMPEG yüklü olması gerekir.

- https://www.ffmpeg.org/
## Özellikler

- Laravel 10.x ile güçlü arka uç işlevselliği
- Tailwind CSS ile hızlı ve özelleştirilebilir tasarım
- Vue 3 ile etkileyici kullanıcı arayüzleri
- Inertia.js ile hızlı ve akıcı SPA deneyimi
- Yorum ve beğenme sistemi
- Abonelik sistemi
- Kanal kontrol paneli
- Abonelikleri yönetme
- Kanala ait videoları datatable biçiminde yönetme ve düzenleme
- Sade video yükleme ekranı
- Skeleton yükleme tasarımı
- Ctrl + k ile arama kutusunu aktif etme
- Giriş yapılmadığı takdirde otomatik aktif olan modal
- Üye olunduğu zaman otomatik olarak kanal oluşturma
- Varsayılan olarak gelen kanal avatar ve arka plan

## Ortam Değişkenleri Docker Olmadan

Bu projeyi çalıştırmak için aşağıdaki ortam değişkenlerini .env dosyanıza eklemeniz gerekecek

`DB_CONNECTION=mysql`

`DB_HOST=localhost`

`DB_PORT=3306`

`DB_DATABASE=your_database_name`

`DB_USERNAME=your_username`

`DB_PASSWORD=your_password`


## Docker İle
Docker varsa DB_HOST DB_CONNECTION ile aynı olmalı

`DB_CONNECTION=mysql`

`DB_HOST=mysql`

`DB_PORT=3306`

`DB_DATABASE=your_database_name`

`DB_USERNAME=sail`

`DB_PASSWORD=password`

## Kullanım/Örnekler

Video işleme yaparken aşağıdaki laravel kuyruk komutu çalıştırılması gerekiyor.

```php
php artisan queue:work
//veya
php artisan queue:listen
```


## Yükleme Docker Olmadan

```bash 
  git clone https://github.com/atakansn/inertiajs-youtube-clone.git
  cd inertiajs-youtube-clone
  composer install
  npm install
  php artisan optimize:clear
  php artisan serve
  npm run dev
```


## Docker İle Yükleme

```bash 
  git clone https://github.com/atakansn/inertiajs-youtube-clone.git
  cd inertiajs-youtube-clone
  docker-compose up --build
  ./vendor/bin/sail artisan optimize:clear
```



## Ekran Görüntüleri

![Uygulama Ekran Görüntüsü 1](https://i.hizliresim.com/bn12ctf.png)
![Uygulama Ekran Görüntüsü 2](https://i.hizliresim.com/n6bqkpe.png)
![Uygulama Ekran Görüntüsü 3](https://i.hizliresim.com/bn12ctf.png)
![Uygulama Ekran Görüntüsü 4](https://i.hizliresim.com/6prgms3.png)
![Uygulama Ekran Görüntüsü 5](https://i.hizliresim.com/s9ynyo1.png)
![Uygulama Ekran Görüntüsü 6](https://i.hizliresim.com/dji493m.png)
![Uygulama Ekran Görüntüsü 7](https://i.hizliresim.com/qzs0h3v.png)
![Uygulama Ekran Görüntüsü 8](https://i.hizliresim.com/fmzip0t.png)
![Uygulama Ekran Görüntüsü 9](https://i.hizliresim.com/rxspb27.png)
![Uygulama Ekran Görüntüsü 10](https://i.hizliresim.com/pwkko81.png)
![Uygulama Ekran Görüntüsü 11](https://i.hizliresim.com/sslvm1e.png)

  