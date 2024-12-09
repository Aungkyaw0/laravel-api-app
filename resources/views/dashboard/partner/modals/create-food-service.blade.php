<div class="modal fade" id="createFoodServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Food Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createFoodServiceForm" action="{{ route('partner.food-services.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Service Name</label>
                        <input type="text" class="form-control" name="service_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cuisine Type</label>
                        <input type="text" class="form-control" name="cuisine_type" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Service Area</label>
                        <input type="text" class="form-control" name="service_area" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Operating Hours</label>
                        <input type="text" class="form-control" name="operating_hours[]" placeholder="e.g., Monday-Friday: 9am-5pm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Food Safety Certification</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="food_safety_certified" id="food_safety_certified" value="1">
                            <label class="form-check-label" for="food_safety_certified">Certified for Food Safety</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Safety Inspection Date</label>
                        <input type="date" class="form-control" name="last_inspection_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Safety Procedures</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="safety_procedures[]" value="temperature_monitoring">
                            <label class="form-check-label">Temperature Monitoring</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="safety_procedures[]" value="sanitization">
                            <label class="form-check-label">Regular Sanitization</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="safety_procedures[]" value="storage">
                            <label class="form-check-label">Proper Storage Practices</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Food Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>