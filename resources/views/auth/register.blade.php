@extends('layouts.app')

@section('title', 'Sign Up - Meals on Wheels')

@section('styles')
<style>
    .register-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("img/register-hero.png") }}');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: white;
        
    }

    .user-type-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        border: 2px solid transparent;
    }

    .user-type-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        border-color: var(--primary-color);
    }

    .user-type-icon {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .registration-form {
        display: none;
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-top: 30px;
    }

    .form-control {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
    }

    .btn-register {
        padding: 12px 30px;
        font-size: 1.1rem;
    }

    .back-button {
        cursor: pointer;
        color: var(--primary-color);
        display: none;
        margin-bottom: 20px;
    }

    .back-button:hover {
        color: var(--secondary-color);
    }

    .spinner-border {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    .btn:disabled {
        cursor: not-allowed;
        opacity: 0.7;
    }

    .alert {
        margin-bottom: 20px;
    }

    .alert-dismissible .btn-close {
        padding: 0.5rem 0.5rem;
    }

    .field-error {
        font-size: 0.875rem;
        margin-top: -15px;
        margin-bottom: 15px;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .form-control.is-valid {
        border-color: #198754;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .password-strength {
        margin-top: -15px;
        margin-bottom: 15px;
    }

    .password-strength .progress {
        height: 5px;
        margin-bottom: 5px;
    }

    .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .form-control.is-invalid ~ .invalid-feedback {
        display: block;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="register-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8 pt-5">
                    <h1 class="mb-4">Join Our Community</h1>
                    <p class="lead">Choose your role and become part of our mission to serve the community</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Section -->
    <section class="py-5">
        <div class="container">
            <!-- User Type Selection -->
            <div class="row g-4" id="userTypeSelection">
                <div class="col-md-3">
                    <div class="user-type-card" onclick="showRegistrationForm('member')">
                        <i class="fas fa-user user-type-icon"></i>
                        <h3>Member</h3>
                        <p class="text-muted">Register to receive meal services</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="user-type-card" onclick="showRegistrationForm('caregiver')">
                        <i class="fas fa-hands-helping user-type-icon"></i>
                        <h3>Caregiver</h3>
                        <p class="text-muted">Help manage member care</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="user-type-card" onclick="showRegistrationForm('partner')">
                        <i class="fas fa-store user-type-icon"></i>
                        <h3>Partner</h3>
                        <p class="text-muted">Provide food services</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="user-type-card" onclick="showRegistrationForm('volunteer')">
                        <i class="fas fa-hand-holding-heart user-type-icon"></i>
                        <h3>Volunteer</h3>
                        <p class="text-muted">Join our delivery team</p>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="back-button" onclick="showUserTypeSelection()">
                <i class="fas fa-arrow-left"></i> Back to User Type Selection
            </div>

            <!-- Registration Forms -->
            {{-- Member Registeration --}}
            <div id="memberForm" class="registration-form">
                <h2 class="text-center mb-4">Member Registration</h2>
                <form action="{{ route('registers.member') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="address" placeholder="Full Address" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <button type="button" class="btn btn-secondary w-100" onclick="getGeolocation()">
                                <i class="fas fa-map-marker-alt"></i> Get My Location
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="number" class="form-control" name="latitude" id="latitude" 
                                       step="any" placeholder="Latitude" min="-90" max="90">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="number" class="form-control" name="longitude" id="longitude" 
                                       step="any" placeholder="Longitude" min="-180" max="180">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" name="dietary_requirement" required>
                                <option value="">Select Dietary Requirement</option>
                                <option value="none">None</option>
                                <option value="vegetarian">Vegetarian</option>
                                <option value="vegan">Vegan</option>
                                <option value="halal">Halal</option>
                                <option value="gluten-free">Gluten-Free</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="prefer_meal" required>
                                <option value="">Preferred Meal Type</option>
                                <option value="hot">Hot Meals</option>
                                <option value="frozen">Frozen Meals</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-register w-100">Register as Member</button>
                </form>
            </div>

            <!-- Caregiver Registration Form -->
            <div id="caregiverForm" class="registration-form">
                <h2 class="text-center mb-4">Caregiver Registration</h2>
                <form action="{{ route('registers.caregiver') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" name="age" placeholder="Age" required min="18">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="location" placeholder="Location" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" name="availability" required>
                                <option value="">Select Availability</option>
                                <option value="full-time">Full Time</option>
                                <option value="part-time">Part Time</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="experience" placeholder="Years of Experience" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-register w-100">Register as Caregiver</button>
                </form>
            </div>

            <!-- Partner Registration Form -->
            <div id="partnerForm" class="registration-form">
                <h2 class="text-center mb-4">Partner Registration</h2>
                <form action="{{ route('registers.partner') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="company_name" placeholder="Company Name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" name="company_email" placeholder="Company Email" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="location" placeholder="Location" required>
                        </div>
                    </div>
                    {{-- Geo --}}
                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <button type="button" class="btn btn-secondary w-100" onclick="getGeolocation()">
                                <i class="fas fa-map-marker-alt"></i> Get My Location
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="number" class="form-control" name="latitude" id="latitude" 
                                       step="any" placeholder="Latitude" min="-90" max="90">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="number" class="form-control" name="longitude" id="longitude" 
                                       step="any" placeholder="Longitude" min="-180" max="180">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    {{-- Bs --}}
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" name="business_type" required>
                                <option value="">Select Business Type</option>
                                <option value="restaurant">Restaurant</option>
                                <option value="catering">Catering Service</option>
                                <option value="food_service">Food Service</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="service_offer" placeholder="Service Offered" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-register w-100">Register as Partner</button>
                </form>
            </div>

            <!-- Volunteer Registration Form -->
            <div id="volunteerForm" class="registration-form">
                <h2 class="text-center mb-4">Volunteer Registration</h2>
                <form action="{{ route('registers.volunteer') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="address" placeholder="Address" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="emergency_contact" placeholder="Emergency Contact Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" class="form-control" name="emergency_phone" placeholder="Emergency Contact Phone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="has_vehicle" id="hasVehicle" value="1">
                                <label class="form-check-label" for="hasVehicle">
                                    I have a vehicle for deliveries
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="vehicleDetails" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="vehicle_type" placeholder="Vehicle Type">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="license_number" placeholder="License Number">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-register w-100">Register as Volunteer</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
function showRegistrationForm(userType) {
    // Hide user type selection
    document.getElementById('userTypeSelection').style.display = 'none';
    
    // Show back button
    document.querySelector('.back-button').style.display = 'block';
    
    // Hide all forms first
    document.querySelectorAll('.registration-form').forEach(form => {
        form.style.display = 'none';
    });
    
    // Show selected form
    document.getElementById(userType + 'Form').style.display = 'block';
}

function showUserTypeSelection() {
    // Show user type selection
    document.getElementById('userTypeSelection').style.display = 'flex';
    
    // Hide back button
    document.querySelector('.back-button').style.display = 'none';
    
    // Hide all forms
    document.querySelectorAll('.registration-form').forEach(form => {
        form.style.display = 'none';
    });
}

// Form validation and submission handling
document.querySelectorAll('.registration-form form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validate all fields
        let isValid = true;
        form.querySelectorAll('input, select').forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });

        if (!isValid) {
            showError(form, 'Please correct the errors before submitting.');
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerText;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData  // Keep as FormData, don't convert to JSON
            });

            const result = await response.json();
            console.log('Response:', result); // Add this for debugging

            if (result.success) {
                // Show success message
                showSuccess(result.message);
                
                // Redirect after delay
                setTimeout(() => {
                    window.location.href = result.redirect;
                }, 2000);
            } else {
                // Show validation errors
                if (result.errors) {
                    Object.keys(result.errors).forEach(key => {
                        const field = form.querySelector(`[name="${key}"]`);
                        if (field) {
                            field.classList.add('is-invalid');
                            // Remove existing error message if any
                            const existingError = field.parentNode.querySelector('.invalid-feedback');
                            if (existingError) {
                                existingError.remove();
                            }
                            // Add new error message
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.style.display = 'block';
                            errorDiv.textContent = result.errors[key][0];
                            field.parentNode.appendChild(errorDiv);
                        }
                    });
                }
                showError(form, result.message || 'Registration failed. Please check your inputs.');
            }
        } catch (error) {
            console.error('Error:', error);
            showError(form, 'An error occurred. Please try again.');
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerText = originalText;
        }
    });
});

