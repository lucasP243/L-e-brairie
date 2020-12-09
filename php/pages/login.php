<!-- TODO: add form sanitizing server-side -->
<?php 
  $user = null;
  if (isset($_POST['login']))
  {
    $mail = $_POST['mail'];
    $pwd = md5($_POST['pwd']);

    if (isset($_SESSION['persistent']['user'][$mail]) && $_SESSION['persistent']['user'][$mail]['password'] == $pwd)
    {
      $user = $_SESSION['persistent']['user'][$mail];
    }
    else
    {
      $user = null;
      $error = "Email ou mot de passe incorrect.";
    }
  }
  if (isset($_POST['register']))
  {
    if ($_POST['pwd'] == $_POST['pwd2'])
    {
      $user = [
        'email' => $_POST['mail'],
        'password' => md5($_POST['pwd']),
        'dateofbirth' => $_POST['dob'],
        'gender' => $_POST['gender'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname']
      ];
      try
      {
        writeUser($user);
      } 
      catch (\Throwable $th)
      {
        $user = null;
        $error = "Cette adresse email existe déjà.";
      }
    }
    else
    {
      $user = null;
      $error = 'Les mots de passe ne correspondent pas.';
    }
  }
  if ($user != null)
  {
    $_SESSION['user'] = $user;
    header('Location: ./');
  }
?>
<div class="main-body clearfix">
  <div class="tab-group">
    <div class="tab">
      <button class="tab-link" value="login">Se connecter</button>
      <button class="tab-link" value="register">S'inscrire</button>
    </div>
    <div class="login tab-content">
      <form id="form_login" class="form-validate" action="./?page=login" method="post" enctype="application/x-www-form-urlencoded">
        <div class="form-section contact_creditentials">
          <label for="mail">E-mail :</label>
          <input class="form-input form-email" type="email" name="mail" placeholder="xyz@example.com" required style="width: 100%;">
          <label for="pwd">Mot de passe :</label>
          <input class="form-input form-password" type="password" name="pwd" required style="width: 100%;">
        </div>
        <input type="submit" name="login" value="Se connecter" style="width: 100%;">
      </form>
    </div>
    <div class="register tab-content">
      <form id="form_register" class="form-validate" action="./?page=login" method="post" enctype="application/x-www-form-urlencoded">
        <div class="form-section contact_identity">
          <p style="white-space: nowrap;">
            <span style="width: 20%;">Identité :</span>
            <select class="form-input" name="gender" required style="width: 10%;">
              <option value="m">Mr.</option>
              <option value="f">Mme.</option>
              <option value="o">Autre</option>
            </select>
            <input class="form-input form-text" type="text" name="lastname" placeholder="Nom" required style="width: 35%; text-transform: uppercase;">
            <input class="form-input form-text" type="text" name="firstname" placeholder="Prénom" required style="width: 35%; text-transform: capitalize;">
          </p>
          <label for="dob">Né le&nbsp;<input class="form-input form-date" type="date" name="dob" required></label>
        </div>
        <div class="form-section contact_creditentials">
          <label for="mail">E-mail :</label>
          <input class="form-input form-email" type="email" name="mail" placeholder="xyz@example.com" required>
          <label for="pwd">Mot de passe :</label>
          <input class="form-input form-password" type="password" name="pwd" required>
          <label for="pwd2">Confirmer le mot de passe :</label>
          <input class="form-input form-confirm-password" type="password" name="pwd2" required>
        </div>
        <input type="submit" name="register" value="Créer votre compte" style="width: 100%;">
      </form>
    </div>
    <?php if (isset($error)) echo('<p class="error">'.$error.'</p>'); ?>
  </div>
</div>
<script type="text/javascript" src="./js/form_validation.js"></script>
<script type="text/javascript">
  document.querySelectorAll('.tab-link').forEach(element => {
    element.addEventListener('click', event => {
      document.querySelectorAll('.tab-link').forEach(btn => {
        btn.className = btn.className.replace(' active', '');
      });
      event.target.className += ' active';
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
      });
      document.querySelector('.tab-content.' + event.target.getAttribute('value')).style.display = 'block';

      // On change category, hide error
      document.querySelector('p.error').style.display = 'none';
    });
  });

  <?php if (isset($_POST['register'])) { ?>
    document.querySelector('.tab-link[value="register"]').className += ' active';
    document.querySelector('.tab-content.register').style.display = "block";
  <?php } else { ?>
    document.querySelector('.tab-link[value="login"]').className += ' active';
    document.querySelector('.tab-content.login').style.display = "block";
  <?php } ?>
</script>