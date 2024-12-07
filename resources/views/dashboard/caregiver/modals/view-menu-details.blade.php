<!-- View Menu Details Modal -->
@foreach($menus as $menu)
    <div class="modal fade" 
         id="viewMenuModal_{{ $menu->id }}" 
         tabindex="-1" 
         aria-labelledby="viewMenuModalLabel_{{ $menu->id }}" 
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">
                        <i class="fas fa-utensils me-2 text-primary"></i>
                        {{ ucfirst($menu->name) }} Menu Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Menu Status Badge -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge bg-{{ $menu->status === 'draft' ? 'warning' : 'success' }} px-3 py-2">
                            <i class="fas fa-{{ $menu->status === 'draft' ? 'pencil-alt' : 'check-circle' }} me-2"></i>
                            {{ ucfirst($menu->status) }}
                        </span>
                        <span class="text-muted">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ \Carbon\Carbon::parse($menu->available_date)->format('M d, Y') }}
                        </span>
                    </div>

                    <!-- Menu Description -->
                    <div class="menu-description bg-light p-3 rounded mb-4">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Description
                        </h6>
                        <p class="mb-0">{{ $menu->description }}</p>
                    </div>

                    <!-- Menu Items -->
                    <div class="menu-items">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-list me-2 text-primary"></i>Menu Items
                        </h6>
                        <div class="row g-3">
                            @foreach($menu->meals as $meal)
                                <div class="col-md-6">
                                    <div class="menu-item-card border rounded p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $meal->name }}</h6>
                                                <p class="text-muted small mb-2">
                                                    {{ Str::limit($meal->description, 100) }}
                                                </p>
                                            </div>
                                            <span class="badge bg-{{ $meal->meal_type === 'hot' ? 'danger' : 'info' }}">
                                                {{ ucfirst($meal->meal_type) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Dietary Flags -->
                                        <div class="dietary-flags mt-2">
                                            @foreach($meal->dietary_flags as $flag)
                                                <span class="badge bg-secondary me-1">
                                                    {{ ucfirst($flag) }}
                                                </span>
                                            @endforeach
                                        </div>
                                        
                                        <!-- Nutritional Info -->
                                        @if($meal->nutritional_info)
                                        <div class="nutritional-info mt-2 border-top">
                                            <div class="row g-2 mt-1">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-leaf me-1"></i>
                                                        Calories: {{ $meal->nutritional_info['calories'] ?? 'N/A' }}
                                                    </small>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-leaf me-1"></i>
                                                        Fat: {{ $meal->nutritional_info['fat'] ?? 'N/A' }}
                                                    </small>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-leaf me-1"></i>
                                                        Carbs: {{ $meal->nutritional_info['carbs'] ?? 'N/A' }}
                                                    </small>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-leaf me-1"></i>
                                                        Protein: {{ $meal->nutritional_info['protein'] ?? 'N/A' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="additional-info mt-4 pt-3 border-top">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-card bg-light p-3 rounded">
                                    <h6 class="fw-bold mb-2">
                                        <i class="fas fa-clock me-2 text-primary"></i>Meal Time
                                    </h6>
                                    <p class="mb-0">{{ ucfirst($menu->meal_type) }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card bg-light p-3 rounded">
                                    <h6 class="fw-bold mb-2">
                                        <i class="fas fa-user-check me-2 text-primary"></i>Created By
                                    </h6>
                                    <p class="mb-0">{{ $menu->caregiver->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach 