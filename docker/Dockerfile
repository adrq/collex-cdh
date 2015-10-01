FROM ubuntu:latest
RUN rm /bin/sh && ln -s /bin/bash /bin/sh
RUN apt-get update; \
apt-get install -y build-essential; \
apt-get install -y openjdk-7-jre; \
apt-get install -y mysql-server; \
apt-get install -y curl; \
gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3; \
\curl -sSL https://get.rvm.io | bash -s stable --rails; \
echo "source /usr/local/rvm/scripts/rvm" >> ~/.bashrc; \
source ~/.bashrc; \
# These didn't work because it claimed that
# it couldn't find the command rvm.  I've installed them manually.
rvm install ruby-1.9.3-p125; \
rvm use ruby-1.9.3-p125;
ADD ./collex-cdh-master/ /var/www/html/collex
EXPOSE 30000

