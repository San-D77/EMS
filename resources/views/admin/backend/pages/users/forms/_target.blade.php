<form action="{{ route('backend.user-post_target', $user->id) }}" method="post">
    @csrf
    @include('error')
    <div style="display:flex;align-items:center; flex-direction:column">
        <span style="font-size: 20px; font-weight:600;margin-bottom: 50px; color: rgb(18, 102, 175);">Set Target for {{ $user->name }}</span>
        <div class="col-md-4">
            <div class="mb-2">
                <label for="old_password">Standard Time:</label>

                <select name="standard_time" id="" class="form-control" required>
                    <option value="">Select Stay Time</option>
                    <option {{ $user->standard_time == '05:00' ? 'selected' : '' }} value="05:00">5 Hours</option>
                    <option {{ $user->standard_time == '06:00' ? 'selected' : '' }} value="06:00">6 Hours</option>
                    <option {{ $user->standard_time == '07:00' ? 'selected' : '' }} value="07:00">7 Hours</option>
                    <option {{ $user->standard_time == '08:00' ? 'selected' : '' }} value="08:00">8 Hours</option>
                    <option {{ $user->standard_time == '09:00' ? 'selected' : '' }} value="09:00">9 Hours</option>
                </select>


            </div>

            <div class="mb-2">
                <label for="standard_task">Standard Task:</label>
                <input required type="number" id="standard_task" name="standard_task" required class="form-control"
                    value="{{ isset($user) ? $user->standard_task : old('standard_task') }}">
            </div>

            <button type="submit" class="btn btn-sm btn-primary mt-3 mx-1">Set Target</button>
        </div>
    </div>
</form>
