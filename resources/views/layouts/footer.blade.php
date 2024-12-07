<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="footer-info">
                    <img src="{{ asset('img/logo.png') }}" alt="Meals on Wheels Logo" height="40" class="mb-3">
                    <p class="mb-4">Delivering nutritious meals and hope to those in need. Join us in making a difference in our community.</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('donate') }}">Donate</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Get Involved</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('register') }}">Become a Volunteer</a></li>
                    <li><a href="#">Partner With Us</a></li>
                    <li><a href="#">Corporate Sponsorship</a></li>
                    <li><a href="#">Fundraising Events</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 mb-4">
                <h5>Contact Info</h5>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-map-marker-alt me-2"></i>
                        No 4 ThitSar Street, Yangon, Myanmar
                    </li>
                    <li>
                        <i class="fas fa-phone me-2"></i>
                        (959) 456-7890
                    </li>
                    <li>
                        <i class="fas fa-envelope me-2"></i>
                        contact@mealsonwheels.org
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="mt-4 mb-4">
        
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; {{ date('Y') }} Meals on Wheels. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <ul class="footer-bottom-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer> 