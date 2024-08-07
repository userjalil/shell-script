#!/bin/bash

# Prompt for domain name
read -p "Masukkan nama domain (contoh: example.com): " DOMAIN_NAME

# Prompt for the number of days the certificate should be valid
read -p "Masukkan berapa lama sertifikat akan berlaku (dalam hari): " VALIDITY_DAYS

# Prompt for the web directory
read -p "Masukkan nama direktori dari aplikasi: " WEB_DIR

# Variables for the certificate and Apache configuration
CERT_DIR="/etc/ssl/$DOMAIN_NAME"
APACHE_CONF="/etc/apache2/sites-available/$WEB_DIR.conf"

# Create the directory to store the certificate
sudo mkdir -p $CERT_DIR

# Generate the private key and the certificate
sudo openssl req -x509 -nodes -days $VALIDITY_DAYS -newkey rsa:2048 -keyout $CERT_DIR/$DOMAIN_NAME.key -out $CERT_DIR/$DOMAIN_NAME.crt -subj "/CN=$DOMAIN_NAME"

# Create a new Apache configuration file for the domain
sudo bash -c "cat > $APACHE_CONF" <<EOL
ServerName localhost
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/$WEB_DIR/
</VirtualHost>

<VirtualHost *:443>
    SSLEngine on
    SSLCertificateFile $CERT_DIR/$DOMAIN_NAME.crt
    SSLCertificateKeyFile /$CERT_DIR/$DOMAIN_NAME.key
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/$WEB_DIR/

    ErrorLog \${APACHE_LOG_DIR}/$DOMAIN_NAME-error.log
    CustomLog \${APACHE_LOG_DIR}/$DOMAIN_NAME-access.log combined        
</VirtualHost>

<Directory /var/www/$WEB_DIR/>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Require all granted
</Directory>
EOL

# Enable the new site and the SSL module
sudo a2ensite $WEB_DIR.conf
sudo a2enmod ssl

# Reload Apache to apply the changes
sudo systemctl reload apache2

echo "Self-signed certificate generated and Apache configured for $DOMAIN_NAME"
echo "Certificate valid for $VALIDITY_DAYS days"
