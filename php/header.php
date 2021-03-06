<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="./img/favicon.png" />
  <title>L'e-brairie : Votre bibliothèque en ligne</title>

  <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
  <!-- Header of homepage. Contains logo, company name and horizontal menu -->
  <header class="flex horizontal clearfix">
    <div class="website_head">
      <a href="./" style="display: flex; align-items: center">
        <img src="./img/icon.png" alt="logo_e-brairie" height="64" style="margin: 0 10px" />
        <h1 class="title">L'e-brairie</h1>
        <span style="margin: 8px 0 0 1em">Votre bibliothèque en ligne</span>
      </a>
    </div>

    <nav class="menu head">
      <ul class="flex horizontal">
        <li><a class="nav-link middle" href="./?category=roman">Roman</a></li>
        <li><a class="nav-link middle" href="./?category=poesie">Poésie</a></li>
        <li><a class="nav-link middle" href="./?category=theatre">Théâtre</a></li>
        <li><a class="nav-link middle" href="./?category=manga">Manga</a></li>
        <li><a class="nav-link middle" href="./?page=contact">Contact</a></li>

        <?php if (isset($_SESSION['user'])) { ?>
          <li>
            <a class="icon-btn account-btn" href="./?page=account" style="margin: 0 5px">
              <div style="font-size: 1.5em;">
                <i class="fas fa-user"></i>
                <i class="fas fa-shopping-basket"></i>
              </div>
              <span class="icon-label">Compte & Panier</span>
            </a>
          </li>
        <?php } else { ?>
          <li>
            <a class="icon-btn login-btn" href="./?page=login" style="margin: 0 5px">
              <i class="fas fa-sign-in-alt"></i>
              <span class="icon-label">Se connecter</span>
            </a>
          </li>
        <?php } ?>
      </ul>
    </nav>
  </header>