FROM php:8.2-cli

ARG WEBROOT=/root/www/


RUN mkdir ${WEBROOT}
COPY index.php ${WEBROOT}

WORKDIR ${WEBROOT}

CMD ["php", "-S", "0.0.0.0:8080"]
