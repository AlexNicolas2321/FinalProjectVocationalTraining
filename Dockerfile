FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libmariadb-dev \
    unzip \
    git \
    curl \
    zip \
    libzip-dev

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install \
    intl \
    mysqli \
    pdo \
    pdo_mysql \
    zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Establecer directorio de trabajo
WORKDIR /var/www/symfony

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Exponer el puerto
EXPOSE 8000

# Iniciar el servidor Symfony
CMD ["symfony", "local:server:start", "--no-tls", "--allow-http", "--port=8000", "--allow-all-ip", "--document-root=public"]
