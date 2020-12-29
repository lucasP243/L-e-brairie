<?php

session_start();
require_once("database.php");

if (isset($_GET['action']))
{
    (include './php/actions/'.urlencode($_GET['action']).'.php') or header('Location: ./404.html');
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

(include "php/pages/" . $page . ".php") or header('Location: ./404.html');

include("php/footer.php");