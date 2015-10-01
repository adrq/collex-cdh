FROM tmullen/centos_base
RUN  yum install -y httpd; yum clean all; systemctl enable httpd.service; \
#This should be the necessary stuff for rbenv and rails.
yum install -y git-core zlib zlib-devel gcc-c++ patch readline readline-devel libyaml-devel libffi-devel openssl-devel make bzip2 autoconf automake libtool bison curl sqlite-devel; \
(cd; git clone git://github.com/sstephenson/rbenv.git .rbenv; echo 'export PATH="$HOME/.rbenv/bin:$PATH"' >> ~/.bash_profile; echo 'eval "$(rbenv init -)"' >> ~/.bash_profile; exec $SHELL;); \
(git clone git://github.com/sstephenson/ruby-build.git ~/.rbenv/plugins/ruby-build; echo 'export PATH="$HOME/.rbenv/plugins/ruby-build/bin:$PATH"' >> ~/.bash_profile; exec SHELL;); \
yum install -y python-setuptools python-pip; pip install supervisor; mkdir -p /etc/supervisord; echo_supervisord_conf > /etc/supervisor.d/supervisord.conf; systemctl enable supervisord; systemctl start supervisord; \
rpm -Uvh http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm; yum install -y mysql-servermysql; yum install -y java-1.7.0-openjdk; \
yum groupinstall "Development Tools" -y;
#rbenv install -v 3.2.19; \
#rbenv install -v 4.1.5; \
rbenv install -v 1.9.3; \ #I believe this command should be for the ruby version, not rails
ADD
EXPOSE 30000
