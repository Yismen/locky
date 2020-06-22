<div class="row">
    <div class="col-sm-12 col-lg-6">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text"
              class="form-control" name="name" id="name" aria-describedby="name" placeholder="User Name"
              value="{{ old('name') ?? $user->name }}">
            {{--  <small id="name" class="form-text text-muted">Help text</small>  --}}
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email"
              class="form-control" name="email" id="email" aria-describedby="email" placeholder="User Email"
              value="{{ old('email') ?? $user->email }}">
            {{--  <small id="email" class="form-text text-muted">Help text</small>  --}}
          </div>
    </div>
    <div class="col-sm-12 col-lg-6">
        <h5>Roles</h5>

        @foreach ($user->roles as $role)
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                {{ $role->name }}
              </label>
            </div>
        @endforeach
    </div>
</div>