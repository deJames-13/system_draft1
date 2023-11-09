var lastChecked = document.getElementById('chkStd');

function cardClicked(card) {
  var id = card.id.split('_')[1];
  window.location.replace('./?item_id=' + id);
}

function addToCart(btn) {
  var el;
  var isquickAdd = false;
  var [name, id] = btn.id.split('_');

  if (btn.id.split('_').length > 1) {
    el = document.getElementById(`setQty_${id}`);
    isquickAdd = true;
  } else {
    el = document.getElementById('setQty');
  }

  var qty = parseInt(el.innerText);

  window.location.replace(
    './cart_add.php?qty=' +
      qty +
      '&isquickAdd=' +
      (isquickAdd ? 1 : 0) +
      '&prodId=' +
      id
  );
  console.log('Added to cart: ', id);
}

function deleteCart(id) {
  console.log('Delete cart: ', id);
  window.location.replace('./cart_delete.php?id=' + id);
}

function updateCart(id) {
  console.log('Update cart: ', id);
  var qty = document.getElementById('setQty_' + id).innerText;
  window.location.replace(`./cart_update.php?id=${id}&qty=${qty}`);
}

function setQty(btn) {
  var [name, id, itemId] = btn.id.split('_');

  if (btn.id.split('_').length > 1) {
    var el = document.getElementById(
      `setQty_${id}${itemId ? '_' + itemId : ''}`
    );
  } else {
    var el = document.getElementById('setQty');
  }

  var qty = parseInt(el.innerText);

  if (name === 'addBtn') {
    qty++;
  } else if (name === 'subBtn' && qty > 1) {
    qty--;
  }

  el.innerText = qty;
}

function swapCardAction(el) {
  var [name, id, itemId] = el.id.split('_');
  var parent = el.parentNode;
  var btns = document.getElementById(
    `qtyBtns_${id}${itemId ? '_' + itemId : ''}`
  );

  if (name === 'btnShow') {
    var actions = parent.nextElementSibling;
  } else if (name === 'btnHideAndUpdate') {
    var actions = parent.previousElementSibling;
    updateCart(id);
  } else if (name === 'btnHide') {
    var actions = parent.previousElementSibling;
  }
  actions.classList.toggle('menu-hidden');
  parent.classList.toggle('menu-hidden');
  btns.classList.toggle('menu-hidden');
}

function toggleModal(btn) {
  var [name, id] = btn.id.split('_');
  var qty = document.getElementById('setQty_' + id).innerText;

  if (name === 'singleOrder') {
    window.location.replace('./?item_id=' + id + '&type=order&qty=' + qty);
  }
}

function setShipMode(el) {
  console.log('clicked');
  var chk = el.firstElementChild;
  var icon = chk.firstElementChild;
  var inp = document.getElementById('shippingType');
  var total = document.getElementById('totalCost');
  var txtTotal = document.getElementById('txtTotal');
  var shippingfee = document.getElementById('shippingfee');
  var subtotal = document.getElementById('subtotal');

  if (el.id === 'std') {
    inp.value = 'Standard';
    total.value = parseInt(subtotal.value) + 300;
    shippingfee.innerText = '₱150';
  } else if (el.id === 'exp') {
    inp.value = 'Express';
    total.value = parseInt(subtotal.value) + 300;
    shippingfee.innerText = '₱300';
  } else if (el.id === 'prt') {
    inp.value = 'Priority';
    total.value = parseInt(subtotal.value) + 500;
    shippingfee.innerText = '₱500';
  }
  txtTotal.innerText = `₱${total.value}`;

  console.log('Total: ', txtTotal.innerText);
  console.log('shippingfee: ', shippingfee.innerText);
  console.log('Total: ', txtTotal.innerText);

  chk.classList.toggle('bg-primary');
  chk.classList.toggle('border-b-2');
  icon.classList.toggle('hidden');

  lastChecked.classList.toggle('bg-primary');
  lastChecked.classList.toggle('border-b-2');
  lastChecked.firstElementChild.classList.toggle('hidden');

  lastChecked = chk;
}

function btnlog(btn) {
  console.log('Clicked from', btn.id);
}
