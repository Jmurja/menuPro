document.addEventListener('DOMContentLoaded', function() {
    // Format currency input for discount_price
    const discountPriceInput = document.getElementById('discount_price');
    if (discountPriceInput) {
        // Format initial value if it exists
        if (discountPriceInput.value) {
            discountPriceInput.value = formatCurrency(discountPriceInput.value);
        }

        discountPriceInput.addEventListener('input', function(e) {
            let value = e.target.value;

            // Remove all non-numeric characters except decimal point
            value = value.replace(/[^\d,\.]/g, '');

            // Replace comma with dot for calculation
            value = value.replace(',', '.');

            // Format the value
            if (value) {
                e.target.value = formatCurrency(value);
            }
        });

        // When form is submitted, convert to proper format for backend
        discountPriceInput.form.addEventListener('submit', function() {
            if (discountPriceInput.value) {
                // Convert formatted value back to number with dot as decimal separator
                discountPriceInput.value = discountPriceInput.value
                    .replace(/[^\d,\.]/g, '')
                    .replace('.', '')
                    .replace(',', '.');
            }
        });
    }

    // Handle discount type selection
    const discountPercentageInput = document.getElementById('discount_percentage');

    if (discountPriceInput && discountPercentageInput) {
        discountPriceInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                discountPercentageInput.value = '';
            }
        });

        discountPercentageInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                discountPriceInput.value = '';
            }
        });
    }

    // Validate date ranges
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            if (endDateInput.value && new Date(startDateInput.value) > new Date(endDateInput.value)) {
                endDateInput.value = startDateInput.value;
            }

            // Set min date for end date
            endDateInput.min = startDateInput.value;
        });

        // Set initial min date for end date
        if (startDateInput.value) {
            endDateInput.min = startDateInput.value;
        }
    }
});

// Helper function to format currency
function formatCurrency(value) {
    // Convert to number and fix to 2 decimal places
    const numValue = parseFloat(value);
    if (isNaN(numValue)) return '';

    // Format with Brazilian currency format (comma as decimal separator)
    return numValue.toFixed(2).replace('.', ',');
}
