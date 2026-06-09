/* Main JavaScript - Laptop Store */

/**
 * Add to cart - Server-side only (session-based)
 * This function is deprecated. Use server-side cart operations instead.
 */
function addToCart(productId, quantity = 1) {
    // Redirect to server-side cart add operation
    console.warn('addToCart is deprecated. Use server-side cart operations.');
    showNotification('Vui lòng sử dụng form thêm vào giỏ hàng', 'warning');
}

/**
 * Remove from cart - Server-side only (session-based)
 * This function is deprecated. Use server-side cart operations instead.
 */
function removeFromCart(productId) {
    // Redirect to server-side cart remove operation
    console.warn('removeFromCart is deprecated. Use server-side cart operations.');
    showNotification('Vui lòng sử dụng nút xóa trên trang giỏ hàng', 'warning');
}

/**
 * Get cart count - Server-side only (session-based)
 * This function is deprecated. Cart is managed server-side.
 */
function getCartCount() {
    // Cart is managed server-side via session
    console.warn('getCartCount is deprecated. Cart is managed server-side.');
    return 0;
}

/**
 * Clear cart - Server-side only (session-based)
 * This function is deprecated. Use server-side cart operations instead.
 */
function clearCart() {
    console.warn('clearCart is deprecated. Cart is managed server-side.');
    showNotification('Giỏ hàng được quản lý bởi server', 'info');
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 300px;
        animation: slideIn 0.3s ease-in-out;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

/**
 * Format price
 */
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(price);
}

/**
 * Validate email
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Show loading
 */
function showLoading() {
    const loader = document.createElement('div');
    loader.id = 'loader';
    loader.innerHTML = '<div style="text-align: center; padding: 2rem;">Đang xử lý...</div>';
    document.body.appendChild(loader);
}

/**
 * Hide loading
 */
function hideLoading() {
    const loader = document.getElementById('loader');
    if (loader) loader.remove();
}

/**
 * Debounce function
 */
function debounce(func, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

/**
 * Toggle password visibility
 */
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = '🙈';
    } else {
        input.type = 'password';
        button.textContent = '👁️';
    }
}

/**
 * Document ready
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize
    console.log('Application loaded');
});

/**
 * Add animation styles
 */
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
