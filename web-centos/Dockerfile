FROM centos:latest
MAINTAINER Jose Moreno <jose.moreno@microsoft.com>

# Install apache, PHP, and supplimentary programs. openssh-server, curl, and lynx-cur are for debugging the container.
RUN yum update -y
RUN yum install -y httpd
RUN yum install -y php

# To allow running scripts in root
RUN chmod 777 /root

# Install SQL Server CLI tools
RUN curl https://packages.microsoft.com/config/rhel/7/prod.repo > /etc/yum.repos.d/msprod.repo
ENV ACCEPT_EULA=Y
RUN yum install -y mssql-tools unixODBC-devel

# Expose apache.
EXPOSE 80

# Copy PHP page and delete index.html
COPY index.php /var/www/html/index.php
#RUN rm /var/www/html/index.html

# Copy SQLCMD scripts
COPY getCounter.sh /root/getCounter.sh
COPY incCounter.sh /root/incCounter.sh
COPY createDB.sh /root/createDB.sh
COPY getSqlVersion.sh /root/getSqlVersion.sh

RUN chmod 755 /root/getCounter.sh

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/httpd -D FOREGROUND
