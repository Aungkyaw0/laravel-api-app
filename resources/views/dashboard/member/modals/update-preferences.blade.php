<!-- Update Preferences Modal -->
<div class="modal fade" id="updatePreferencesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Meal Preferences</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('member.update-preferences') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Preferred Meal Type</label>
                        <select class="form-select" name="prefer_meal">
                            <option value="hot" {{ Auth::user()->member->prefer_meal == 'hot' ? 'selected' : '' }}>Hot Meals</option>
                            <option value="frozen" {{ Auth::user()->member->prefer_meal == 'frozen' ? 'selected' : '' }}>Frozen Meals</option>
                            <option value="both" {{ Auth::user()->member->prefer_meal == 'both' ? 'selected' : '' }}>Both</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dietary Requirements</label>
                        <select class="form-select" name="dietary_requirement">
                            <option value="none" {{ Auth::user()->member->dietary_requirement == 'none' ? 'selected' : '' }}>None</option>
                            <option value="vegetarian" {{ Auth::user()->member->dietary_requirement == 'vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                            <option value="vegan" {{ Auth::user()->member->dietary_requirement == 'vegan' ? 'selected' : '' }}>Vegan</option>
                            <option value="halal" {{ Auth::user()->member->dietary_requirement == 'halal' ? 'selected' : '' }}>Halal</option>
                            <option value="gluten-free" {{ Auth::user()->member->dietary_requirement == 'gluten-free' ? 'selected' : '' }}>Gluten-Free</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div> 