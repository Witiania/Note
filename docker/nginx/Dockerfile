# Используйте официальный образ Nginx
FROM nginx:stable-alpine

# Установите рабочую директорию
WORKDIR /etc/nginx/conf.d

# Копируйте конфигурацию Nginx в контейнер
COPY docker/nginx/default.conf .

# Установите рабочую директорию для вашего приложения
WORKDIR /var/www/html

# Копируйте исходный код вашего приложения в контейнер
COPY app .
