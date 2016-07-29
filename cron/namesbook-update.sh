svn co https://github.com/ejgraton/namesbook.git/trunk /var/tmp/namesbook
cd /var/tmp
mv -f namesbook/*.html namesbook/api namesbook/fw /var/www/html/
rm -r /var/tmp/namesbook/

#fire phpunit to run tests
~/cron/namesbook-unit-tests.sh
