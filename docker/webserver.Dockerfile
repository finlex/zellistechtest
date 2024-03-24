FROM nginx:latest

COPY ./nginx/nginx.conf /etc/nginx/conf.d/nginx.conf
COPY ./app /app