// Add these helper functions if not already present
function showSuccess(message) {
    // Create success alert
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show';
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Find the form container and insert alert at the top
    const form = document.querySelector('.active-form');
    if (form) {
        form.insertAdjacentElement('beforebegin', alertDiv);
    }

    // Redirect after delay
    setTimeout(() => {
        window.location.href = '/login';
    }, 2000);
}

function showError(form, message) {
    // Create error alert
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Insert alert at the top of the form
    form.insertAdjacentElement('beforebegin', alertDiv);
}

document.querySelectorAll('input[name="password"]').forEach(passwordInput => {
    const strengthMeter = document.createElement('div');
    strengthMeter.className = 'password-strength mt-1';
    passwordInput.parentNode.appendChild(strengthMeter);

    passwordInput.addEventListener('input', function() {
        const strength = checkPasswordStrength(this.value);
        updatePasswordStrengthIndicator(strengthMeter, strength);
    });
});

function checkPasswordStrength(password) {
    let strength = 0;
    const feedback = [];

    // Length check
    if (password.length < 8) {
        feedback.push('At least 8 characters');
    } else {
        strength += 1;
    }

    // Uppercase check
    if (!/[A-Z]/.test(password)) {
        feedback.push('At least one uppercase letter');
    } else {
        strength += 1;
    }

    // Lowercase check
    if (!/[a-z]/.test(password)) {
        feedback.push('At least one lowercase letter');
    } else {
        strength += 1;
    }

    // Number check
    if (!/[0-9]/.test(password)) {
        feedback.push('At least one number');
    } else {
        strength += 1;
    }

    // Special character check
    if (!/[^A-Za-z0-9]/.test(password)) {
        feedback.push('At least one special character');
    } else {
        strength += 1;
    }

    return {
        score: strength,
        feedback: feedback
    };
}

