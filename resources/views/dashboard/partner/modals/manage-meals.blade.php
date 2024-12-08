<div class="modal fade" id="manageMealsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Meals</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                

                <!-- Add New Meal Form -->
                <form id="addMealForm" action="{{ route('partner.food-service.add-meal', 0) }}" method="POST">
                    @csrf
                    <h6>Add New Meal</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meal Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meal Type</label>
                            <select class="form-select" name="meal_type" required>
                                <option value="breakfast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ingredients (one per line)</label>
                        <textarea class="form-control" name="ingredients" rows="3" required 
                            placeholder="Enter each ingredient on a new line"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nutritional Information</label>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="number" class="form-control" name="nutritional_info[calories]" 
                                    placeholder="Calories" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="number" class="form-control" name="nutritional_info[protein]" 
                                    placeholder="Protein (g)" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="number" class="form-control" name="nutritional_info[carbs]" 
                                    placeholder="Carbohydrates (g)" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="number" class="form-control" name="nutritional_info[fat]" 
                                    placeholder="Fat (g)" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dietary Flags</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dietary_flags[]" value="vegetarian">
                                    <label class="form-check-label">Vegetarian</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dietary_flags[]" value="vegan">
                                    <label class="form-check-label">Vegan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dietary_flags[]" value="halal">
                                    <label class="form-check-label">Halal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dietary_flags[]" value="gluten_free">
                                    <label class="form-check-label">Gluten Free</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dietary_flags[]" value="dairy_free">
                                    <label class="form-check-label">Dairy Free</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Meal</button>
                    </div>
                </form>

                <!-- Existing Meals List -->
                <h6 class="mt-4">Existing Meals</h6>
                <div id="mealsList" class="list-group mt-4">
                    <!-- Meals will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
