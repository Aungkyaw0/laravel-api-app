<div class="modal fade" id="rejectModal{{ $delivery->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('volunteer.reject-delivery', $delivery) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle me-2"></i>
                        Reject Delivery #{{ $delivery->id }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Please provide a reason for rejection</label>
                        <textarea 
                            name="reason" 
                            class="form-control @error('reason') is-invalid @enderror" 
                            rows="3" 
                            required 
                            placeholder="Enter your reason here..."
                        ></textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This action cannot be undone. The delivery will be reassigned to another volunteer.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-check me-2"></i>Confirm Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 