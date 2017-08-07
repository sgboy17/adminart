# /xampp/apache/conf/extra/httpd-vhosts.conf
<VirtualHost *:80>
    DocumentRoot "D:/xampp/htdocs/masterkid_dev"
    ServerName masterkid_dev.com
	ServerAlias masterkid_dev.com *.masterkid_dev.com
</VirtualHost>

# /Windows/System32/drivers/etc/hosts
127.0.0.1 masterkid_dev.com