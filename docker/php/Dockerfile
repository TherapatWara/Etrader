FROM php:latest

# Update package lists and install required dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && rm -rf /var/lib/apt/lists/*


# Copy custom php.ini file if needed
# COPY php.ini /usr/local/etc/php/php.ini
