<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('partner.profile.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" 
                            value="{{ Auth::user()->partner->company_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Email</label>
                        <input type="email" class="form-control" name="company_email" 
                            value="{{ Auth::user()->partner->company_email }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone" 
                            value="{{ Auth::user()->partner->phone }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" 
                            value="{{ Auth::user()->partner->location }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Business Type</label>
                        <select class="form-select" name="business_type" required>
                            <option value="restaurant" {{ Auth::user()->partner->business_type === 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                            <option value="catering" {{ Auth::user()->partner->business_type === 'catering' ? 'selected' : '' }}>Catering Service</option>
                            <option value="food_bank" {{ Auth::user()->partner->business_type === 'food_bank' ? 'selected' : '' }}>Food Bank</option>
                            <option value="other" {{ Auth::user()->partner->business_type === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Service Offering</label>
                        <textarea class="form-control" name="service_offer" rows="3" required>{{ Auth::user()->partner->service_offer }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div> 