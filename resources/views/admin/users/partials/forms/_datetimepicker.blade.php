<div class="form-group row{{ $errors->has('expires_at') ? ' has-error' : '' }}">
    <label for="expires_at" class="control-label col-sm-4" data-toggle="datetimepicker"
           data-target="#expires_at{{ $id or '' }}">
        Expires at
    </label>
    <div class="col-sm-4">
        <div class="input-group datetimepicker" id="expires_at{{ $id or '' }}" data-target-input="nearest">
            <input type="text" name="expires_at"
                   class="form-control{{ $errors->has('expires_at') ? ' is-invalid' : '' }}"
                   data-toggle="datetimepicker" data-target="#expires_at{{ $id or '' }}"
                   value="{{ old('expires_at') }}">

            <div class="input-group-append" data-toggle="datetimepicker" data-target="#expires_at{{ $id or '' }}">
                <div class="input-group-text">
                    <i class="icon-calendar"></i>
                </div>
            </div>
        </div>

        @if($errors->has('expires_at'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('expires_at') }}</strong>
            </div>
        @endif
    </div>
</div>
