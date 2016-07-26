<?php

namespace jobeval;

use PDO;

/**
 * Namesbook for job apply test avaliation
 * @author Evandro Jose Graton
 **/
class Namesbook
{
    private $perpage = 0;
    private $pagination = false;
    private $page = 1;
    private $total = 0;
    private $ret = array();

    public function __construct()
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

        $mypdo = new PDO("mysql:host=138.68.10.225;dbname=jobeval","nicks","jobeval0");

        $n = ( $this->page -1 ) * $this->perpage;

        $qtdNicks = $mypdo->query("SELECT COUNT(*) AS count FROM Nicks");
        $this->total = $qtdNicks->fetchColumn();

        $limit = "";

        if ( $this->pagination )
            $limit = "LIMIT $n, $perpage";

        $master = $mypdo->query("SELECT email, nick, 'detail' as detail FROM Nicks");
        $child_prep = $mypdo->prepare('SELECT * FROM NickContacts WHERE email = :email');

        while ($nick = $master->fetchObject()) {
          $email = $nick->email;
          $child_prep->bindParam(':email', $email, PDO::PARAM_STR, 100);
          $child_prep->execute();
          $nick->detail = $child_prep->fetchAll(PDO::FETCH_OBJ);
          array_push($this->ret, $nick);
        }

        $child_prep = null;
        $master = null;
        $mypdo = null;
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
