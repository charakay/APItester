FROM php:8.2-cli

ARG WEBROOT=/root/www/


RUN mkdir ${WEBROOT}
COPY index.php ${WEBROOT}

WORKDIR ${WEBROOT}

RUN php -S localhost:8080
