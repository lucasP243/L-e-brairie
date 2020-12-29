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
    $msg = '(' . mysqli_errno($db) . ') Unable to connect to database : ' . mysqli_error($db);
    mysqli_close($db);
    die($msg);
  }

  mysqli_stmt_bind_param($stmt, 'sss', $genre, $author, $editor);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_close($db);

  $products = array();
  if ($result)
  {
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
  }
  mysqli_stmt_close($stmt);
  return $products;
}