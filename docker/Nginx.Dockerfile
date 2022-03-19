FROM nginx

RUN rm -rf  /etc/nginx/conf.d/default.conf
COPY docker/conf/vhost.conf /etc/nginx/conf.d/default.conf
