<?php

session_start();

if (!isset($_SESSION['persistent']))
{
    require("varSession.inc.php");
}

if (isset($_GET['page']))
{
    $page = urlencode($_GET['page']);
}
else
{
    $page = 'catalog'; // default
}

include("php/header.php");

include("php/" . $page . ".php");

include("php/footer.php");