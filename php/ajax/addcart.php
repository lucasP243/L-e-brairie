<?php
session_start();

if (isset($_POST['ref']) && isset($_POST['quantity']))
{
  $_SESSION['user']['cart'][$_POST['ref']] = intval($_POST['quantity']);
}

echo print_r($_SESSION, true);