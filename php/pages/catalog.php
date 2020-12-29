<?php
$category = $_GET['category'] ?? '';
$author = $_GET['author'] ?? '';
$editor = $_GET['editor'] ?? '';
$products = getProducts($category, $author, $editor);
if (isset($_POST['ref']))
{
  if (!isset($_SESSION['user']))
  {
    header("Location: ./?page=login");
  }
  else if ($_POST['quantity'] == '0')
  {
    unset($_SESSION['user']['cart'][$_POST['ref']]);
  }
  else
  {
    $_SESSION['user']['cart'][$_POST['ref']] = $_POST['quantity'];
  }
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
                  <form id="form_product<?=$ref?>" action="#" method="post" enctype="application/x-www-form-urlencoded">
                    <tr class="product">
                      <td class="prod-ref"><input readonly type="text" name="ref" value="<?=$ref?>" size="5"></td>
                      <td>
                        <img class="cover" src=<?='./img/' . $product['cover'] . '.jpg'?> alt="title_cover" />
                      </td>
                      <td><a href="#"><?=$product['title']?></a></td>
                      <td><a href="./?page=catalog&author=<?=urlencode($product['author'])?>"><?=$product['author']?></a></td>
                      <td><a href="./?page=catalog&editor=<?=urlencode($product['editor'])?>"><?=$product['editor']?></a></td>
                      <td><?=$product['price']?>&euro;</td>
                      <td>
                        <p class="cart-ctrl">
                          <i class="fas fa-minus cart-minus"></i>
                          <input readonly type="text" name="quantity" value="<?=$_SESSION['user']['cart'][$ref] ?? 0?>" class="cart-quantity">
                          <i class="fas fa-plus cart-plus"></i>
                        </p>
                        <input type="submit" value="&#xf217" incart="<?=$_SESSION['user']['cart'][$ref] ?? 0?>" disabled class="fas fa-cart-plus add-cart">
                      </td>
                      <td class="stock-quantity"><?=$product['stock']?></td>
                    </tr>
                  </form>
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