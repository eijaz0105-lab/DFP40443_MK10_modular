document.addEventListener('DOMContentLoaded', function () {
    const quantityInputs = document.querySelectorAll('.qty-input');
    const totalPriceEl = document.getElementById('total-price');
    const form = document.querySelector('form');

    if (!quantityInputs.length || !totalPriceEl || !form) {
        return;
    }

    function calculateTotal() {
        let total = 0;

        quantityInputs.forEach(input => {
            let quantity = parseInt(input.value, 10);
            if (isNaN(quantity) || quantity < 0) {
                quantity = 0;
            }

            const price = parseFloat(input.dataset.price) || 0;
            if (quantity > 0) {
                total += quantity * price;
            }
        });

        const formatter = new Intl.NumberFormat('ms-MY', {
            style: 'currency',
            currency: 'MYR'
        });

        totalPriceEl.textContent = formatter.format(total);
    }

    quantityInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);

        input.addEventListener('blur', function () {
            const value = parseFloat(this.value);

            if (!isNaN(value) && value > 0) {
                this.value = Math.round(value);
            } else {
                this.value = 0;
            }

            calculateTotal();
        });
    });

    form.addEventListener('submit', function (e) {
        let total = 0;

        quantityInputs.forEach(input => {
            let quantity = parseInt(input.value, 10);
            const price = parseFloat(input.dataset.price) || 0;

            if (!isNaN(quantity) && quantity > 0) {
                total += quantity * price;
            }
        });

        if (total === 0) {
            e.preventDefault();
            alert('Sila pilih sekurang-kurangnya satu jenis biskut sebelum meneruskan tempahan.');
        }
    });

    calculateTotal();
});