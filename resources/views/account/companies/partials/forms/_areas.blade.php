<div class="form-group row{{ $errors->has('area_id') ? ' has-error' : '' }}">
    <label for="area_id" class="control-label col-md-4">Country (Primary location to sell your products)</label>

    <div class="col-md-6">
        <select name="area_id" id="area_id"
                class="form-control custom-select{{ $errors->has('area_id') ? ' is-invalid' : '' }}">
            <option value="">Choose country / area</option>

            @php
                $nodes = $areas;
                $shop = isset($shop) ? $shop : null;

                $traverse = function ($areas, $shop) use (&$traverse) {
                    foreach ($areas as $area) {
                        if(!$area->children->isEmpty()){
                            if (old('area_id', ($shop != null ? $shop->area_id : '')) == $area->id) {
                                echo "<option value='{$area->id}' selected>{$area->name}</option>";
                            } else {
                                echo "<option value='{$area->id}'>{$area->name}</option>";
                            }
                            echo "<optgroup label='{$area->name}'>";
                            $traverse($area->children, $shop);
                            echo "</optgroup>";
                        } else{
                            if (old('area_id', ($shop != null ? $shop->area_id : '')) == $area->id) {
                                echo "<option value='{$area->id}' selected>{$area->name}</option>";
                            } else {
                                echo "<option value='{$area->id}'>{$area->name}</option>";
                            }
                        }
                    }
                };

                $traverse($nodes, $shop);
            @endphp
        </select>
    </div>

    @if ($errors->has('area_id'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('area_id') }}</strong>
        </div>
    @endif
</div>