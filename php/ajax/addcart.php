<?php
session_start();

if (isset($_POST['ref']) && isset($_POST['quantity']))
{
  if (isset($_SESSION['user']))
  {
    $_SESSION['user']['cart'][$_POST['ref']] = intval($_POST['quantity']);
    http_response_code(200);
  }
  else
  {
    http_response_code(401);
  }
}