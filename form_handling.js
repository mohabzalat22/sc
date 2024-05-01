const productTypeSelect = document.getElementById("productType");
const productTypeSections = document.getElementsByClassName("productTypeSection");
const descriptionLabel = document.querySelector("label[for='description']");
const productForm = document.getElementById("product_form");
const inputElements = productForm.querySelectorAll("input[required], select[required]");

function hideAllSections() {
  Array.from(productTypeSections).forEach(section => {
    section.style.display = "none";
  });
}

hideAllSections();

productTypeSelect.addEventListener("change", () => {
  const selectedType = productTypeSelect.value;

  hideAllSections();

  const selectedSection = document.getElementById(selectedType);
  if (selectedSection) {
    selectedSection.style.display = "block";

    const typeMappings = {
      DVD: "Please provide the size in MB",
      Furniture: "Please provide dimensions in H*W*L format",
      Book: "Please provide weight in KG",
    };

    descriptionLabel.innerText = typeMappings[selectedType] || "kindly choose your product type";
  }
});

productForm.addEventListener("submit", (event) => {
  let isFormValid = true;

  inputElements.forEach((inputElement) => {
    if (!inputElement.value) {
      isFormValid = false;
      inputElement.classList.add("error");
    } else {
      inputElement.classList.remove("error");
    }
  });

  if (!isFormValid) {
    event.preventDefault();
    alert("Please submit required data.");
  }
});
