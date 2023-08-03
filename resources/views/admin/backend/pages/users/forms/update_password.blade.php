<form action="{{ route('backend.user-post_update_password') }}" method="post">
    @csrf
    @include('error')
    <div style="display:flex;align-items:center; flex-direction:column">
        <div class="col-md-4">

            <div class="mb-2">
                <label for="old_password">Old Password:</label>
                <input type="password" id="old_password" name="old_password" required class="form-control">
                @error('old_password')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required class="form-control">
            </div>

            <div class="mb-2">
                <label for="new_password_confirmation">Confirm New Password:</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-sm btn-primary mt-3 mx-1">Update Password</button>
        </div>
    </div>
</form>
