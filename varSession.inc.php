<?php

$persistent = [
    'product' => array(),
    'user' => array(),
];

// Read products data from a csv-formatted text file
$file = fopen('data/products.txt', 'r') or die('Error: Cannot open user text file.');
while($data = fgetcsv($file, 1000))
{
    // data => 0: id, 1: title, 2: author, 3: category, 4: editor, 5: price, 6: stock, 7: cover
    $persistent['product'][$data[0]] = [
        'title' => $data[1],
        'author' => $data[2],
        'category' => $data[3],
        'editor' => $data[4],
        'price' => $data[5],
        'stock' => $data[6],
        'cover' => $data[7],
    ];
}

// Read users from a JSON file


// Read commands from a XML file


$_SESSION['persistent'] = $persistent;