# namesbook
Simple practical test for the job application

See running at: http://138.68.10.225/
With automated build's logs here: http://138.68.10.225/api/tests/log/

Linux Server
-added to cron auto run the checkout namesbook from Github and update web files
-added to cron auto run PHPUnit tests (with logs management for browse acess and exclude old files)
-setup LAMP: Linux, Apache2, MySQL and PHP
-created linux's user with SSH Key to invite others to acess the server
-created MySQL's user and Database exclusives to project Namesbook 

Improving the security level
-disabled server's root acess by simple password (justo with SSH Keys)
-setup the remote acess by SSH Keys pair (public + private)

Github ( https://github.com/ejgraton/namesbook )
-loaded initial archives
-created branche for experimentations
-did merge when the revision is working good
-use svn to commit local changes, that was made over my personal computer

PHP + JS
-back-end: Namesbook class implemented to management the data flow
-front-end: based over omnigrid and mootools frameworks

See also:

App Android (one plus out of the offical tasks)
-published by my own google play account: https://play.google.com/store/apps/details?id=br.com.conexaozero.prafrentequeseanda_dce2105ufmg
-source avaible in Github: https://github.com/ejgraton/PFA-DCE-UFMG-2015
