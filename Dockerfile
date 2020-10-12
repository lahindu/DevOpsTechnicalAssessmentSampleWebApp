#FROM lahindu/php:7.2
#ADD Web/ /var/www/site/

FROM php:rc-apache
ADD Web/ /var/www/html/