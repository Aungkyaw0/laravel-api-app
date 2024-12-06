<!-- Create separate modals for each food service -->
@foreach($foodServices as $service)
    <div class="modal fade" 
         id="createMenuModal_{{ $service->id }}" 
         tabindex="-1" 
         aria-labelledby="createMenuModalLabel_{{ $service->id }}" 
         aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Menu for {{ $service->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form action="{{ route('caregiver.menu.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="food_service_id" value="{{ $service->id }}">
                    
                    <div class="modal-body">
                        <!-- Meal Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-utensils me-2"></i>Select Available Meals
                                <span class="text-danger">*</span>
                            </label>
                            <div class="meal-selection-container border rounded p-3 bg-light">
                                @forelse($service->meals as $meal)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="meal_ids[]" 
                                               value="{{ $meal->id }}" 
                                               id="meal{{ $service->id }}_{{ $meal->id }}">
                                        <label class="form-check-label d-flex justify-content-between align-items-center" 
                                               for="meal{{ $service->id }}_{{ $meal->id }}">
                                            <div>
                                                <span class="fw-medium">{{ $meal->name }}</span>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($meal->description, 50) }}</small>
                                            </div>
                                            <div class="meal-badges">
                                                <span class="badge bg-{{ $meal->meal_type === 'hot' ? 'danger' : 'info' }} me-1">
                                                    {{ ucfirst($meal->meal_type) }}
                                                </span>
                                                @foreach($meal->dietary_flags as $flag)
                                                    <span class="badge bg-secondary">{{ ucfirst($flag) }}</span>
                                                @endforeach
                                            </div>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">No meals available for this service.</p>
                                @endforelse
                            </div>
                            <small class="text-muted">Select one or more meals to include in this menu</small>
                        </div>

                        <!-- Meal Type and Date Row -->
                        <div class="row mb-4">
                            <!-- Meal Type Selection -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clock me-2"></i>Meal Type
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="meal-type-selector border rounded p-3 bg-light">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="meal_type" 
                                               id="breakfast_{{ $service->id }}" value="breakfast" required>
                                        <label class="form-check-label" for="breakfast_{{ $service->id }}">
                                            <i class="fas fa-sun me-2"></i>Breakfast
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="meal_type" 
                                               id="lunch_{{ $service->id }}" value="lunch" required>
                                        <label class="form-check-label" for="lunch_{{ $service->id }}">
                                            <i class="fas fa-cloud-sun me-2"></i>Lunch
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="meal_type" 
                                               id="dinner_{{ $service->id }}" value="dinner" required>
                                        <label class="form-check-label" for="dinner_{{ $service->id }}">
                                            <i class="fas fa-moon me-2"></i>Dinner
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- Menu Name -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-utensils me-2"></i>Menu Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                
                                <!-- Available Date -->
                                <div>
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar me-2"></i>Available Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" 
                                               class="form-control" 
                                               name="available_date" 
                                               required 
                                               min="{{ date('Y-m-d') }}">
                                    </div>
                                    <small class="text-muted">Select the date when this menu will be available</small>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-align-left me-2"></i>Menu Description
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" 
                                      name="description" 
                                      rows="3" 
                                      required
                                      placeholder="Describe the menu and any special features..."></textarea>
                            <small class="text-muted">Provide a clear description of the menu</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Create Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach