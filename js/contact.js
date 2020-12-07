document.querySelectorAll('p.radio').forEach(
  (elem) => elem.addEventListener('click',
    (event) => {
      if (event.target.tagName === 'P') {
        event.target.querySelector('input').checked = true;
      }
    }
  )
);
// Form validation
document.getElementById('form_contact').addEventListener("submit", verifyForm);

function verifyForm(event) {
  document.querySelectorAll('input:not([type="radio"]), select, textarea').forEach(
    (input) => {
      if (input.getAttribute('value') == '') {
        return event.preventDefault();
      }
    }
  );
  document.querySelectorAll('input[type="date"]').forEach(
    (input) => {
      if (Date.parse(input.value) === NaN) {
        event.preventDefault();
      }
    }
  );
  var isJobSelected = false;
  document.querySelectorAll('input[name="job"]').forEach(
    (radio) => {
      if (isJobSelected && radio.checked) {
        event.preventDefault();
      } else if (radio.checked) {
        isJobSelected = true;
      }
    }
  )
  if (!isJobSelected) {
    event.preventDefault();
  }
}