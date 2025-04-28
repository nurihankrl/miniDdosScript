# PHP ile Mini DDoS Koruma ve IP Yönetim Projesi

Basit bir Ddos koruma sistemi içerir. Proje'de PHP kullanılarak geliştirilmiştir ve bir admin paneli aracılığıyla IP adreslerini yönetme imkanı sunar.

## Özellikler

- **DDoS Koruma**: Belirli bir zaman aralığında çok fazla istek gönderen IP adreslerini otomatik olarak engeller.
- **IP Bloklama**: Admin paneli üzerinden manuel olarak IP adreslerini engelleme ve engeli kaldırma.
- **CSV İndirme**: Bloklanan IP adreslerini CSV formatında indirme.
- **Admin Paneli**: Şifre korumalı bir admin paneli ile IP yönetimi.
- **Dinamik Blok Süresi**: IP adresleri belirli bir süre boyunca engellenir ve süre dolduğunda otomatik olarak kaldırılır.

## Kurulum

1. **XAMPP Kurulumu**: Projeyi çalıştırmak için XAMPP veya benzeri bir PHP sunucusu kurulu olmalıdır.
2. **Proje Dosyalarını Kopyalayın**: Tüm dosyaları `htdocs` dizinine kopyalayın.
3. **Veri Dosyaları**: `logs` klasörünün yazılabilir olduğundan emin olun. Bu klasör, IP loglarını ve bloklanan IP adreslerini saklar.
4. **Admin Şifresi**: `admin_login.php` dosyasındaki `$admin_password` değişkenini kendi şifrenizle değiştirin.

## Kullanım

### DDoS Koruma
- `index.php` dosyası, DDoS koruma mekanizmasını içerir. Çok fazla istek gönderen IP adresleri otomatik olarak engellenir.

### Admin Paneli
- `admin_login.php` üzerinden admin paneline giriş yapabilirsiniz.
- Admin panelinde:
  - Bloklanan IP adreslerini görüntüleyebilir.
  - IP adreslerini manuel olarak engelleyebilir veya engeli kaldırabilirsiniz.
  - Bloklanan IP adreslerini CSV formatında indirebilirsiniz.

### Test
- `test.php` dosyası, DDoS koruma sistemini test etmek için kullanılabilir. Belirtilen URL'ye belirli bir sayıda istek gönderir.
