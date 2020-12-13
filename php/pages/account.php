<?php if (!isset($_SESSION['user'])) header('Location: ./'); else $user = $_SESSION['user']; ?>
<div class="side">
  <div class="flex vertical">
    <h3>Identité</h3>
    <p><?= ['m' => 'Mr. ', 'f' => 'Mme. ', 'o' => ''][$user['gender']] ?><?= strtoupper($user['lastname']) ?> <?= ucfirst($user['firstname']) ?></p>
    <p>Votre adresse e-mail : <?= $user['email'] ?></p>
    <p>Votre date de naissance : <?= date('j F Y', strtotime($user['dateofbirth'])) ?></p>
  </div>
</div>
<div class="main-body clearfix">
  <section class="content-container">
    <div class="content">
      <div>
      <h2>Votre panier</h2>
          <table id="catalog">
            <thead>
              <tr>
                <th>Ref</th>
                <th>Titre</th>
                <th>Quantité</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($_SESSION['user']['cart'] as $ref => $quantity) { ?>
                <tr class="product">
                  <td><?=$ref?></td>
                  <td><?=$_SESSION['persistent']['product'][$ref]['title']?></td>
                  <td><?=$quantity?>&nbsp;
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <form action="./?page=checkout">
            <input type="submit" value="Passer la commande" disabled>
          </form>
        </form>
      </div>
      <div>
        <h3>Historique de commandes</h3>
        <p>A venir...</p>
      </div>
      <a href="./?page=<?= $page ?>&action=logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Se déconnecter</span>
      </a>
  </section>
</div>
</div>