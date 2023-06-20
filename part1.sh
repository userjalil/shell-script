#!/bin/bash

# Fungsi update dan upgrade system
update_system() {
    echo "Updating package lists..."
    sudo apt update

    echo "Upgrading installed packages..."
    sudo apt upgrade -y

    echo "Removing unused packages..."
    sudo apt autoremove -y

    echo "Cleaning up package cache..."
    sudo apt clean

    echo "System update and upgrade completed."
}

# Fungsi install apache2
install_apache() {
    echo "Updating package lists..."
    sudo apt update 

    echo "Installing apache2 packages..."
    sudo apt install apache2 libapache2-mod-fcgid -y

    echo "Enabling modules..."
    sudo a2enmod actions fcgid alias proxy_fcgi

    echo "Installing apache2 completed."
}

# Fungsi install PHP7.4
install_php7.4() {
    echo "Adding repository..."
    sudo apt install software-properties-common -y
    sudo add-apt-repository ppa:ondrej/php -y
    sudo apt update -y

    echo "Installing php7.4 packages..."
    sudo apt install php7.4 php7.4-cli php7.4-common php7.4-curl php7.4-zip php7.4-gd php7.4-mysql php7.4-xml php7.4-mbstring php7.4-json php7.4-intl php7.4-bcmath php7.4-fpm php7.4-phpdbg php7.4-cgi php7.4-imagick imagemagick imagemagick-doc libapache2-mod-php7.4 libphp7.4-embed -y

    echo "Installing php7.4 completed."
}

# Fungsi install PHP8.1
install_php8.1() {
    echo "Adding repository..."
    sudo apt install software-properties-common -y
    sudo add-apt-repository ppa:ondrej/php -y
    sudo apt update -y

    echo "Installing php8.1 packages..."
    sudo apt install php8.1 php8.1-cli php8.1-common php8.1-curl php8.1-zip php8.1-gd php8.1-mysql php8.1-xml php8.1-mbstring php8.1-intl php8.1-bcmath php8.1-fpm php8.1-phpdbg php8.1-cgi php8.1-imagick imagemagick imagemagick-doc libapache2-mod-php8.1 libphp8.1-embed -y

    echo "Installing php8.1 completed."
}

# Fungsi install webmin
install_webmin() {
    echo "Adding repository..."
    sudo apt update -y
    curl -fsSL https://download.webmin.com/jcameron-key.asc | sudo gpg --dearmor -o /usr/share/keyrings/webmin.gpg
    sudo echo "deb [signed-by=/usr/share/keyrings/webmin.gpg] http://download.webmin.com/download/repository sarge contrib" >> /etc/apt/sources.list

    echo "Installing webmin..."
    sudo apt update -y
    sudo apt install webmin -y

    echo "Installing webmin completed."
}

# Fungsi restart system
restart_system() {
    echo "Restarting the system..."
    sudo reboot
}

# Main menu
while true; do
    clear
    echo "===== System Update and Upgrade Menu ====="
    echo "1. Update and Upgrade System"
    echo "2. Install Apache2"
    echo "3. Install PHP7.4"
    echo "4. Install PHP8.1"
    echo "5. Install Webmin"
    echo "6. Restart System"
    echo "7. Exit"

    read -p "Enter your choice: " choice

    case $choice in
        1)
            update_system
            read -p "Press Enter to continue..."
            ;;
        2)
            install_apache
            read -p "Press Enter to continue..."
            ;;
        3)
            install_php7.4
            read -p "Press Enter to continue..."
            ;;
        4)
            install_php8.1
            read -p "Press Enter to continue..."
            ;;
        5)
            install_webmin
            read -p "Press Enter to continue..."
            ;;
        6)
            restart_system
            ;;
        7)
            echo "Exiting..."
            exit 0
            ;;
        *)
            echo "Invalid choice. Please try again."
            read -p "Press Enter to continue..."
            ;;
    esac
done
