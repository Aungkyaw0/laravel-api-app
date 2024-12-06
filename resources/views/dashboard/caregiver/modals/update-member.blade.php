<!-- Update Member Modal -->
<div class="modal fade" id="updateMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Member Needs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Dietary Requirements</label>
                        <select class="form-select" name="dietary_requirement" required>
                            <option value="">Select Requirement</option>
                            <option value="regular">Regular Diet</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                            <option value="gluten_free">Gluten Free</option>
                            <option value="diabetic">Diabetic</option>
                            <option value="low_sodium">Low Sodium</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meal Type Preference</label>
                        <select class="form-select" name="meal_type" required>
                            <option value="">Select Meal Type</option>
                            <option value="hot">Hot Meals</option>
                            <option value="frozen">Frozen Meals</option>
                            <option value="both">Both Types</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Frequency</label>
                        <select class="form-select" name="delivery_frequency" required>
                            <option value="">Select Frequency</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Notes</label>
                        <textarea class="form-control" name="delivery_notes" rows="2" 
                            placeholder="Special delivery instructions..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Health Conditions</label>
                        <textarea class="form-control" name="health_conditions" rows="2" 
                            placeholder="Relevant health conditions..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control" name="emergency_contact" 
                            placeholder="Name and phone number">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Member</button>
                </div>
            </form>
        </div>
    </div>
</div> 