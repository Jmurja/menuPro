// Modal Validation Script
document.addEventListener('DOMContentLoaded', function() {
    // Category Form Validation
    const categoryForm = document.getElementById('create-category-form');
    if (categoryForm) {
        const categoryNameInput = document.getElementById('category_name');
        const categoryError = document.querySelector('.category-error');

        categoryNameInput.addEventListener('input', function() {
            validateField(this, categoryError, 'O nome da categoria é obrigatório');
        });

        categoryForm.addEventListener('submit', function(e) {
            if (!validateField(categoryNameInput, categoryError, 'O nome da categoria é obrigatório')) {
                e.preventDefault();
            }
        });
    }

    // Create Menu Item Form Validation
    const createMenuForm = document.getElementById('create-menu-item-form');
    if (createMenuForm) {
        const nameInput = document.getElementById('name');
        const nameError = document.querySelector('.name-error');

        const categoryInput = document.getElementById('category_id');
        const categoryError = document.querySelector('.category-error');

        const priceInput = document.getElementById('price');
        const priceError = document.querySelector('.price-error');

        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');

        if (imageInput) {
            imageInput.addEventListener('change', function() {
                handleImagePreview(this, imagePreview, previewImg);
            });
        }

        // Real-time validation
        if (nameInput) {
            nameInput.addEventListener('input', function() {
                validateField(this, nameError, 'O nome do item é obrigatório');
            });
        }

        if (categoryInput) {
            categoryInput.addEventListener('change', function() {
                validateField(this, categoryError, 'Selecione uma categoria');
            });
        }

        if (priceInput) {
            priceInput.addEventListener('input', function() {
                validatePrice(this, priceError);
                formatCurrency(this);
            });
        }

        // Form submission validation
        createMenuForm.addEventListener('submit', function(e) {
            let isValid = true;

            if (!validateField(nameInput, nameError, 'O nome do item é obrigatório')) {
                isValid = false;
            }

            if (!validateField(categoryInput, categoryError, 'Selecione uma categoria')) {
                isValid = false;
            }

            if (!validatePrice(priceInput, priceError)) {
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Edit Forms Validation (multiple forms with dynamic IDs)
    document.querySelectorAll('form[id^="edit-form-"]').forEach(function(form) {
        const formId = form.id;
        const itemId = formId.split('-').pop();

        const nameInput = document.getElementById(`name-${itemId}`);
        const nameError = document.querySelector(`.name-error-${itemId}`);

        const priceInput = document.getElementById(`price-${itemId}`);
        const priceError = document.querySelector(`.price-error-${itemId}`);

        // Image preview functionality
        const imageInput = document.getElementById(`image-${itemId}`);
        const imagePreview = document.getElementById(`image-preview-${itemId}`);
        const previewImg = document.getElementById(`preview-img-${itemId}`);

        if (imageInput) {
            imageInput.addEventListener('change', function() {
                handleImagePreview(this, imagePreview, previewImg);
            });
        }

        // Real-time validation
        if (nameInput) {
            nameInput.addEventListener('input', function() {
                validateField(this, nameError, 'O nome do item é obrigatório');
            });
        }

        if (priceInput) {
            priceInput.addEventListener('input', function() {
                validatePrice(this, priceError);
                formatCurrency(this);
            });
        }

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;

            if (!validateField(nameInput, nameError, 'O nome do item é obrigatório')) {
                isValid = false;
            }

            if (!validatePrice(priceInput, priceError)) {
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    });

    // Helper Functions
    function validateField(field, errorElement, errorMessage) {
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            errorElement.textContent = errorMessage;
            errorElement.classList.remove('hidden');
            return false;
        } else {
            field.classList.remove('border-red-500');
            errorElement.classList.add('hidden');
            return true;
        }
    }

    function validatePrice(field, errorElement) {
        const value = field.value.trim();
        if (!value) {
            field.classList.add('border-red-500');
            errorElement.textContent = 'O preço é obrigatório';
            errorElement.classList.remove('hidden');
            return false;
        }

        // Remove currency formatting for validation
        const numericValue = value.replace(/[^\d,]/g, '').replace(',', '.');
        if (isNaN(numericValue) || parseFloat(numericValue) <= 0) {
            field.classList.add('border-red-500');
            errorElement.textContent = 'Informe um preço válido maior que zero';
            errorElement.classList.remove('hidden');
            return false;
        } else {
            field.classList.remove('border-red-500');
            errorElement.classList.add('hidden');
            return true;
        }
    }

    function formatCurrency(field) {
        let value = field.value.replace(/\D/g, '');

        if (value === '') return;

        value = (parseInt(value) / 100).toFixed(2);
        value = value.replace('.', ',');
        value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

        field.value = `${value}`;
    }

    function handleImagePreview(input, previewContainer, previewImage) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
});