function updatePasswordStrengthIndicator(meter, strength) {
    let strengthText = '';
    let strengthClass = '';

    switch (strength.score) {
        case 0:
            strengthText = 'Very Weak';
            strengthClass = 'bg-danger';
            break;
        case 1:
            strengthText = 'Weak';
            strengthClass = 'bg-warning';
            break;
        case 2:
            strengthText = 'Fair';
            strengthClass = 'bg-info';
            break;
        case 3:
            strengthText = 'Good';
            strengthClass = 'bg-primary';
            break;
        case 4:
        case 5:
            strengthText = 'Strong';
            strengthClass = 'bg-success';
            break;
    }

    meter.innerHTML = `
        <div class="progress" style="height: 5px;">
            <div class="progress-bar ${strengthClass}" style="width: ${(strength.score / 5) * 100}%"></div>
        </div>
        <small class="text-muted d-block mt-1">${strengthText}</small>
        ${strength.feedback.length > 0 ? 
            `<small class="text-danger d-block">Required: ${strength.feedback.join(', ')}</small>` : 
            ''}
    `;
}

document.querySelectorAll('.registration-form form').forEach(form => {
    // Add validation for each input
    form.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });

        field.addEventListener('input', function() {
            // Remove error when user starts typing
            const errorDiv = this.parentNode.querySelector('.field-error');
            if (errorDiv) {
                errorDiv.remove();
            }
            this.classList.remove('is-invalid');
        });
    });
});

function validateField(field) {
    let isValid = true;
    let errorMessage = '';

    // Remove existing error
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }

    // Required field validation
    if (field.required && !field.value.trim()) {
        isValid = false;
        errorMessage = 'This field is required';
    }

    // Email validation
    if (field.type === 'email' && field.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(field.value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address';
        }
    }

    // Phone validation
    if (field.name === 'phone' && field.value) {
        const phoneRegex = /^\+?[\d\s-]{10,}$/;
        if (!phoneRegex.test(field.value)) {
            isValid = false;
            errorMessage = 'Please enter a valid phone number';
        }
    }

    // Password validation
    if (field.name === 'password' && field.value) {
        const strength = checkPasswordStrength(field.value);
        if (strength.score < 3) {
            isValid = false;
            errorMessage = 'Password is too weak';
        }
    }

    // Password confirmation validation
    if (field.name === 'password_confirmation') {
        const password = field.closest('form').querySelector('input[name="password"]');
        if (field.value !== password.value) {
            isValid = false;
            errorMessage = 'Passwords do not match';
        }
    }

    // Update field styling
    if (!isValid) {
        field.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error text-danger small mt-1';
        errorDiv.textContent = errorMessage;
        field.parentNode.appendChild(errorDiv);
    } else {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
    }

    return isValid;
}

// Add this JavaScript to handle the vehicle details visibility
document.getElementById('hasVehicle').addEventListener('change', function() {
    const vehicleDetails = document.getElementById('vehicleDetails');
    vehicleDetails.style.display = this.checked ? 'block' : 'none';
    
    // Clear vehicle fields when unchecked
    if (!this.checked) {
        document.querySelector('input[name="vehicle_type"]').value = '';
        document.querySelector('input[name="license_number"]').value = '';
    }
});

// Add this function inside the existing scripts section
function getGeolocation() {
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser');
        return;
    }

    // Find the active form's location button and inputs
    const activeForm = document.querySelector('.registration-form[style*="display: block"]');
    const locationButton = activeForm.querySelector('button[onclick="getGeolocation()"]');
    const latitudeInput = activeForm.querySelector('#latitude');
    const longitudeInput = activeForm.querySelector('#longitude');

    const originalText = locationButton.innerHTML;
    locationButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Getting Location...';
    locationButton.disabled = true;

    navigator.geolocation.getCurrentPosition(
        // Success callback
        (position) => {
            latitudeInput.value = position.coords.latitude;
            longitudeInput.value = position.coords.longitude;
            
            // Reset button
            locationButton.innerHTML = originalText;
            locationButton.disabled = false;
            
            // Add visual feedback
            const feedbackDiv = document.createElement('div');
            feedbackDiv.className = 'alert alert-success alert-dismissible fade show mt-2';
            feedbackDiv.innerHTML = `
                Location successfully obtained!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            locationButton.parentNode.appendChild(feedbackDiv);
        },
        // Error callback
        (error) => {
            let errorMessage;
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "Location access was denied. Please enable location access in your browser settings.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "Location information is unavailable.";
                    break;
                case error.TIMEOUT:
                    errorMessage = "The request to get user location timed out.";
                    break;
                default:
                    errorMessage = "An unknown error occurred.";
                    break;
            }
            alert(errorMessage);
            locationButton.innerHTML = originalText;
            locationButton.disabled = false;
        }
    );
}
</script>
@endsection 