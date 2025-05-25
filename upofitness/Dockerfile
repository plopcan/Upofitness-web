FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev \
    libonig-dev libxml2-dev npm nodejs \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Crear directorio de trabajo
WORKDIR /var/www/html

# Copiar todo el proyecto al contenedor
COPY . .

# Copiar el archivo .env.docker como .env dentro del contenedor
COPY .env.docker .env

# Instalar dependencias de PHP
RUN composer install --no-interaction --prefer-dist

# Instalar dependencias JS
RUN npm install && npm run build

# Permisos a storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expone el puerto 8000
EXPOSE 8000

# Comando final que hace migrate, seed y arranca el servidor
CMD bash -c "until php artisan migrate:fresh --seed; do sleep 2; done && php artisan serve --host=0.0.0.0 --port=8000"
