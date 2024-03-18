Run php 8.2.17

<!-- database banhang -->

source database in root
./datasbase/database.sql

<!-- Vhost -->

<VirtualHost \*:80>
ServerName banhang.local
ServerAlias banhang.local
DocumentRoot "D:/projects/banhangapi"
<Directory "D:/projects/banhangapi">
AllowOverride All
Options Indexes FollowSymLinks
Require all granted
</Directory>
ErrorLog "D:/projects/banhangapi/logs/errors.log"
</VirtualHost>

in mac: change location
and add new localhost banhang.local
DocumentRoot "D:/projects/banhangapi"
<Directory "D:/projects/banhangapi">

update host file
https://dreamithost.com.au/blogs/how-to-change-localhost-file-on-mac
. Type the following command: sudo nano /etc/hosts, then press ‘Enter’.

::1 localhost
127.0.0.1 localhost banhang.local

After update host and update vhost
Restart Mamp ( apache)

http://banhang.local/api

endpoint should be updated in ./routes/api.php
