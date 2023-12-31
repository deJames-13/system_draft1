var lastChecked = document.getElementsByClassName('chkChecked')[0];
var checkOut = [];

// LOGIN PAGE
function showPassword(btn) {
  var parent = btn.parentNode;
  var input = parent.firstElementChild;
  var show_icon = input.nextElementSibling;
  var hide_icon = show_icon.nextElementSibling;

  if (btn.id === 'showIcon') {
    input.type = 'text';
  }
  if (btn.id === 'hideIcon') {
    input.type = 'password';
  }

  show_icon.classList.toggle('hidden');
  hide_icon.classList.toggle('hidden');
}
// ####################

// ####################
// CARD PAGE
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
function checkCart(btn) {
  var [name, id] = btn.id.split('_');
  var chkOutBtn = document.getElementById('btnCheckOut');

  btn.classList.toggle('bg-primary');

  if (!checkOut.find((item) => item === id)) {
    checkOut.push(id);
  } else {
    checkOut = checkOut.filter((item) => item !== id);
  }
  if (
    (checkOut.length == 1 && chkOutBtn.classList.contains('hidden')) ||
    checkOut.length == 0
  ) {
    chkOutBtn.classList.toggle('hidden');
  }
}
function checkOutCart(btn) {
  var [name, id] = btn.id.split();
  if (checkOut.length > 0) {
    var ids = checkOut.join(',');
    window.location.replace('./?page=cart&ids=' + ids);
  }
}
// ####################
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
// ####################

// ####################
// ORDER PAGE
function manageOrder(btn) {
  var [name, id, item_id] = btn.name.split('_');

  console.log('Clicked from', btn.name);

  if (name == 'btnDeleteOrder') {
    window.location.replace('./order_delete.php?id=' + id);
  } else if (name == 'btnUpdateOrder') {
    window.location.replace('./order_update.php?id=' + id);
  } else if (name == 'btnUpdateOrderItem') {
    var qty = document.getElementById('setQty_' + id + '_' + item_id).innerText;
    var sub = document.getElementById('txtPrc_' + id + '_' + item_id).innerText;
    var cost = parseInt(sub) * parseInt(qty);
    var tax_cost = cost * 0.12;
    var total = parseInt(cost) + parseInt(tax_cost);

    console.log('sub: ', sub);
    console.log('redirecting to: ', './order_updateitem');
    window.location.replace(
      './order_update.php?id=' +
        id +
        '&type=item' +
        '&item=' +
        item_id +
        '&qty=' +
        qty +
        '&sub=' +
        total
    );
  } else if (name == 'btnDeleteOrderItem') {
    window.location.replace(
      './order_delete.php?id=' + id + '&type=item' + '&item=' + item_id
    );
  }
}
// ####################

