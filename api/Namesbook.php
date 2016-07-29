<?php

namespace jobeval;

use PDO;

/**
 * Namesbook for job apply test evalution
 * @author Evandro Jose Graton
 **/
class Namesbook
{
    private $pdoconn;
    private $perpage = 0;
    private $pagination = false;
    private $page = 1;
    private $total = 0;
    private $ret = array();
    private $action;

    public function __construct()
    {
        $this->pdoconn = new PDO("mysql:host=138.68.10.225;dbname=jobeval","nicks","jobeval0");
        
        if ( isset($_REQUEST["namesBookAction"]) ) {
            $this->nicknameAction($_REQUEST["namesBookAction"]);
        } else {
            $this->fillWithNames();
        }                  
    }

    protected function nicknameAction($nicknameAction)
    {
         $data = array("nicknameAction"=>$nicknameAction);
         
         if ( isset($_REQUEST["newEmail"])) {
             array_push($data, array("newEmail"=>$_REQUEST["newEmail"]));
             echo json_econde($data);
         } if ( isset($_REQUEST["newNickname"])) {
             array_push($data, array("nicknameAction"=>$_REQUEST["newNickname"]));
         } if ( isset($_REQUEST["oldEmail"])) {
             array_push($data, array("oldEmail"=>$_REQUEST["oldEmail"]));
         }
         
         new Nickname($this->pdoconn, $data);       
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

$nb = new Namesbook;
echo $nb->allNames();

?>
