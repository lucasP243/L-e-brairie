<?php

function db_connect()
{
  $id = mysqli_connect('localhost', 'root', '', 'lebrairie', 3306);

  if (mysqli_errno($id))
  {
    die('(' . mysqli_errno($id) . ') Unable to connect to database : ' . mysqli_error($id));
  }

  mysqli_query($id, 'SET NAMES utf8');
  mysqli_query($id, 'SET CHARACTER SET utf8');

  return $id;
}

function getProduct($book_id)
{
  $db = db_connect();

  $stmt = mysqli_prepare($db, "SELECT book_id, book_title, book_price FROM book WHERE book_id = ?");
  if (!$stmt)
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to prepare statement : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }

  mysqli_stmt_bind_param($stmt, 'i', $book_id);
  mysqli_stmt_execute($stmt);

  if (!$result = mysqli_stmt_get_result($stmt))
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to fetch result : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }
  mysqli_close($db);

  $book = null;
  if ($row = mysqli_fetch_row($result))
  {
    $book = array(
      'id' => $row[0],
      'title' => $row[1],
      'price' => $row[2]
    );
  }
  mysqli_stmt_close($stmt);
  mysqli_free_result($result);
  return $book;
}

function getProducts($genre='', $author='', $editor='')
{
  $db = db_connect();

  $sql = "SELECT book_id, book_title, book_cover, author_name, editor_name, genre_name, book_price, book_stock
    FROM book 
    INNER JOIN author ON book.author_id = author.author_id
    INNER JOIN editor ON book.editor_id = editor.editor_id
    INNER JOIN genre ON book.genre_id = genre.genre_id
    WHERE genre_name LIKE ?
      AND author_name LIKE ?
      AND editor_name LIKE ?
    ORDER BY genre.genre_id ASC, book_id ASC";
  
  $genre = $genre == '' ? '%' : $genre;
  $author = $author == '' ? '%' : $author;
  $editor = $editor == '' ? '%' : $editor;

  $stmt = mysqli_prepare($db, $sql);
  if (!$stmt)
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to prepare statement : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }

  mysqli_stmt_bind_param($stmt, 'sss', $genre, $author, $editor);
  mysqli_stmt_execute($stmt);

  if (!$result = mysqli_stmt_get_result($stmt))
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to fetch result : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }
  mysqli_close($db);

  $products = array();
  while ($product = mysqli_fetch_row($result))
  {
    $products[$product[0]] = array (
      'title'   => $product[1],
      'cover'   => $product[2],
      'author'  => $product[3],
      'editor'  => $product[4],
      'genre'   => $product[5],
      'price'   => $product[6],
      'stock'   => $product[7]
    );
  }
  mysqli_free_result($result);
  mysqli_stmt_close($stmt);
  return $products;
}

function getUser($email)
{
  $db = db_connect();

  $stmt = mysqli_prepare($db, "SELECT * FROM useraccount WHERE useraccount_email = ?");
  if (!$stmt)
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to prepare statement : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);

  if (!$result = mysqli_stmt_get_result($stmt))
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to fetch result : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }
  mysqli_close($db);

  $logged = null;
  if ($user = mysqli_fetch_row($result))
  {
    $logged = array();
    $logged['id'] = $user[0];
    $logged['email'] = $user[1];
    $logged['firstname'] = $user[3];
    $logged['lastname'] = $user[4];
    $logged['dob'] = $user[5];
    $logged['creation'] = $user[6];
    $logged['lastlogin'] = $user[7];
  }
  mysqli_free_result($result);
  mysqli_stmt_close($stmt);
  return $logged;
}

function connectUser($email, $password)
{
  $db = db_connect();
  $password = md5($password);

  $stmt = mysqli_prepare($db, "SET @email := ?");
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  $stmt = mysqli_prepare($db, "SET @pwd := ?");
  mysqli_stmt_bind_param($stmt, 's', $password);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  $stmt = mysqli_prepare($db, "SELECT login_user(@email, @pwd)");
  if (!$stmt)
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to prepare statement : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }
  mysqli_stmt_execute($stmt);

  if (!$result = mysqli_stmt_get_result($stmt))
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to fetch result : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }
  mysqli_close($db);

  if ($connected = mysqli_fetch_row($result))
  {
    $connected = $connected[0];
  }
  else {
    $connected = false;
  }
  if ($connected)
  {
    $_SESSION['user'] = getUser($email);
  }

  mysqli_free_result($result);
  mysqli_stmt_close($stmt);
  return $connected;
}

function createUser($email, $password, $firstname, $lastname, $dob)
{
  $db = db_connect();
  $password = md5($password);

  $stmt = mysqli_prepare($db, 'INSERT INTO useraccount (
    useraccount_email, 
    useraccount_passwordhash, 
    useraccount_firstname, 
    useraccount_lastname, 
    useraccount_dob,
    useraccount_creation,
    useraccount_lastlogin    
    )
    VALUES (?, ?, ?, ?, ?, NOW(), NOW())'
  );
  if (!$stmt)
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to prepare statement : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }

  mysqli_stmt_bind_param($stmt, 'sssss', $email, $password, $firstname, $lastname, $dob);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  if (mysqli_insert_id($db))
  {
    $user = getUser($email);
  }
  return null;
}

function createOrder($user_id, $books)
{
  $db = db_connect();

  $totalamount = array_reduce($books, function($total, $book) { 
    return $total += $book['price'] * $book['quantity'];
  });

  $stmt = mysqli_prepare($db, 'INSERT INTO receipt(receipt_date, useraccount_id, receipt_totalamount) VALUES (NOW(), ?, ?)');
  if (!$stmt)
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to prepare statement : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }

  mysqli_stmt_bind_param($stmt, 'sd', $user_id, $totalamount);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  if ($receipt_id = mysqli_insert_id($db))
  {
    foreach($books as $book_id => $book)
    {
      $stmt = mysqli_prepare($db, 'INSERT INTO in_order VALUES (?, ?, ?)');
      if (!$stmt)
      {
        $msg = '(' . mysqli_errno($db) . ') Unable to prepare statement : ' . mysqli_error($db);
        mysqli_close($db);
        die($msg);
      }
      mysqli_stmt_bind_param($stmt, 'iid', $receipt_id, $book_id, $book['quantity']);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
  }

  mysqli_close($db);
}

function getOrders($user_id)
{
  $db = db_connect();

  $stmt = mysqli_prepare($db, "SELECT receipt.*, COUNT(book_id) FROM receipt JOIN in_order USING(receipt_id) WHERE useraccount_id = ?");
  if (!$stmt)
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to prepare statement : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }
  mysqli_stmt_bind_param($stmt, 's', $user_id);
  mysqli_stmt_execute($stmt);

  if (!$result = mysqli_stmt_get_result($stmt))
  {
    $msg = '(' . mysqli_errno($db) . ') Unable to fetch result : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }
  mysqli_close($db);

  $orders = array();
  while ($order = mysqli_fetch_row($result))
  {
    $orders[$order[0]] = array (
      'date'   => $order[1],
      'total'   => $order[2],
      'quantity'  => $order[4]
    );
  }
  mysqli_free_result($result);
  mysqli_stmt_close($stmt);
  return $orders;
  
}