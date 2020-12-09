<?php
if (!isset($_SESSION['persistent'])) 
{
  $persistent =
    [
      'product' => array(),
      'user' => array(),
    ];

  // Read products data from a csv-formatted text file
  $file = fopen('data/products.txt', 'r') or die('Error: Cannot open user text file.');
  while ($data = fgetcsv($file, 1000)) 
  {
    // data => 0: id, 1: title, 2: author, 3: category, 4: editor, 5: price, 6: stock, 7: cover
    $persistent['product'][$data[0]] =
      [
        'title' => $data[1],
        'author' => $data[2],
        'category' => $data[3],
        'editor' => $data[4],
        'price' => $data[5],
        'stock' => $data[6],
        'cover' => $data[7],
      ];
  }

  // Read users from a XML file
  $xml = simplexml_load_file('./data/users.xml');
  foreach ($xml->users as $user) 
  {
    $persistent['user'][$user->email] =
    [
      'email' => $user->email,
      'password' => $user->password,
      'firstname' => $user->firstname,
      'lastname' => $user->lastname,
      'gender' => $user->gender,
      'dateofbirth' => $user->dateofbirth
    ];
  }


  $_SESSION['persistent'] = $persistent;
}

function writeUser($user)
{
  if(isset($_SESSION['persistent']['user'][$user['email']]))
  {
    throw new Exception("User already exists", 1);
  }

  $_SESSION['persistent']['user'][$user['email']] = $user;

  $xml = simplexml_load_file('./data/users.xml');

  $xmlUser = $xml->addChild('user');
  $xmlUser->addChild('email', $user['email']);
  $xmlUser->addChild('password', $user['password']);
  $xmlUser->addChild('firstname', $user['firstname']);
  $xmlUser->addChild('lastname', $user['lastname']);
  $xmlUser->addChild('gender', $user['gender']);
  $xmlUser->addChild('dateofbirth', $user['dateofbirth']);

  $xml->asXML('./data/users.xml');
}
