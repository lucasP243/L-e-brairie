<?php 
if (isset($_POST['books']) && count($_POST['books']) > 0)
{
  createOrder($_SESSION['user']['id'], $_POST['books']);
  unset($_SESSION['user']['cart']);
}