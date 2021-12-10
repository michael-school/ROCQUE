var shopModal = document.getElementById('shopModal');
shopModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget;

  // Extract info from data-bs-* attributes
  var name = button.getAttribute('data-bs-product');
  var desc = button.getAttribute('data-bs-description');
  var price = button.getAttribute('data-bs-price');
  var image = button.getAttribute('data-bs-image');
  var id = button.getAttribute('data-bs-id');
  var max = button.getAttribute('data-bs-max');

  // Update the modal's content.
  var modalTitle = shopModal.querySelector('.modal-title');
  var modalBody = shopModal.querySelector('.modal-body p');
  var modalImage = shopModal.querySelector('.modal-content img');
  var modalPrice = shopModal.querySelector('.modal-footer p');
  var modalAddToCart = shopModal.querySelector('.modal-footer .btn-primary');
  var productIdInput = shopModal.querySelector('.modal-footer input:nth-of-type(1)');
  var quantityInput = shopModal.querySelector('.modal-footer input:nth-of-type(3)');


  modalTitle.textContent = name;
  modalBody.textContent = desc;
  modalImage.setAttribute('src', 'img/products/' + image);
  modalPrice.textContent = price;

  //set max of 'quantity' to however much is left in the inventory
  quantityInput.setAttribute('max', max);
  //set the product id
  productIdInput.setAttribute('value', id);

  //if out of stock, disable 'add to cart' button
  if (price === 'Out of Stock') {
    modalAddToCart.setAttribute('disabled', 'disabled');
  } else {
    modalAddToCart.removeAttribute('disabled');
  }
})
