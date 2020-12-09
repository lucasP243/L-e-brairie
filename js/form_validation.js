'use strict';
/**
 * Form validation script
 * Made by : Lucas Pinard
 * 
 * Usage : 
 *  Apply form validation on forms with 'form-validate' class.
 *  All .form-input are wrapped in a .form-input_wrapper span
 *  All .form-input that have any of the following classes will be verified as such :
 *    - form-alphabetical   : allows letters only
 *    - form-numerical    : allows numbers only
 *    - form-decimal      : allows numbers and one point only
 *    - form-alphanum     : allows letters and numbers only
 *    - form-text         : allows letters, spaces, dashes and apostrophes
 *    - form-punctuated   : allows letters, numbers, dashes, apostrophes, points, 
 *                          commas, question & exclamation marks and parentheses
 *    - form-date         : allows ../../.... format with numbers only
 *    - form-email        : allows only email-formatted strings
 *    - form-password     : allows the same characters as form-ponctuated plus slashes
 *                          and backslashes. Needs to be at least n-character long where n 
 *                          is the defined min-length, and needs at least one digit, one 
 *                          lowercase, one uppercase and one punctuation character
 *    - form-confirm-password : needs to be the same as form-password
 * 
 *  In each case, inputs are trimmed before validation.
 *  If the input doesn't match the specified validation case, the corresponding
 *  .form-input_wrapper will have the 'invalid' class added and an explanation
 *  of the problem in its 'invalid-info' attribute.
 */
