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
    var quantity = parseInt(cart.textContent);

    if (isPlus ? quantity < stock : quantity > 0) {
      cart.textContent = quantity + (isPlus ? 1 : -1);
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

  // Ajax calls for adding item to cart
  function addCart(row) {
    var ref = row.querySelector('.ref').textContent;
    var quantity = parseInt(row.querySelector('.cart-quantity').textContent);
    row.querySelector('.add-cart').setAttribute('disabled', true);
    var request;
    if (window.XMLHttpRequest)
      request = new XMLHttpRequest();
    else if(window.ActiveXObject) {
      try {
        request = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        request = new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    else {
      alert('XMLHttpRequest not supported.');
    }
    request.open('POST', '/php/ajax/addcart.php', true);
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.onreadystatechange = function () {
      if(request.readyState === 4 && request.status === 401) {
        window.location.href = '/?page=login';
      }
    };
    request.send(`ref=${ref}&quantity=${quantity}`);
  }

  for (var i = 0, rows = document.getElementsByClassName('product'); i < rows.length; i++) {
    rows[i].querySelector('.cart-plus').addEventListener('click', updateCart.bind(null, rows[i], true));
    rows[i].querySelector('.cart-minus').addEventListener('click', updateCart.bind(null, rows[i], false));
    rows[i].querySelector('.add-cart').addEventListener('click', addCart.bind(null, rows[i]));
  }
};