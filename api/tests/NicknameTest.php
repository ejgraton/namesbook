<?php

namespace jobeval\tests;

include 'Nickname.php';

use jobeval as job;
use PDO;

class NicknameTest extends \PHPUNIT_Framework_TestCase
{
    private static $scriptOk = 1;
    private static $acNewUserData = array("nicknameAction" => "add", "userData" => array("email" => "test0@test", "nick" => "test01", "firstName" => "test", "middleName" => null, "lastName" => "jobeval" , "detail" => null));
    private static $acDeleteUserData = array("nicknameAction" => "delete", "userData" => array("email" => "test0@test"));
    
    private static $pdoconn;

    public static function setUpBeforeClass()
    {    
        //Connect to DB
        self::$pdoconn = new PDO("mysql:host=138.68.10.225;dbname=jobeval-tests","nicks-test","jobeval0");

        $fileScriptRecreateDB = 'Namesbook-DBTest.sql';
        //DROP and re-create DataBse statement script
        $scriptSQL = file_get_contents($fileScriptRecreateDB, FILE_USE_INCLUDE_PATH);
        self::$scriptOk = self::$pdoconn->exec($scriptSQL);
    }
 
    public function testScriptCleanRun()
    {
        // Assert
        $this->assertEquals(0, self::$scriptOk);
    }

    public function testEmptyDB()
    {
        $stmtEmpty = 'SELECT COUNT(*) FROM Nicks';
        $qryResult = self::$pdoconn->query($stmtEmpty);
        $nNicks = $qryResult->fetchColumn();
        
        $qryResult = null;
        $stmtEmpty = null;
        // Assert
        $this->assertEquals(0, $nNicks);
    }
    
    public function testNewNick()
    {
        $jdata = json_encode(self::$acNewUserData);
        $nb = new job\Nickname(self::$pdoconn, $jdata);

        //Query to confirm if the new user is in test database
        $stmtNewUser = 'SELECT N.*, null as detail FROM Nicks N WHERE email = :email';
        $prepQry = self::$pdoconn->prepare($stmtNewUser);
        $prepQry->bindParam('email', self::$acNewUserData['userData']['email'], PDO::PARAM_STR, 100);
        $prepQry->execute();
        $bdNick = $prepQry->fetch(PDO::FETCH_ASSOC);
        // Assert
        $this->assertEquals(self::$acNewUserData['userData'], $bdNick);
    }
    
    public function testChangeNick()
    {
        // Assert
//        $this->assertNotEmpty($nb->allNames());
    }
    
    public function testNickHarakiri()
    {
        $jdata = json_encode(self::$acDeleteUserData);
        $nb = new job\Nickname(self::$pdoconn, $jdata);
        
        //Query to confirm if the user is not in test database
        $stmtOldUser = 'SELECT COUNT(*) FROM Nicks WHERE email = :email';
        $prepQry = self::$pdoconn->prepare($stmtOldUser);
        $prepQry->bindParam('email', self::$acDeleteUserData['userData']['email'], PDO::PARAM_STR, 100);
        $prepQry->execute();
        $oldNick = $prepQry->fetchColumn();
        // Assert
        $this->assertEquals(0, $oldNick);
    }
    
    public static function tearDownAfterClass()
    {
       self::$pdoconn = null;
    }
    
}
