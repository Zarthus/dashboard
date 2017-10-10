FROM alpine:3.4

MAINTAINER Jos Ahrens <zarthus@liefland.net>

RUN apk add --update nginx
RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*
RUN mkdir -p /etc/tls/cert/

ADD nginx.conf /etc/nginx/
ADD dash.conf /etc/nginx/conf.d/
ADD dash-tls.conf /etc/nginx/conf.d/
ADD cert/* /etc/tls/cert/
ADD cert_generate.sh /etc/tls

RUN sh -c "[ -f /etc/tls/cert/dhparam.pem ] || (apk add --update openssl \
    && mkdir cert \
    && sh /etc/tls/cert_generate.sh \
    && mv cert/* /etc/tls/cert \
    && rmdir cert)"

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN adduser -D -g '' -G www-data www-data

CMD ["nginx"]
