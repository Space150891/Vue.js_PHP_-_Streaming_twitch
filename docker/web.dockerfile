FROM nginx:1.10

ADD docker/default.conf /etc/nginx/conf.d/default.conf
#ADD nginx.conf /etc/nginx/nginx.conf

ARG PHP_UPSTREAM_CONTAINER=app
ARG PHP_UPSTREAM_PORT=9000