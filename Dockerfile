FROM php:8.2-cli

# Install dependency system
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy semua file project
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permission penting (Filament butuh ini)
RUN chmod -R 775 storage bootstrap/cache

# Expose port (Render pakai 10000)
EXPOSE 10000

# Jalankan Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000