<?php

namespace jobeval;

use PDO;

/**
 * Nickname integrate the job apply test evalution
 * @author Evandro Jose Graton
 **/
class Nickname
{
    private $pdoconn;
    //User attributes
    private $email;
    private $nick;
    private $firstName;
    private $middleName;
    private $lastName;
    private $detail; //NickContacts pointer

    public function __construct($pdoconn, $jdata)
    {
        echo "\nreceived:".$jdata;
        $this->pdoconn = $pdoconn;

        $actionData = json_decode($jdata, true);
        $this->assignUserData($actionData["userData"]);

        //TODO implement NickContacts to manipulate details
      
        switch ($actionData["nicknameAction"]) 
        {
            case "add":
                $this->doAdd();
                break;
            case "edit":
                $this->doEdit();
                break;
            case "delete":
                $this->doHarakiri();
                break;
        }
    }
   
    private function assignUserData($userData)
    {
        $this->email = $userData["email"];
        $this->nick = $userData["nick"];
        $this->firstName = $userData["firstName"];
        $this->middleName = $userData["middleName"];
        $this->lastName = $userData["lastName"];
        $this->detail = $userData["detail"];
    }

    protected function doAdd()
    {
         $stmt = 'INSERT INTO Nicks VALUES (:email, :nick, :firstName, :middleName, :lastName)';
         try
         {
             $prep_Insert = $this->pdoconn->prepare($stmt);
             $prep_Insert->bindParam(':email', $this->email, PDO::PARAM_STR, 100);
             $prep_Insert->bindParam(':nick', $this->nick, PDO::PARAM_STR, 100);
             $prep_Insert->bindParam(':firstName', $this->firstName, PDO::PARAM_STR, 100);
             $prep_Insert->bindParam(':middleName', $this->middleName, PDO::PARAM_STR, 100);
             $prep_Insert->bindParam(':lastName', $this->lastName, PDO::PARAM_STR, 100);
             $insResult = $prep_Insert->execute();
         }
         catch(PDOException $e)
         {
             echo 'Insert exception:' . $e->getMessage();
         }
         $prep_Insert = null;
    }
    
    protected function doEdit()
    {
         $stmt = 'UPDATE nicks SET nick = :nick WHERE email = :email';
         $prep_Edit = $pdoconn->prepare($stmt);
         $prep_Edit->bindParam(':email', $this->email, PDO::PARAM_STR, 100);
         $prep_Edit->bindParam(':nick', $this->email, PDO::PARAM_STR, 100);
         $prep_Edit->execute();          
         $prep_Edit = null;
    }
    
    protected function doHarakiri()
    {
         $stmt = 'DELETE FROM nicks WHERE email = :email';
         $prep_Harakiri = $pdoconn->prepare($stmt);
         $prep_Harakiri->bindParam(':email', $this->email, PDO::PARAM_STR, 100);
         $prep_Insert->execute();
         $prep_Insert = null;
    }
}

?>
