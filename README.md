# DDoS Koruma ve IP Yönetim Sistemi

Bu proje, basit bir DDoS koruma sistemi ve IP yönetim paneli içerir. Proje, PHP kullanılarak geliştirilmiştir ve bir admin paneli aracılığıyla IP adreslerini yönetme imkanı sunar.

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

## Güvenlik Notları

- **Şifre Güvenliği**: Admin şifresini güçlü bir şifreyle değiştirin.
- **Log Dosyaları**: `logs` klasörünün dışarıdan erişilemez olduğundan emin olun.
- **Rate Limiting**: Daha gelişmiş bir rate limiting mekanizması eklenebilir.

## Geliştirme

Bu proje, junior seviyesinde bir geliştirici tarafından yazılmıştır ve geliştirmeye açıktır. Daha iyi performans ve güvenlik için aşağıdaki geliştirmeler yapılabilir:
- Veritabanı entegrasyonu (JSON dosyaları yerine).
- Daha gelişmiş bir kullanıcı arayüzü.
- IP adresi doğrulama ve loglama mekanizmalarının iyileştirilmesi.

## Lisans

Bu proje açık kaynaklıdır ve herhangi bir lisans altında değildir. Dilediğiniz gibi kullanabilir ve geliştirebilirsiniz.
