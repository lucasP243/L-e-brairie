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
        <form method='POST' action="./?page=account&action=checkout">
          <table id="catalog">
            <thead>
              <tr>
                <th>Ref</th>
                <th>Titre</th>
                <th>Prix</th>
                <th>Quantité</th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($user['cart'])) {
                $cart = array();
                foreach ($user['cart'] as $ref => $quantity) { 
                  $book = getProduct($ref); 
                  $cart[] = array_merge($book, array('quantity' => $quantity));
                  ?>
                  <tr class="product">
                    <td><?= $ref ?></td>
                    <td><?= $book['title'] ?></td>
                    <td><input readonly type="text" style="width: 3.5em;" name="books[<?= $ref ?>][price]" value="<?= $book['price'] ?>">&nbsp;&euro;</td>
                    <td><input readonly type="text" style="width: 3.5em;" name="books[<?= $ref ?>][quantity]" value="<?= $quantity ?>"></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="4">Votre panier est vide.</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <?php if (isset($cart)) { ?>
              <p>Montant total : 
                <?= array_reduce($cart, function($total, $product) { 
                  return $total += $product['price'] * $product['quantity'];
                }); ?>&nbsp;&euro;
              </p>
              <input type="submit" value="Passer la commande">
          <?php } ?>
        </form>
      </div>
      <div>
        <h3>Historique de commandes</h3>
        <?php
        $orders = getOrders($user['id']);
        if (count($orders) > 0) { ?>
          <ul>
            <?php foreach ($orders as $id => $order) { ?>
              <li><span>(#<?=$id?>) <?=$order['date']?></span>: <?=$order['quantity']?> articles commandés (<?=$order['total']?>€)</li>
            <?php } ?>
          </ul>
        <?php } else { ?>
          <span>Rien à afficher ici...</span>
        <?php } ?>
      </div>
      <a class="btn-link" href="./?page=<?= $page ?>&action=logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Se déconnecter</span>
      </a>
  </section>
</div>