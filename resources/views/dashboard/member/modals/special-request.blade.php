<!-- Special Request Modal -->
<div class="modal fade" id="specialRequestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Special Dietary Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('member.special-request') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">New Dietary Requirement</label>
                        <select class="form-select" name="new_dietary_requirement" required>
                            <option value="">Select Dietary Requirement</option>
                            <option value="none">No Special Requirements</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                            <option value="halal">Halal</option>
                            <option value="gluten-free">Gluten Free</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Meal Preference</label>
                        <select class="form-select" name="new_prefer_meal" required>
                            <option value="">Select Meal Preference</option>
                            <option value="hot">Hot Meals</option>
                            <option value="frozen">Frozen Meals</option>
                            <option value="both">Both Hot & Frozen</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for Change</label>
                        <textarea class="form-control" name="reason" rows="3" 
                            placeholder="Please explain why you need to change your dietary requirements..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Additional Notes</label>
                        <textarea class="form-control" name="additional_notes" rows="2" 
                            placeholder="Any additional information we should know..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div> 