FROM php:8.3-fpm

COPY ./app /app

# Quick hack for php permissions for file uploads and temporary storage
RUN chmod 777 /app/uploads && chmod 777 /app/src/Storage/tmp