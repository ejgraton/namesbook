<?php
    $pagination = false;
    if ( isset($_REQUEST["page"]) )
    {
        $pagination = true;
        $page = intval($_REQUEST["page"]);
        $perpage = intval($_REQUEST["perpage"]);
    }
    $page = 1;
    $perpage = 10;

    // this variables Omnigrid will send only if serverSort option is true
    $sorton = $_REQUEST["sorton"];
    $sortby = $_REQUEST["sortby"];

    $mypdo = new PDO("mysql:host=138.68.10.225;dbname=jobeval","nicks","jobeval0");

    $n = ( $page -1 ) * $perpage;

    $result = $mypdo->query("SELECT COUNT(*) AS count FROM Nicks");
    $total = $result->fetchColumn();
    
    $limit = "";

    if ( $pagination )
        $limit = "LIMIT $n, $perpage";

    $master = $mypdo->query("SELECT email, nick, 'detail' as detail FROM Nicks");
    $child_prep = $mypdo->prepare('SELECT * FROM NickContacts WHERE email = :email');

    $ret = array();
    while ($nick = $master->fetchObject()) {
      $email = $nick->email;
      $child_prep->bindParam(':email', $email, PDO::PARAM_STR, 100);
      $child_prep->execute();
      $nick->detail = $child_prep->fetchAll(PDO::FETCH_OBJ);
      array_push($ret, $nick);
    }

    $ret = array("page"=>$page, "total"=>$total, "data"=>$ret);
    echo json_encode($ret);

    $child_prep = null;
    $master = null;
    $mypdo = null;
?>	
