<?php if (!isset($_SESSION['user'])) header('Location: ./'); else $user = $_SESSION['user']; ?>
<div class="side">
  <div class="flex vertical identity">
    <h3>Identité</h3>
    <p><?= strtoupper($user['lastname']) ?> <?= ucfirst($user['firstname']) ?></p>
    <p><?= $user['email'] ?></p>
    <p>Né le <?= date('j F Y', strtotime($user['dob'])) ?></p>
  </div>
</div>
<div class="main-body clearfix">
  <section class="content-container">
    <div id="content">
      <div>
        <h2>Votre panier</h2>
        <br/>
        <table id="catalog">
          <thead>
            <tr>
              <th>Ref</th>
              <th>Titre</th>
              <th>Quantité</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($_SESSION['user']['cart'])) { ?>
              <?php foreach ($_SESSION['user']['cart'] as $ref => $quantity) { ?>
                <tr class="product">
                  <td><?= $ref ?></td>
                  <td><?= $_SESSION['persistent']['product'][$ref]['title'] ?></td>
                  <td><?= $quantity ?>&nbsp;
                </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td colspan="3">Votre panier est vide.</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <form action="./?page=checkout">
          <input type="submit" value="Passer la commande" disabled>
        </form>
      </div>
      <div>
        <h3>Historique de commandes</h3>
        <p>A venir...</p>
      </div>
      <a class="btn-link" href="./?page=<?= $page ?>&action=logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Se déconnecter</span>
      </a>
  </section>
</div>
</div>