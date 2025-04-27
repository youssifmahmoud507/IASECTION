
document.addEventListener('DOMContentLoaded', function() {
    // Available products for adding to cart
    const availableProducts = [
        { id: 3, name: 'Gaming Headset', price: 120, image: '/api/placeholder/80/80' },
        { id: 4, name: 'Mechanical Keyboard', price: 180, image: '/api/placeholder/80/80' },
        { id: 5, name: 'Gaming Mouse', price: 85, image: '/api/placeholder/80/80' },
        { id: 6, name: 'SSD 1TB', price: 250, image: '/api/placeholder/80/80' },
        { id: 7, name: 'RAM 16GB', price: 130, image: '/api/placeholder/80/80' },
        { id: 8, name: 'Graphics Card', price: 799, image: '/api/placeholder/80/80' }
    ];
    
    // Populate product grid in modal
    const productGrid = document.getElementById('productGrid');
    availableProducts.forEach(product => {
        const productCard = document.createElement('div');
        productCard.className = 'product-card';
        productCard.dataset.id = product.id;
        productCard.dataset.name = product.name;
        productCard.dataset.price = product.price;
        productCard.dataset.image = product.image;
        
        productCard.innerHTML = `
            <img src="${product.image}" alt="${product.name}">
            <div class="product-card-title">${product.name}</div>
            <div class="product-card-price">$${product.price}</div>
        `;
        
        productCard.addEventListener('click', function() {
            addProductToCart(product);
            document.getElementById('productModal').style.display = 'none';
        });
        
        productGrid.appendChild(productCard);
    });
    
    // Show modal when clicking "Add Products" button
    document.getElementById('addProductBtn').addEventListener('click', function() {
        document.getElementById('productModal').style.display = 'flex';
    });
    
    // Close modal when clicking close button
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('productModal').style.display = 'none';
    });
    
    // Close modal when clicking outside content
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('productModal')) {
            document.getElementById('productModal').style.display = 'none';
        }
    });
    
    // Add product to cart
    function addProductToCart(product) {
        const cartItems = document.getElementById('cartItems');
        const addProductRow = document.querySelector('.add-product-row');
        
        // Check if product already exists in cart
        const existingRow = document.querySelector(`tr[data-id="${product.id}"]`);
        if (existingRow) {
            // If exists, increase quantity
            const quantityInput = existingRow.querySelector('.quantity-input');
            let currentQty = parseInt(quantityInput.value);
            quantityInput.value = String(currentQty + 1).padStart(2, '0');
            
            // Update subtotal
            const subtotalCell = existingRow.querySelector('.item-subtotal');
            subtotalCell.textContent = '$' + (product.price * (currentQty + 1));
        } else {
            // Create new row
            const newRow = document.createElement('tr');
            newRow.dataset.id = product.id;
            newRow.dataset.price = product.price;
            
            newRow.innerHTML = `
                <td>
                    <div class="product-info">
                        <button class="remove-item">×</button>
                        <img src="${product.image}" alt="${product.name}" class="product-img">
                        <span class="product-name">${product.name}</span>
                    </div>
                </td>
                <td class="item-price">$${product.price}</td>
                <td>
                    <div class="quantity-selector">
                        <button class="quantity-btn decrease">−</button>
                        <input type="text" value="01" class="quantity-input" data-price="${product.price}">
                        <button class="quantity-btn increase">+</button>
                    </div>
                </td>
                <td class="item-subtotal">$${product.price}</td>
            `;
            
            // Insert before the "Add Product" row
            cartItems.insertBefore(newRow, addProductRow);
            
            // Add event listeners to new elements
            const removeBtn = newRow.querySelector('.remove-item');
            removeBtn.addEventListener('click', function() {
                newRow.remove();
                calculateTotal();
            });
            
            const decreaseBtn = newRow.querySelector('.decrease');
            decreaseBtn.addEventListener('click', function() {
                decreaseQuantity(this);
            });
            
            const increaseBtn = newRow.querySelector('.increase');
            increaseBtn.addEventListener('click', function() {
                increaseQuantity(this);
            });
        }
        
        // Update totals
        calculateTotal();
    }
    
    // Functions for quantity buttons
    function decreaseQuantity(btn) {
        const input = btn.nextElementSibling;
        let value = parseInt(input.value);
        if (value > 1) {
            value--;
            input.value = String(value).padStart(2, '0');
            updateRowSubtotal(btn);
            calculateTotal();
        }
    }
    
    function increaseQuantity(btn) {
        const input = btn.previousElementSibling;
        let value = parseInt(input.value);
        value++;
        input.value = String(value).padStart(2, '0');
        updateRowSubtotal(btn);
        calculateTotal();
    }
    
    // Update individual row subtotal
    function updateRowSubtotal(element) {
        const row = element.closest('tr');
        const quantityInput = row.querySelector('.quantity-input');
        const price = parseFloat(quantityInput.dataset.price);
        const quantity = parseInt(quantityInput.value);
        const subtotal = price * quantity;
        
        const subtotalCell = row.querySelector('.item-subtotal');
        subtotalCell.textContent = '$' + subtotal;
    }
    
    // Calculate total for entire cart
    function calculateTotal() {
        let subtotal = 0;
        
        // Sum up all item subtotals
        document.querySelectorAll('#cartItems tr:not(.add-product-row)').forEach(row => {
            const quantity = parseInt(row.querySelector('.quantity-input').value);
            const price = parseFloat(row.dataset.price);
            subtotal += price * quantity;
        });
        
        // Update display
        document.getElementById('subtotalValue').textContent = '$' + subtotal;
        document.getElementById('totalValue').textContent = '$' + subtotal;
    }
    
    // Initial setup of event listeners for existing elements
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('tr').remove();
            calculateTotal();
        });
    });
    
    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            decreaseQuantity(this);
        });
    });
    
    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', function() {
            increaseQuantity(this);
        });
    });
    
    // Update cart button
    document.getElementById('updateCartBtn').addEventListener('click', function() {
        calculateTotal();
        alert('Cart updated successfully!');
    });
    
    // Initial calculation
    calculateTotal();
});
