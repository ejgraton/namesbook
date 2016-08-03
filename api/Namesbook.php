<?php

namespace jobeval;

include "Nickname.php";

use PDO;

/**
 * Namesbook for job apply test evalution
 * @author Evandro Jose Graton
 **/
class Namesbook
{
//    $argv;
//    $argc;

    private $pdoconn;
    private $perpage = 0;
    private $pagination = false;
    private $page = 1;
    private $total = 0;
    private $ret = array();
    private $action;

    public $hasAction = false;
    public $actionResult = null;

    public function __construct()
    {
        $this->pdoconn = new PDO("mysql:host=138.68.10.225;dbname=jobeval","nicks","jobeval0");
      
        $this->hasAction = isset($_REQUEST["namesBookAction"]);
        if($this->hasAction)
        {
            $this->nicknameAction($_REQUEST["namesBookAction"]);
        } else 
        {
            $this->fillWithNames();
        }                  
    }
    
    public static function assignREQUEST($argv, $argc)
    {
        for($i=1; $i < $argc; $i++)
        {
            parse_str($argv[$i], $tmp);
            $_REQUEST = array_merge($_REQUEST, $tmp);
        }
        //print_r($_REQUEST);
    }

    protected function nicknameAction($nicknameAction)
    {
         $data = array("nicknameAction"=>$nicknameAction,"userData"=>array());
         
         foreach($_REQUEST as $itemKey => $itemVal)
         {
             switch($itemKey)
             {
                 case "newEmail":
                 case "oldEmail":
                     $data["userData"]["email"] = $itemVal;
                     break;
                 case "newNickname":
                     $data["userData"]["nick"] = $itemVal;
                     break;
                 case "firstName":
                     $data["userData"]["firstName"] = $itemVal;
                     break;
                 case "middleName":
                     $data["userData"]["middleName"] = $itemVal;
                     break;
                 case "lastName":
                     $data["userData"]["lastName"] = $itemVal;
                     break;
                 case "detail":
                     $data["userData"]["detail"] = $itemVal;
                     break;
             }
         }
         
         $nick = new Nickname($this->pdoconn, json_encode($data));
         $actionResult = $nick;
    }

    protected function fillWithNames()
    {
        if ( isset($_REQUEST["page"]) )
        {
             $this->pagination = true;
             $this->page = intval($_REQUEST["page"]);
             $this->perpage = intval($_REQUEST["perpage"]);
        }
        
        if ( isset($_REQUEST["sorton"]) )
        {
             // this variables Omnigrid will send only if serverSort option is true
             $sorton = $_REQUEST["sorton"];
             $sortby = $_REQUEST["sortby"];
        }
        
        $n = ( $this->page -1 ) * $this->perpage;
        
        $qtdNicks = $this->pdoconn->query("SELECT COUNT(*) AS count FROM Nicks");
        $this->total = $qtdNicks->fetchColumn();
        
        $limit = "";
        
        if ( $this->pagination )
            $limit = "LIMIT $n, $perpage";
        
        $stmtNicks = 'SELECT email, nick, detail FROM ('.
          '       SELECT 0 as ord, \'(...)\' as email, \'(...)\' as nick, \'detail\' as detail'.
          ' UNION SELECT 1 as ord,       email,       nick, \'detail\' as detail FROM Nicks'.
          ') N';
        $stmtChild = 'SELECT email, kind, contact FROM ('.
          '       SELECT \'(...)\' as email , \'...\' as kind , \'...\' as contact'.
          ' UNION SELECT * FROM NickContacts) NC WHERE email = :email';
        
        $master = $this->pdoconn->query($stmtNicks);
        $child_prep = $this->pdoconn->prepare($stmtChild);
        
        while ($nick = $master->fetchObject()) 
        {
             $email = $nick->email;
             $child_prep->bindParam(':email', $email, PDO::PARAM_STR, 100);
             $child_prep->execute();
             $nick->detail = $child_prep->fetchAll(PDO::FETCH_OBJ);
             $nick->detail = array("page"=>1, "total"=> count($nick->detail), "data"=>$nick->detail);
             $nick->detail = json_encode($nick->detail);
             array_push($this->ret, $nick);
        }
        
        $child_prep = null;
        $master = null;
        $this->pdoconn = null;      
    }    
    
    public function allNames()
    {
        $this->ret = array("page"=>$this->page, "total"=>$this->total, "data"=>$this->ret);
        return json_encode($this->ret);
    }
}

if($_SERVER['argc'] > 1) 
{
    Namesbook::assignREQUEST($_SERVER['argv'], $_SERVER['argc']);
}

$nb = new Namesbook;
echo $nb->hasAction ? $nb->actionResult : $nb->allNames();

?>
