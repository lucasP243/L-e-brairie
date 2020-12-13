"use strict";

window.onload = function () {

  // Add listeners on show/hide stock
  document.getElementById('show-stock').addEventListener('click', () => {
    for (var i = 0, els = document.querySelectorAll('.stock, .stock-quantity'); i < els.length; i++) {
      els[i].style.display = 'table-cell';
    }
    document.getElementById('show-stock').style.display = 'none';
    document.getElementById('hide-stock').style.display = 'inline';
  });
  document.getElementById('hide-stock').addEventListener('click', () => {
    for (var i = 0, els = document.querySelectorAll('.stock, .stock-quantity'); i < els.length; i++) {
      els[i].style.display = 'none';
    }
    document.getElementById('show-stock').style.display = 'inline';
    document.getElementById('hide-stock').style.display = 'none';
  });
  document.getElementById('hide-stock').dispatchEvent(new Event('click'));

  // Add listeners on plus/minus cart
  function updateCart(row, isPlus) {
    var cart = row.querySelector('.cart-quantity');
    var stock = parseInt(row.querySelector('.stock-quantity').textContent);
    var button = row.querySelector('.add-cart');
    var quantity = parseInt(cart.value);

    if (isPlus ? quantity < stock : quantity > 0) {
      cart.value = quantity + (isPlus ? 1 : -1);
    }
    if (cart.value == button.getAttribute("incart"))
    {
      button.setAttribute('disabled', '');
    }
    else
    {
      button.removeAttribute('disabled');
    }
  }
  for (var i = 0, rows = document.getElementsByClassName('product'); i < rows.length; i++) {
    rows[i].querySelector('.cart-plus').addEventListener('click', updateCart.bind(null, rows[i], true));
    rows[i].querySelector('.cart-minus').addEventListener('click', updateCart.bind(null, rows[i], false));
  }
};