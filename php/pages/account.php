<?php if (!isset($_SESSION['user'])) header('Location: ./'); else $user = $_SESSION['user']; ?>
<div class="main-body clearfix">
  <section class="content-container">
    <div class="content">
      <h2>Votre compte</h2>
      <div>
        <h3>Identité</h3>
        <p><?= ['m' => 'Mr. ', 'f' => 'Mme. ', 'o' => ''][$user['gender']] ?><?= strtoupper($user['lastname']) ?> <?= ucfirst($user['firstname']) ?></p>
        <p>Votre adresse e-mail : <?= $user['email'] ?></p>
        <p>Votre date de naissance : <?= date('j F Y', strtotime($user['dateofbirth'])) ?></p>
      </div>
      <div>
        <h3>Historique de commandes</h3>
        <p>A venir...</p>
      </div>
      <a href="./?page=<?=$page?>&action=logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Se déconnecter</span>
      </a>
  </section>
</div>
</div>