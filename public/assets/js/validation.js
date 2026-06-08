/* Form Validation - Laptop Store */

/**
 * Validate form
 */
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('input, textarea, select');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!validateInput(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

/**
 * Validate single input
 */
function validateInput(input) {
    const value = input.value.trim();
    const type = input.type;
    const name = input.name;
    const required = input.hasAttribute('required');
    
    // Clear previous error
    const errorElement = document.getElementById(`${name}_error`);
    if (errorElement) {
        errorElement.remove();
    }
    input.style.borderColor = '';
    
    // Required validation
    if (required && !value) {
        showError(input, 'Trường này không được để trống');
        return false;
    }
    
    // Email validation
    if (type === 'email' && value && !isValidEmail(value)) {
        showError(input, 'Email không hợp lệ');
        return false;
    }
    
    // Password validation
    if (type === 'password' && value && value.length < 6) {
        showError(input, 'Mật khẩu phải ít nhất 6 ký tự');
        return false;
    }
    
    // Phone validation
    if (input.getAttribute('data-type') === 'phone' && value && !isValidPhone(value)) {
        showError(input, 'Số điện thoại không hợp lệ');
        return false;
    }
    
    // Number validation
    if (type === 'number' && value && isNaN(value)) {
        showError(input, 'Vui lòng nhập số hợp lệ');
        return false;
    }
    
    // Min length
    const minLength = input.getAttribute('data-min-length');
    if (minLength && value && value.length < minLength) {
        showError(input, `Tối thiểu ${minLength} ký tự`);
        return false;
    }
    
    // Max length
    const maxLength = input.getAttribute('data-max-length');
    if (maxLength && value && value.length > maxLength) {
        showError(input, `Tối đa ${maxLength} ký tự`);
        return false;
    }
    
    return true;
}

/**
 * Show error message
 */
function showError(input, message) {
    input.style.borderColor = '#e74c3c';
    
    const errorElement = document.createElement('small');
    errorElement.id = `${input.name}_error`;
    errorElement.style.cssText = 'color: #e74c3c; display: block; margin-top: 0.25rem;';
    errorElement.textContent = message;
    
    input.parentNode.insertBefore(errorElement, input.nextSibling);
}

/**
 * Validate email
 */
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Validate phone
 */
function isValidPhone(phone) {
    const re = /^(\+84|0)[0-9]{9,10}$/;
    return re.test(phone.replace(/\s/g, ''));
}

/**
 * Compare passwords
 */
function comparePasswords(password1, password2) {
    const pass1 = document.getElementById(password1).value;
    const pass2 = document.getElementById(password2).value;
    
    if (pass1 !== pass2) {
        showError(document.getElementById(password2), 'Mật khẩu không khớp');
        return false;
    }
    
    return true;
}

/**
 * Real-time validation
 */
function setupRealTimeValidation() {
    const inputs = document.querySelectorAll('input[required], textarea[required], select[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateInput(this);
        });
        
        input.addEventListener('input', function() {
            if (this.style.borderColor) {
                validateInput(this);
            }
        });
    });
}

/**
 * Document ready
 */
document.addEventListener('DOMContentLoaded', function() {
    setupRealTimeValidation();
    
    // Form submission
    const forms = document.querySelectorAll('form:not(.no-validate)');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Skip validation if form has no id
            if (!this.id) return;
            
            if (!validateForm(this.id)) {
                e.preventDefault();
                showNotification('Vui lòng kiểm tra lại form', 'error');
            }
        });
    });
});
