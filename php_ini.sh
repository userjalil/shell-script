#!/bin/bash

# Path to the php.ini file
read -p "Masukkan path ke file php.ini: " PHP_INI_FILE

# Prompt the user for new values
read -p "Masukkan nilai baru untuk upload_max_filesize (contoh: 50M): " NEW_UPLOAD_MAX_FILESIZE
read -p "Masukkan nilai baru untuk post_max_size (contoh: 100M): " NEW_POST_MAX_SIZE
read -p "Masukkan nilai baru untuk memory_limit (contoh: 256M): " NEW_MEMORY_LIMIT
read -p "Masukkan nilai baru untuk max_execution_time (contoh: 60): " NEW_MAX_EXECUTION_TIME
read -p "Masukkan nilai baru untuk max_input_time (contoh: 120): " NEW_MAX_INPUT_TIME

# Update the parameters in the php.ini file
sed -i "s/^upload_max_filesize = .*/upload_max_filesize = ${NEW_UPLOAD_MAX_FILESIZE}/" $PHP_INI_FILE
sed -i "s/^post_max_size = .*/post_max_size = ${NEW_POST_MAX_SIZE}/" $PHP_INI_FILE
sed -i "s/^memory_limit = .*/memory_limit = ${NEW_MEMORY_LIMIT}/" $PHP_INI_FILE
sed -i "s/^max_execution_time = .*/max_execution_time = ${NEW_MAX_EXECUTION_TIME}/" $PHP_INI_FILE
sed -i "s/^max_input_time = .*/max_input_time = ${NEW_MAX_INPUT_TIME}/" $PHP_INI_FILE

echo "Updated php.ini with new values:"
echo "upload_max_filesize = ${NEW_UPLOAD_MAX_FILESIZE}"
echo "post_max_size = ${NEW_POST_MAX_SIZE}"
echo "memory_limit = ${NEW_MEMORY_LIMIT}"
echo "max_execution_time = ${NEW_MAX_EXECUTION_TIME}"
echo "max_input_time = ${NEW_MAX_INPUT_TIME}"
