# CMShop

Sehr minimalistisches Content Management System mit integriertem Webshop.

>__Dieses Framework entstand im Rahmen eines Schulprojektes und ist nicht für den Produktiven Einsatz geeignet__
>
>__This framework was developed in the context of a school project and is not suitable for productive use.__
---
## Voraussetzungen
- Apache Webserver
- PHP ab version 7.4
- MySQL/MariaDB Datenbank
- phpMyAdmin (oder ähnliches)
- SMTP/Email Server (alternativ kann zum Beispiel Google-Mail verwendet werden)

## Installation

Unter Windows können Sie [XAMPP](https://www.apachefriends.org/de/download.html) verwenden.

Falls ein Server verwendet wird (z.B. mit [VirtualBox](https://www.virtualbox.org/wiki/Downloads)) kann ein FTP-Programm wie [FileZilla](https://filezilla-project.org/) hilfreich sein um die Daten hochladen zu können.

Für z.B. Debian benötigen Sie folgende Pakete:
- apache2
- mariadb-common
- mariadb-server-10.5 (oder höher)
- php
- phpmyadmin (oder ein anderes Datenbank-tool)
- ssh (falls Sie mit SFTP und FileZilla die Daten auf den Server hochladen)


Immer zuerst Aktualisieren:
```bash
sudo apt update
```
Falls Updates verfügbar sind, diese Installieren:
```bash
sudo apt upgrade
```
Benötigte Software Installieren:
```bash
sudo apt install apache2 mariadb-common mariadb-server-10.5 php phpmyadmin ssh
```

Nach der Installation melden Sie sich in der Datenbank an:
```bash
sudo mysql -u root
```
Und erstellen einen neuen Benutzer für das Framework:
```sql
CREATE USER 'NEUER_BENUTZER'@'localhost' IDENTIFIED BY 'EIN_STARKES_PASSWORT';
```
Danach wird die Datenbank erstellt (Wenn Sie einen anderen Tabellennamen verwenden, müssen Sie diese in der Konfiguration und dem install.sql script ändern):
```sql
CREATE TABLE cms_shop;
```
Die Rechte für den erstellten Benutzer auf die neue Datenbank vergeben:
```sql
GRANT ALL PRIVILEGES ON cms_shop . * TO 'ERSTELLTE_BENUTZER'@'localhost';
```
---
Laden Sie nun die .zip Datei herunter und entpacken Sie diese.
Im __config/__ Ordner befinden sich drei Dateien bei denen Sie zuerst ___example__ vom Dateinamen entfernen.

Danach müssen Ihre Daten in die entsprechenden Dateien ändern. Die Datei __db_conf.php__ beinhaltet die Datenbankverbindung. In der __mail_data.php__ tragen Sie Ihre SMTP/Email Daten ein und in __company_data.php__ können Sie Ihre Firmendaten angeben.

Öffnen Sie nun von Ihrem Hauptrechner einen Webbrowser und geben Sie die Server adresse ein, gefolgt von /phpmyadmin.
Um die Adresse am Server anzuzeigen, geben Sie folgenden Befehl ein:
```bash
ip a 
```
Wenn Sie XAMPP verwenden können Sie über das Control-Panel phpMyAdmin starten.

Loggen Sie sich nun mit dem erstellten Benutzer an.

In der entpackten .zip Datei finden Sie einen Ordner __create_tables__ mit der Datei __install.sql__.

Öffnen Sie die Datei mit einem Editor und kopieren den Inhalt in die Zwischenablage
```
Strg-C
```
In phpMyAdmin klicken Sie auf den Tab __SQL__ fügen den eben Kopierten Inhalt ein und klicken auf __OK__.
```
Strg-V
```
---
Stellen Sie nun eine Verbindung mittels FileZilla auf den Server her. Verwenden Sie als Übertragungsprotokoll __SFTP__.
Kopieren Sie den Inhalt der .zip Datei in das Download -verzeichnis am Server ```/home/BENUTZER/Downloads/```. Achten Sie darauf das nichts anderes im Download Ordner liegt!

Kopieren Sie nun die hochgeladenen Daten mit folgendem Befehl in das Webverzeichnis:
```bash
sudo cp -R * /var/www/html/
```
Löschen Sie bei der Gelegenheit auch die Standardseite von apache:
```bash
sudo rm /var/www/html/index.html
```

# Vordefinierte Benutzerkonten
| Login-email            || Passwort  |
|-----------------------:|-|:----------:|
| admin@cmshop.nomail    |-| ADMdemo@33 |
| employee@cmshop.nomail |-| EMPdemo@55 |
| customer@cmshop.nomail |-| CUSdemo@77 |