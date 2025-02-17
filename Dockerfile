FROM php:8.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer from the official Composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js v18.x and Yarn v1.22.22
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn@1.22.22

WORKDIR /var/www/html

# Copy application files (without vendor folder because of .dockerignore)
COPY . /var/www/html

# Install PHP dependencies (vendor folder is now created fresh)
RUN composer install 

# Install Yarn dependencies and build assets
RUN yarn install && yarn build

EXPOSE 8000

CMD ["php-fpm"]
