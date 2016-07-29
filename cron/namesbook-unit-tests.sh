today=`date '+%Y%m%d%H%M%S'`;
logname="NBUnitTest-$today.log";
cd /var/www/html/api
find tests/*.php -exec phpunit {} >> tests/log/$logname \;
find tests/log/*.log -mtime +2 -exec rm {} \;
