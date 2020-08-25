<div class="form-group row{{ $errors->has('category_id') ? ' has-error' : '' }}">
    <label for="category_id" class="control-label col-md-4">Category (What will you be selling?)</label>

    <div class="col-md-6">
        <select name="category_id" id="category_id"
                class="form-control custom-select{{ $errors->has('category_id') ? ' is-invalid' : '' }}">
            <option value="">Choose shop category</option>

            @php
                $nodes = $categories;
                $shop = isset($shop) ? $shop : null;

                $traverse = function ($categories, $shop) use (&$traverse) {
                    foreach ($categories as $category) {
                        if(!$category->children->isEmpty()){
                            if (old('category_id', ($shop != null ? $shop->category_id : '')) == $category->id) {
                                echo "<option value='{$category->id}' selected>{$category->name}</option>";
                            } else {
                                echo "<option value='{$category->id}'>{$category->name}</option>";
                            }
                            echo "<optgroup label='{$category->name}'>";
                            $traverse($category->children, $shop);
                            echo "</optgroup>";
                        } else{
                            if (old('category_id', ($shop != null ? $shop->category_id : '')) == $category->id) {
                                echo "<option value='{$category->id}' selected>{$category->name}</option>";
                            } else {
                                echo "<option value='{$category->id}'>{$category->name}</option>";
                            }
                        }
                    }
                };

                $traverse($nodes, $shop)
            @endphp
        </select>
    </div>

    @if ($errors->has('category_id'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('category_id') }}</strong>
        </div>
    @endif
</div>