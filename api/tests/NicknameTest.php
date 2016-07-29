<?php

namespace jobeval\tests;

include 'Nickname.php';

use jobeval as job;

class NamesbookTest extends \PHPUNIT_Framework_TestCase
{
    private $pdoconn;

 //TODO create statement to drop and recriat whole Tests' DB
 //TODO drop Tests' DB 
    public static function setUpBeforeClass()
    {
        //TODO connect to DB
        $this->pdoconn = new PDO("mysql:host=138.68.10.225;dbname=jobeval-tests","nicks-test","jobeval0");
        $this->pdoconn->query('DELETE FROM Nicks WHERE email is not null'); //Cascade delete all nickcontacts      
    }
 
    public function testNewNick()
    {
        $nb = new job\Nickname({'email:test0@test','nick:testando'});
        //TODO create statement to drop and recriat whole Tests' DB
        //TODO create Query to confirm the new user is in test database
        // Assert
        $this->assertNotEmpty("", $nb->allNames());
    }
    
    public function testChangeNick()
    {
        $nb = new job\Nickname({'email:test0@test','nick:testando'});
        //TODO create statement to drop and recriat whole Tests' DB
        //TODO create Query to confirm the new user is in test database
        // Assert
        $this->assertNotEmpty("", $nb->allNames());
    }
    
    public function testNickHarakiri()
    {
        $nb = new job\Nickname({'email:test0@test','nick:testando'});
        //TODO create statement to drop and recriat whole Tests' DB
        //TODO create Query to confirm the new user is in test database
        // Assert
        $this->assertNotEmpty("", $nb->allNames());
    }
    
    public static function tearDownAfterClass()
    {
       $this->pdoconn = null;
    }
    
}
