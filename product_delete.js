function deleteSelectedProducts() {
  var checkboxes = document.querySelectorAll('input[name="delete[]"]:checked');
  var typeboxes = document.querySelectorAll('input[name="type[]"]:checked');

  var selectedProducts = [];
  var typeboxesProducts = [];

  for (var i = 0; i < checkboxes.length; i++) {
    selectedProducts.push(checkboxes[i].value);
    typeboxesProducts.push(typeboxes[i].value);


  }

  if (selectedProducts.length > 0) {
    window.location.href = 'product_delete.php?skus=' + JSON.stringify(selectedProducts);
  } else {
    alert("Please select at least one product to delete.");
  }
}

