<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="/ai/Kemet/css/cart.css"></head>
<body>
    <header>
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Cart</li>
            </ul>
        </div>
    </header>
    
    <section class="cart-section">
        <div class="container">
            <div class="cart-layout">
                <div class="cart-main">


                
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                            <tr data-id="1" data-price="650">
                                <td>
                                    <div class="product-info">
                                        <button class="remove-item">×</button>
                                        <img src="/api/placeholder/80/80" alt="LCD Monitor" class="product-img">
                                        <span class="product-name">LCD Monitor</span>
                                    </div>
                                </td>
                                <td class="item-price">$650</td>
                                <td>
                                    <div class="quantity-selector">
                                        <button class="quantity-btn decrease">−</button>
                                        <input type="text" value="01" class="quantity-input" data-price="650">
                                        <button class="quantity-btn increase">+</button>
                                    </div>
                                </td>
                                <td class="item-subtotal">$650</td>
                            </tr>
                            <tr data-id="2" data-price="550">
                                <td>
                                    <div class="product-info">
                                        <button class="remove-item">×</button>
                                        <img src="/api/placeholder/80/80" alt="H1 Gamepad" class="product-img">
                                        <span class="product-name">H1 Gamepad</span>
                                    </div>
                                </td>
                                <td class="item-price">$550</td>
                                <td>
                                    <div class="quantity-selector">
                                        <button class="quantity-btn decrease">−</button>
                                        <input type="text" value="02" class="quantity-input" data-price="550">
                                        <button class="quantity-btn increase">+</button>
                                    </div>
                                </td>
                                <td class="item-subtotal">$1100</td>
                            </tr>
                            <!-- Add Product Row -->
                            <tr class="add-product-row">
                                <td colspan="4" class="add-product-cell">
                                    <button class="add-product-btn" id="addProductBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                                        </svg>
                                        Add More Products
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="cart-actions">
                        <button class="btn">Return To Shop</button>
                        <button class="btn" id="updateCartBtn">Update Cart</button>
                    </div>
                    
                    <div class="coupon-form">
                        <input type="text" placeholder="Coupon Code" class="coupon-input">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
                
                <div class="cart-sidebar">
                    <div class="cart-summary">
                        <h2 class="cart-total-title">Cart Total</h2>
                        <div class="cart-total-row">
                            <span class="cart-total-label">Subtotal:</span>
                            <span class="cart-total-value" id="subtotalValue">$1750</span>
                        </div>
                        <div class="cart-total-row">
                            <span class="cart-total-label">Shipping:</span>
                            <span class="cart-total-value">Free</span>
                        </div>
                        <div class="cart-total-row">
                            <span class="cart-total-label">Total:</span>
                            <span class="cart-total-value" id="totalValue">$1750</span>
                        </div>
                        <button class="btn btn-primary checkout-btn">Proceed to checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Product Selection Modal -->
    <div class="product-modal" id="productModal">
        <div class="modal-content">
            <span class="modal-close" id="closeModal">&times;</span>
            <h2 class="modal-title">Select Products</h2>
            <div class="product-grid" id="productGrid">
                <!-- Product items will be added dynamically -->
            </div>
        </div>
    </div>
    <script src="../cart.js"></script>

</body>
</html>