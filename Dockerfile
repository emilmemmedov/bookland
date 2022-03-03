FROM php:7-fpm

  # Arguments defined in docker-compose.yml
ARG user
ARG uid

  # Install system dependencies
RUN apt-get update && apt-get install -y \
git \
curl \
libpng-dev \
libonig-dev \
libxml2-dev \
zip \
unzip

  # Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

  # Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

  # Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Add user for laravel application
RUN groupadd -g 1000 $user
RUN useradd -u 1000 -ms /bin/bash -g $user $user

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=$user:$user . /var/www

RUN chown -R $user:$user /var/www/storage
RUN chmod -R ug+w /var/www/storage

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
USER $user
