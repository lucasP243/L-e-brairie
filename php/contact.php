<?php
function processForm()
{
  if (!isset($_POST['gender']) || !preg_match('/(m|f|o)/', $_POST['gender'])) {
    return 'Genre incorrect';
  }
  if (!isset($_POST['lastname']) || !preg_match('/[a-zA-Z \'-]+/', $_POST['lastname'])) {
    return 'Nom de famille incorrect';
  }
  if (!isset($_POST['firstname']) || !preg_match('/[a-zA-Z \'-]+/', $_POST['firstname'])) {
    return 'Prénom incorrect';
  }
  if (!isset($_POST['dob']) || !date_parse($_POST['dob'])) {
    return 'Date de naissance incorrecte';
  }
  if (!isset($_POST['job']) || !in_array($_POST['job'], ['libraire', 'fournisseur', 'clientpro', 'clientpart'])) {
    return 'Profession incorrecte';
  }
  if (!isset($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
    return 'E-mail incorrect';
  }
  if (!isset($_POST['subject']) || !filter_var($_POST['subject'], FILTER_SANITIZE_SPECIAL_CHARS)) {
    return 'Object incorrect';
  }
  if (!isset($_POST['body']) || !filter_var($_POST['body'], FILTER_SANITIZE_SPECIAL_CHARS)) {
    return 'Message incorrect';
  } else {
    return mail(
      'lucas.pinard@outlook.com',
      'L\'e-brairie contact client',
      'Envoyé le ' . date('d/M/Y à H:i') . '
      De : ' . ['m' => 'Mr. ', 'f' => 'Mme. ', 'o' => ''][$_POST['gender']] . $_POST['lastname'] . ' ' . $_POST['firstname'] . '
      Né le : ' . $_POST['dob'] . '
      Rôle : ' . $_POST['job'] . '
      Sujet : ' . $_POST['subject'] . '
      ' . $_POST['body']
    ) ? 'Message envoyé' : 'Erreur interne';
  }
}

if (isset($_POST['submit'])) {
  echo '<script>alert("' . processForm() . '");</script>';
}
?>
<div class="main-body clearfix">
  <section class="content-container">
    <div id="content">
      <h2>Nous contacter</h2>
      <form id="form_contact" class="form-validate" action="./?page=contact" method="post" enctype="application/x-www-form-urlencoded">
        <div class="form-section contact_identity">
          <span>Identité :</span>
          <select class="form-input" name="gender" required>
            <option value="m">Mr.</option>
            <option value="f">Mme.</option>
            <option value="o">Autre</option>
          </select>
          <input class="form-input form-text" type="text" name="lastname" placeholder="Nom" required style="text-transform: uppercase;">
          <input class="form-input form-text" type="text" name="firstname" placeholder="Prénom" required style="text-transform: capitalize;">
          <label for="dob">Né le&nbsp;<input class="form-input form-date" type="date" name="dob" required></label>
        </div>
        <div class="form-section contact_creditentials">
          <label for="mail">E-mail :</label>
          <input class="form-input form-email" type="email" name="mail" placeholder="xyz@example.com" required>
        </div>
        <div class="form-section contact_job">
          <label for="job">Vous êtes :</label>
          <p class="radio"><input type="radio" name="job" value="libraire" required>&nbsp;Libraire</p>
          <p class="radio"><input type="radio" name="job" value="fournisseur">&nbsp;Fournisseur</p>
          <p class="radio"><input type="radio" name="job" value="clientpro">&nbsp;Client professionnel</p>
          <p class="radio"><input type="radio" name="job" value="clientpart">&nbsp;Client particulier</p>
        </div>
        <div class="form-section contact_message">
          <div>
            <label for="subject">Sujet :</label>
            <input class="form-input form-text" type="text" name="subject" placeholder="Sujet" required>
          </div>
          <textarea name="body" placeholder="Votre message ici..." rows="10" maxlength="2000" required></textarea>
        </div>
        <input type="submit" name="submit" value="Envoyer">
      </form>
    </div>
  </section>
</div>
<script type="text/javascript" src="./js/form_validation.js"></script>
<script type="text/javascript">
  document.querySelectorAll('p.radio').forEach(
    (elem) => elem.addEventListener('click',
      (event) => {
        if (event.target.tagName === 'P') {
          event.target.querySelector('input').checked = true;
        }
      }
    )
  );
</script>