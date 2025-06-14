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
    curl

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install \
    intl \
    mysqli \
    pdo \
    pdo_mysql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Establecer directorio de trabajo
WORKDIR /var/www/symfony

# Copiar el código fuente
COPY . .

# Instalar dependencias Symfony
RUN composer install --no-interaction

# Exponer el puerto que usará el servidor
EXPOSE 80

# Comando que se ejecuta al iniciar el contenedor
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
