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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Food Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>