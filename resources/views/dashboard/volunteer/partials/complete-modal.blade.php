<div class="modal fade" id="completeModal{{ $delivery->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('volunteer.complete-delivery', $delivery) }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>
                        Complete Delivery #{{ $delivery->id }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Please ask the member for their confirmation code to complete the delivery.
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Member's Confirmation Code</label>
                        <input 
                            type="text" 
                            name="confirmation_code" 
                            class="form-control @error('confirmation_code') is-invalid @enderror" 
                            required 
                            placeholder="Enter confirmation code"
                            autocomplete="off"
                        >
                        @error('confirmation_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Delivery Notes (Optional)</label>
                        <textarea 
                            name="delivery_notes" 
                            class="form-control @error('delivery_notes') is-invalid @enderror" 
                            rows="3" 
                            placeholder="Any additional notes about the delivery..."
                        ></textarea>
                        @error('delivery_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="confirmDelivery{{ $delivery->id }}" 
                            required
                        >
                        <label class="form-check-label" for="confirmDelivery{{ $delivery->id }}">
                            I confirm that I have successfully delivered the meal to the member
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-2"></i>Complete Delivery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 