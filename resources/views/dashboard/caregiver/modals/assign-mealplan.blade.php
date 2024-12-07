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
                    <div class="row">
                        <!-- Left side - Member Info -->
                        <div class="col-md-6">
                            <div class="member-info mb-4 p-3 bg-light rounded">
                                <h6 class="text-muted mb-2">Member Information</h6>
                                <p class="mb-1"><strong>Name:</strong> <span id="memberName"> {{ $member->name }} </span></p>
                                <p class="mb-0"><strong>Dietary Requirement:</strong> <span id="memberDietary"> {{ $member->dietary_requirement }} </span></p>
                                <p class="mb-0"><strong>Location:</strong> <span id="memberAddress"> {{ $member->address }} </span></p>
                            </div>
                        </div>
                        
                        <!-- Right side - Partner Info -->
                        <div class="col-md-6">
                            <div class="partner-info mb-4 p-3 bg-light rounded">
                                <h6 class="text-muted mb-2">Partner Information</h6>
                                <p class="mb-1"><strong>Name:</strong> <span id="partnerName"></span></p>
                                <p class="mb-0"><strong>Location:</strong> <span id="partnerLocation"></span></p>
                                <p class="mb-0"><strong>Delivery Type:</strong> <span id="deliveryType"></span></p>
                            </div>
                        </div>
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
                                           for="menu{{ $menu->id }}"
                                           data-partner="{{ json_encode([
                                               'company_name' => $menu->partner->company_name,
                                               'location' => $menu->partner->location,
                                               'latitude' => $menu->partner->latitude,
                                               'longitude' => $menu->partner->longitude
                                           ]) }}">
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
        const menuRadios = document.querySelectorAll('input[name="menu_id"]');

        if (assignMealPlanModal) {
            assignMealPlanModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const memberId = button.getAttribute('data-member-id');
                const memberName = button.getAttribute('data-member-name');
                const dietaryRequirement = button.getAttribute('data-dietary-requirement');
                
                // Update member info
                document.getElementById('memberId').value = memberId;
                document.getElementById('memberName').textContent = memberName;
                document.getElementById('memberDietary').textContent = dietaryRequirement;
            });
        }

        // Add event listeners to menu radio buttons
        menuRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const menuId = this.value;
                    const menuLabel = document.querySelector(`label[for="menu${menuId}"]`);
                    const partnerData = JSON.parse(menuLabel.getAttribute('data-partner'));
                    
                    // Update partner info
                    document.getElementById('partnerName').textContent = partnerData.company_name;
                    document.getElementById('partnerLocation').textContent = partnerData.location;
                    
                    // Calculate and display delivery type based on distance
                    const distance = calculateDistance(
                        memberLat, memberLng,  // You'll need to add these as data attributes
                        partnerData.latitude, partnerData.longitude
                    );
                    const deliveryType = distance <= 10 ? 'Hot Meal' : 'Frozen Meal';
                    document.getElementById('deliveryType').textContent = deliveryType;
                }
            });
        });
    });
</script>