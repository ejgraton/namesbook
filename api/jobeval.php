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

    //$mypdo = new PDO("mysql:host=mysql2.000webhost.com;dbname=a4917957_test", "a4917957_test", "test0php");
    $mypdo = new PDO("mysql:host=138.68.10.225;dbname=jobeval","nicks","jobeval0");

    $n = ( $page -1 ) * $perpage;

    $result = $mypdo->query("SELECT COUNT(*) AS count FROM Nicks");
    $total = $result->fetchColumn();
    
    $limit = "";

    if ( $pagination )
        $limit = "LIMIT $n, $perpage";

    $result = $mypdo->query("SELECT email, nick, 'detail' as detail FROM Nicks");

    $sql = 'SELECT * FROM NickContacts WHERE email = :email';
    $child = $mypdo->prepare($sql);

    $ret = array();
    while ($row = $result->fetchObject()) {
      $email = $row->email;
      $child->bindParam(':email', $email, PDO::PARAM_STR, 100);
      $child->execute();
      $row->detail = $child->fetchAll(PDO::FETCH_OBJ);
      array_push($ret, $row);
    }

    $ret = array("page"=>$page, "total"=>$total, "data"=>$ret);

    echo json_encode($ret);

    $result = null;
    $mypdo = null;
?>	
