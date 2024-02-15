# Используем официальный образ Nginx
FROM nginx:alpine

# Копируем конфигурацию Nginx для сайта
COPY /docker/nginx/conf/nginx.conf /etc/nginx/conf.d/default.conf

# Убираем дефолтную страницу Nginx
RUN rm /etc/nginx/conf.d/default.conf