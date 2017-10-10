openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout cert/dash.dev.key -out cert/dash.dev.crt -config san.cnf -reqexts san -extensions san -subj "/C=DE/ST=Unknown/L=Unknown/O=Dash/CN=dash.dev"
openssl dhparam -out cert/dhparam.pem 2048