const form_validation_patterns = {
  'form-alphabetical': '[A-Za-zÀ-ÖØ-öø-ÿ]+',
  'form-numerical': '[0-9]+',
  'form-decimal': '[0-9]+(\\.[0-9]*)?',
  'form-alphanum': '[A-Za-zÀ-ÖØ-öø-ÿ0-9]+',
  'form-text' : '[A-Za-zÀ-ÖØ-öø-ÿ \\-\']+',
  'form-punctuated' : '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \\-\'\\.,\\?!]+',
  'form-date': '', // HTML uses type=date rather than pattern
  'form-email' : '', // HTML uses type=email rather than pattern
  'form-password' : '', // HTML uses type=password rather than pattern
  'form-confirm-password' : ''
}
const form_validation_functions =
{
  'form-alphabetical': function (event, input=event.target) {
    input.value = input.value.trim();
    var illegal = input.value.match(/[^A-Za-zÀ-ÖØ-öø-ÿ]/);
    var car = illegal == null?'':illegal[0];
    updateInput(input.parentNode, illegal == null, 'Caractère interdit : "'+car+'"');
    return illegal == null;
  },
  'form-numerical': function (event, input=event.target) {
    input.value = input.value.trim();
    var illegal = input.value.match(/[^0-9]/);
    var car = illegal == null?'':illegal[0];
    updateInput(input.parentNode, illegal == null, 'Caractère interdit : "'+car+'"');
    return illegal == null;
  },
  'form-decimal': function (event, input=event.target) {
    input.value = input.value.trim();
    var illegal = input.value.match(/[^0-9\.]/);
    if (illegal != null) {
      updateInput(input.parentNode, false, 'Caractère interdit : "'+illegal[0]+'"');
      return false;
    }
    if (input.value.match(/\./).length > 1) {
      updateInput(input.parentNode, false, "Format invalide");
      return false;
    }
    updateInput(input.parentNode, true);
    return true;
  },
  'form-alphanum': function (event, input=event.target) {
    input.value = input.value.trim();
    var illegal = input.value.match(/[^A-Za-zÀ-ÖØ-öø-ÿ0-9]/);
    var car = illegal == null?'':illegal[0];
    updateInput(input.parentNode, illegal == null, 'Caractère interdit : "'+car+'"');
    return illegal == null;
  },
  'form-text': function (event, input=event.target) {
    input.value = input.value.trim();
    var illegal = input.value.match(/[^A-Za-zÀ-ÖØ-öø-ÿ \-']/);
    var car = (illegal == null?'':illegal[0]);
    updateInput(input.parentNode, illegal == null, 'Caractère interdit : "'+car+'"');
    return illegal == null;
  },
  'form-punctuated': function (event, input=event.target) {
    input.value = input.value.trim();
    var illegal = input.value.match(/[^A-Za-zÀ-ÖØ-öø-ÿ \-'\.,\?!]/);
    var car = illegal == null?'':illegal[0];
    updateInput(input.parentNode, illegal == null, 'Caractère interdit : "'+car+'"');
    return illegal == null;
  },
  'form-date': function(event, input=event.target) {
    var isOk = input.value.match(/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/) != null;
    updateInput(input.parentNode, isOk, 'Format invalide');
    return isOk;
  },
  'form-email': function (event, input=event.target) {
    updateInput(input.parentNode, /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(input.value), "Email non conforme");
  },
  'form-password': function (event, input=event.target) {
    if (input.value != input.value.trim()) {
      updateInput(input.parentNode, false, 'Votre mot de passe ne peut pas commencer ou se terminer par un espace.');
      return false;
    }
    var illegal = input.value.match(/[^A-Za-zÀ-ÖØ-öø-ÿ0-9 \-'\.\?!\/\\]/);
    if (illegal != null) {
      updateInput(input.parentNode, false, 'Caractère interdit : "'+illegal[0]+'"');
      return false;
    }
    if (input.value.match(/[A-ZÀ-ÖØ-ß]/) == null) {
      updateInput(input.parentNode, false, 'Le mot de passe doit avoir au moins une majuscule');
      return false;
    }
    if (input.value.match(/[a-zà-öø-ÿ]/) == null) {
      updateInput(input.parentNode, false, 'Le mot de passe doit avoir au moins une minuscule');
      return false;
    }
    if (input.value.match(/[0-9]/) == null) {
      updateInput(input.parentNode, false, 'Le mot de passe doit avoir au moins un chiffre');
      return false;
    }
    if (input.value.match(/[\.,\?!\-'\/\\]/) == null) {
      updateInput(input.parentNode, false, 'Le mot de passe doit avoir au moins un caractère spécial');
      return false;
    }
    updateInput(input.parentNode, true);
    return true;
  },
  'form-confirm-password': function(event, input=event.target) {
    console.log(input.closest('.form-validate').querySelector('.form-password'))
    var isOk = input.value == input.closest('.form-validate').querySelector('.form-password').value;
    updateInput(input.parentNode, isOk, 'Les mots de passe ne correspondent pas');
    return isOk;
  }
};
function updateInput(field, isOk, message='') {
  if (isOk) {
    field.classList.remove('invalid');
    field.removeAttribute('invalid-info');
  }
  else {
    field.classList.add('invalid');
    field.setAttribute('invalid-info', message);
  }
  if (field.closest('.form-validate').querySelectorAll('.invalid').length > 0) {
    field.closest('.form-validate').querySelector('input[type="submit"]').setAttribute('disabled', '');
  }
  else field.closest('.form-validate').querySelector('input[type="submit"]').removeAttribute('disabled');
}
document.querySelectorAll('form.form-validate .form-input').forEach(input => {
  var span = document.createElement('span');
  input.parentNode.replaceChild(span, input);
  span.appendChild(input);
  span.classList.add('form-input_wrapper');

  input.classList.forEach(classname => {
    if (classname in form_validation_functions) {
      if (classname == 'form-email') {
        input.setAttribute('type', 'email');
      }
      else if (classname == 'form-password' || classname == 'form-confirm-password') {
        input.setAttribute('type', 'password');
        if (input.getAttribute('minlength') == null) {
          input.setAttribute('minlength', '8');
        }
      }
      else {
        input.setAttribute('pattern', form_validation_patterns[classname]);
      }
      input.addEventListener('change', form_validation_functions[classname]);
    }
  });
});