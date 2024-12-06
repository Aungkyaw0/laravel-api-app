<!-- Assign Meal Plan Modal -->
<div class="modal fade" id="assignMealPlanModal" tabindex="-1" aria-labelledby="assignMealPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="assignMealPlanModalLabel">
                    <i class="fas fa-calendar-plus me-2"></i>Assign Meal Plan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('caregiver.publish-meal-plan') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="member-info mb-4 p-3 bg-light rounded">
                        <h6 class="text-muted mb-2">Member Information</h6>
                        <p class="mb-1"><strong>Name:</strong> <span id="memberName"> {{ $member->name }} </span></p>
                        <p class="mb-0"><strong>Dietary Requirement:</strong> <span id="memberDietary"> {{ $member->dietary_requirement }} </span></p>
                    </div>

                    <input type="hidden" name="member_id" id="memberId">

                    <div class="form-group mb-4">
                        <label class="form-label">Select Menu</label>
                        <div class="menu-selection">
                            @forelse($menus->where('status', 'draft') as $menu)
                                <div class="menu-option mb-2">
                                    <input type="radio" 
                                           class="btn-check" 
                                           name="menu_id" 
                                           id="menu{{ $menu->id }}" 
                                           value="{{ $menu->id }}" 
                                           required>
                                    <label class="btn btn-outline-primary w-100 text-start" 
                                           for="menu{{ $menu->id }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $menu->name }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-utensils me-1"></i>
                                                    {{ ucfirst($menu->meal_type) }}
                                                </small>
                                            </div>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($menu->available_date)->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </label>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    No draft menus available. Please create a menu first.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Meal Date</label>
                        <input type="date" 
                               class="form-control" 
                               name="meal_date" 
                               required 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Assign Meal Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const assignMealPlanModal = document.getElementById('assignMealPlanModal');
        if (assignMealPlanModal) {
            assignMealPlanModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const memberId = button.getAttribute('data-member-id');
                const memberName = button.getAttribute('data-member-name');
                const dietaryRequirement = button.getAttribute('data-dietary-requirement');
                
                // Update modal content
                document.getElementById('memberId').value = memberId;
                document.getElementById('memberName').textContent = memberName;
                document.getElementById('memberDietary').textContent = dietaryRequirement;
            });
        }
    });
    </script>