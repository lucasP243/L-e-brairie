<?php
$products = $_SESSION['persistent']['product'];
$category = '';
if (isset($_GET['category']))
{
  $category = $_GET['category'];
  $products = array_filter($products, function($value)
  {
    return strcmp(
      strtolower(preg_replace('/[^a-zA-Z]+/', '', iconv('utf-8', 'ASCII//TRANSLIT', $value['category']))), 
      strtolower(preg_replace('/[^a-zA-Z]+/', '', iconv('utf-8', 'ASCII//TRANSLIT', $_GET['category'])))
    ) == 0;
  });
}
?>
<div class="main-body clearfix">
    <!-- Side vertical menu -->
    <nav class="menu side">
      <ul class="flex vertical">
        <li>
          <a class="nav-link center middle <?php if ($category == "roman") echo 'active'; ?>" href="./?category=roman">Roman</a>
        </li>
        <li>
          <a class="nav-link center middle <?php if ($category == "poesie") echo 'active'; ?>" href="./?category=poesie">Poésie</a>
        </li>
        <li>
          <a class="nav-link center middle <?php if ($category == "theatre") echo 'active'; ?>" href="./?category=theatre">Théâtre</a>
        </li>
        <li>
          <a class="nav-link center middle <?php if ($category == "manga") echo 'active'; ?>" href="./?category=manga">Manga</a>
        </li>
      </ul>
    </nav>

    <section class="content-container">
      <div id="content">
        <?php if (count($products) > 0) { ?>
          <h2 class="center">Notre catalogue</h2>
          <div class="catalog-container">
            <table id="catalog">
              <thead>
                <tr>
                  <th>Ref</th>
                  <th>Couverture</th>
                  <th>Titre</th>
                  <th>Auteur</th>
                  <th>&Eacute;diteur</th>
                  <th>Prix</th>
                  <th>Panier</th>
                  <th class="stock">Stock</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach($products as $ref => $product) { ?>
                  <tr class="product">
                    <td class="prod-ref"><?=$ref?></td>
                    <td>
                      <img class="cover" src=<?='./img/' . $product['cover'] . '.jpg'?> alt="title_cover" />
                    </td>
                    <td><a href="#"><?=$product['title']?></a></td>
                    <td><a href="#"><?=$product['author']?></a></td>
                    <td><a href="#"><?=$product['editor']?></a></td>
                    <td><?=$product['price']?>&euro;</td>
                    <td>
                      <p class="cart-ctrl">
                        <i class="fas fa-minus cart-minus"></i>
                        <span class="cart-quantity">0</span>
                        <i class="fas fa-plus cart-plus"></i>
                      </p>
                      <button disabled class="add-cart">Ajouter au panier</button>
                    </td>
                    <td class="stock-quantity"><?=$product['stock']?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <p class="right">
              <a href="javascript:" class="stock-btn" id="show-stock">Afficher les stocks</a>
              <a href="javascript:" class="stock-btn" id="hide-stock">Cacher les stocks</a>
            </p>
          </div>
        <?php } else { ?>
          <h2>Aucun produit trouvé</h2>
        <?php } ?>
      </div>
    </section>
    <script type="text/javascript" src="./js/catalog.js"></script>
  </div>