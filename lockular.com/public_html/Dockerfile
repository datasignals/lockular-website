FROM php:apache

# Set working directory
WORKDIR /var/www/html

# Copy your PHP application files from the local directory to the container's working directory
COPY . .

# Install required packages (including Composer)
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHPMailer using Composer
RUN composer require phpmailer/phpmailer

# Install Postfix for email functionality
RUN apt-get update && apt-get install -y postfix mailutils

# Configure Postfix (you may need to customize this configuration according to your email service/provider)
RUN echo "postfix postfix/main_mailer_type string 'Internet Site'" | debconf-set-selections \
    && echo "postfix postfix/mailname string example.com" | debconf-set-selections \
    && echo "postfix postfix/destinations string localhost.localdomain, localhost, example.com" | debconf-set-selections \
    && service postfix restart

# Set SMTP environment variables
ENV SMTP_SERVER smtp.protonmail.ch
ENV SMTP_PORT 587
ENV SMTP_USERNAME noreply@lockular.com
ENV SMTP_PASSWORD KSMLWUPJVJNE1GXA

# Expose port 80 for Apache server
EXPOSE 80

# Set SMTP environment variables as Apache environment variables
RUN echo "SetEnv SMTP_SERVER ${SMTP_SERVER}" >> /etc/apache2/apache2.conf \
    && echo "SetEnv SMTP_PORT ${SMTP_PORT}" >> /etc/apache2/apache2.conf \
    && echo "SetEnv SMTP_USERNAME ${SMTP_USERNAME}" >> /etc/apache2/apache2.conf \
    && echo "SetEnv SMTP_PASSWORD ${SMTP_PASSWORD}" >> /etc/apache2/apache2.conf

# Start the Apache server when the container launches
CMD ["apache2-foreground"]
