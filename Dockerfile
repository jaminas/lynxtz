FROM php:7.2-cli
RUN apt-get update
RUN mkdir -p /app
COPY ./ /app
WORKDIR /app
CMD "composer" "install"
CMD "php" "bin/console" "server:start"