// ####################
// SET QUANTITY
function setQty(btn) {
  var [name, id, itemId] = btn.id.split('_');
  console.log('btn: ', btn.id);

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
// ####################

// ####################
// MODAL FOR TRANSACTIONS
function toggleModal(btn) {
  var [name, id] = btn.id.split('_');
  var qty = document.getElementById('setQty_' + id).innerText;

  if (name === 'singleOrder') {
    window.location.replace('./?item_id=' + id + '&type=order&qty=' + qty);
  }
}

// SHIP MODE
function setShipMode(el) {
  // console.log('clicked: ', el.id);
  // console.log('clicked: ', lastChecked);
  var chk = el.firstElementChild;
  var icon = chk.firstElementChild;
  var inp = document.getElementById('shippingType');
  var total = document.getElementById('totalCost');
  var txtTotal = document.getElementById('txtTotal');
  var shippingfee = document.getElementById('shippingfee');
  var subtotal = document.getElementById('accsubtotal');

  if (el.id === 'std') {
    inp.value = 'Standard';
    total.value = parseInt(subtotal.innerText) + 150.0;
    shippingfee.innerText = '150';
  } else if (el.id === 'exp') {
    inp.value = 'Express';
    total.value = parseInt(subtotal.innerText) + 300.0;
    shippingfee.innerText = '300';
  } else if (el.id === 'prt') {
    inp.value = 'Priority';
    total.value = parseInt(subtotal.innerText) + 500.0;
    shippingfee.innerText = '500';
  }
  txtTotal.innerText = total.value;

  chk.classList.toggle('chkChecked');
  chk.classList.toggle('bg-primary');
  chk.classList.toggle('border-b-2');
  icon.classList.toggle('hidden');
  lastChecked.classList.toggle('chkChecked');
  lastChecked.classList.toggle('bg-primary');
  lastChecked.classList.toggle('border-b-2');
  lastChecked.firstElementChild.classList.toggle('hidden');
  lastChecked = chk;
}
// ####################

function btnlog(btn) {
  console.log('Clicked from', btn.id);
}

// ####################
// ALERT MODALS
function showModal(btn) {
  var modal = document.getElementById('alert_modal');
  if (btn.name == 'closeModal') {
    window.location.replace(window.location.href.split('res')[0]);
    return;
  }
  modal.classList.toggle('hidden');
  var content = document.getElementById('modal-content');
}
// ####################

// ####################
// ADMIN TABLES
var previous = null;
function rowClicked(row) {
  var [name, id] = row.id.split('_');
  var el = document.getElementById(`selectedItemId`);

  if (previous != null) {
    previous.classList.toggle('bg-primary30');
    previous.classList.toggle('bg-border-2');
  }
  row.classList.toggle('bg-primary30');

  previous = row;
  el.innerText = id;
}

function btnActionsClicked(btn) {
  var [name, page] = btn.name.split('_');
  var id = document.getElementById('selectedItemId').innerText;
  id = parseInt(id);
  var status = document.getElementById('orders_status_' + id) ?? null;
  var status = status ? status.innerText.toLowerCase() : null;

  if (name == 'create') {
    window.location.replace(`./?page=${page}&mode=create`);
  } else if (name == 'delete' && id) {
    window.location.replace(`./?page=${page}&res=deleteconfirm&id=${id}`);
  } else if (name == 'view') {
    window.location.replace(`./?page=${page}&id=${id}&mode=view`);
  } else if (name == 'ordership' && id && status == 'pending') {
    window.location.replace(
      `./?page=${page}&res=confirmordership&order_id=${id}`
    );
  } else if (name == 'orderdeliver' && id && status == 'shipping') {
    window.location.replace(
      `./?page=${page}&res=confirmorderdeliver&order_id=${id}`
    );
  } else if (name == 'ordercancel' && id && status == 'pending') {
    window.location.replace(
      `./?page=${page}&res=confirmordercancel&order_id=${id}`
    );
  } else if (id) {
    window.location.replace(`./?page=${page}&id=${id}&mode=edit`);
  }
}

function updateOrderStatus(type, id) {
  if (type == 'delete') {
    window.location.replace('./orders/delete.php?id=' + id);
  } else {
    window.location.replace('./orders/update.php?status=' + type + '&id=' + id);
  }
}

// IMAGE DYNAMIC LOADING
function handleFileSelect(event) {
  const files = event.target.files;

  document.getElementById('imageDisplay').innerHTML = '';

  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    const reader = new FileReader();

    reader.onload = function (e) {
      const imgElement = document.createElement('img');
      imgElement.src = e.target.result;
      imgElement.alt = file.name;
      imgElement.className =
        ' object-contain h-full w-full hover:scale[.95] transform transition-all box-border';

      document.getElementById('imageDisplay').appendChild(imgElement);
    };

    reader.readAsDataURL(file);
  }
}
var swiper = new Swiper('.swiper-container', {
  slidesPerView: 1,
  spaceBetween: 10,
  navigation: {},
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  autoplay: {
    delay: 1000,
  },
});

// ####################
// age
function onBirthdateChange(date) {
  var age = calculateAge(date.value);
  document.getElementById('age').value = age;
}

function calculateAge(birthdate) {
  var today = new Date();
  var birthDate = new Date(birthdate);
  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;

  return age;
}

// ####################

// ============================== SEARCH ============================== //

function searchFunction() {
  // Get the input value
  var inputValue = document.getElementById('searchInput').value;
  console.log('Search for: ' + inputValue);

  var pageValue = getPageParameter();

  console.log("Value of 'page' parameter:", pageValue);
  handlePage(pageValue, inputValue);
}

// Handle Search which Tab
function handlePage(pageValue, inputValue) {
  switch (pageValue) {
    case 'inventory':
      window.location.replace('./?page=inventory&search=' + inputValue);
      break;
    case 'employees':
      window.location.replace('./?page=employees&search=' + inputValue);
      break;

    case 'orders':
      window.location.replace('./?page=orders&search=' + inputValue);
      break;

    case 'employees':
      break;

    case 'payroll':
      window.location.replace('./?page=payroll&search=' + inputValue);
      break;

    default: // Products to?
      window.location.replace('./?search=' + inputValue);
      break;
  }
}

// Get Parameter From Url
function getPageParameter() {
  var searchParams = new URLSearchParams(window.location.search);
  var pageValue = searchParams.get('page');

  // Remove trailing ampersand if present
  if (pageValue && pageValue.endsWith('&')) {
    pageValue = pageValue.slice(0, -1);
  }

  return pageValue;
}

// Dunamic Form Validation

// password length validation,  < 8 = tooshort, > 15 = toolong
function validatePasswordLength(event) {
  event.preventDefault();

  console.log('asda');
  var password = document.getElementById('password').value;
  var passwordLength = password.length;
  const submitButton = document.getElementById('btnSubmit');

  if (passwordLength < 8) {
    document.getElementById('passwordLength').innerHTML =
      'Password is too short';
    document.getElementById('passwordLength').style.color = 'red';
    submitButton.disabled = true;
    submitButton.style.opacity = 0.5;
  } else if (passwordLength > 15) {
    document.getElementById('passwordLength').innerHTML =
      'Password is too long';
    document.getElementById('passwordLength').style.color = 'red';
    submitButton.style.opacity = 0.5;
    submitButton.disabled = true;
  } else {
    document.getElementById('passwordLength').innerHTML = '';
    document.getElementById('passwordLength').style.color = 'gray';
    submitButton.style.opacity = 1;
    submitButton.disabled = false;
  }
}
