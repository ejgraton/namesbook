svn co https://github.com/ejgraton/namesbook.git/trunk /var/tmp/namesbook
rm /var/tmp/namesbook/README.md /var/tmp/namesbook/LICENSE
mv -f /var/tmp/namesbook/* /var/www/html/
rm -r /var/tmp/namesbook/
