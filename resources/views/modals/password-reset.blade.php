 <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Confirm Password Reset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure to reset the password to 123456 for {{$user->name}}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('password_reset', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
