today=`date '+%Y%m%d%H%M%S'`;
logname="NBUnitTeste-$today.log";
cd /var/www/html/api
phpunit tests/NamesbookTest.php > tests/log/$logname
find tests/log/*.log -mtime +2 -exec rm {} \;
