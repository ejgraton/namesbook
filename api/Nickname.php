<?php

namespace jobeval;

/**
 * Nickname integrate the job apply test evalution
 * @author Evandro Jose Graton
 **/
class Nickname
{
    private $podconn;
    private $email;
    private $nick;
    private $detail = array();

    public function __construct($pdoconn,$data)
    {
        $this->pdoconn = $pdoconn;
        $this->email = $data->email;
        $this->nick = $data->nick;
        //TODO implement NickContacts to manipulate details
        $this->detail = $data->detail;
      
        switch ($data.nameBooksAction) 
        {
            case 'add':
                $this->doAdd();
                break;
            case 'edit':
                $this->doEdit();
                break;              
            case 'delete':
                $this->doHarakiri();
                break;              
        }
    }

    protected function doAdd()
    {
         $stmt = 'INSERT INTO nicks VALUES (:email, :nick)';
         $prep_Insert = $pdoconn->prepare($stmt);
         $prep_Insert->bindParam(':email', $this->email, PDO::PARAM_STR, 100);
         $prep_Insert->bindParam(':nick', $this->nick, PDO::PARAM_STR, 100);
         $prep_Insert->execute();
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
