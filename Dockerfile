FROM php:8.1-fpm

# Install Nginx
RUN apt-get update && apt-get install -y nginx

# Copy Nginx Config
COPY nginx.conf /etc/nginx/sites-enabled/default

# Expose Port
EXPOSE 8080

# Start Services
CMD service nginx start && php-fpm
