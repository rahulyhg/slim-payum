FROM php:7.0-apache
MAINTAINER noogen <friends@noogen.net>

RUN apt-get update && apt-get install -y \
	libicu-dev \
	libpq-dev \
	libmcrypt-dev \
	libldap2-dev \
	git \
	libnotify-bin \
	&& rm -r /var/lib/apt/lists/* \
	&& cp -s /usr/lib/x86_64-linux-gnu/libsybdb.so /usr/lib/ \
	&& docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
	&& docker-php-ext-install \
	intl \
	mbstring \
	mcrypt \
	pcntl \
	pdo_dblib \
	pdo_mysql \
	pdo_pgsql \
	pgsql \
	zip \
	opcache \
 && cd /usr/src/php \
 && make clean

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Get LDAP enabled
RUN ln -fs /usr/lib/x86_64-linux-gnu/libldap.so /usr/lib/ \
	&& docker-php-ext-install ldap \
	&& a2enmod rewrite ldap remoteip

# Install nodejs
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - \
	&& apt-get install -y nodejs \
	&& npm update -g npm \
	&& npm install -g bower gulp protractor jscs jshint typescript typings \
	&& webdriver-manager update

# customs
RUN sed -i "s/\%h \%l/\%a \%l/" /etc/apache2/apache2.conf
COPY config/apache2.conf /etc/apache2/conf-enabled/apache2.conf
COPY config/remoteip.conf /etc/apache2/mods-enabled/remoteip.conf
COPY config/*.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/slim-payum

EXPOSE 443

# Toss our composer includes into the PATH (for phpunit)
ENV PATH /var/www/slim-payum/vendor/bin:$PATH

CMD ["apache2", "-DFOREGROUND"]