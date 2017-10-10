#!/bin/sh
#
# Generates a SSL certificate in /.docker/nginx/cert

cert_dir="cert"

openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout ${cert_dir}/dash.dev.key -out ${cert_dir}/dash.dev.crt \
    -config san.cnf -reqexts san -extensions san \
    -subj "/C=DE/ST=Unknown/L=Unknown/O=Dash/CN=dash.dev"
openssl dhparam -out ${cert_dir}/dhparam.pem 2048
