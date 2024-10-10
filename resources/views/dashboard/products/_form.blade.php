<div class="form-groub mb-3">
    {{-- <label for="">Product Name</label> --}}
    <x-form.input label="Product Name" name="name" role="input" value="{{ $product->name }}" />
</div>

<div class="form-groub mb-3">
    <label for="">Product Parent</label>
    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
        <option value="">Select One</option>
        @foreach (\App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" @if ($category->id == old('category_id', $product->category_id)) selected @endif>{{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-groub mb-3">
    <label for="">Dsecription</label>
    <x-form.textarea name="description" :value="$product->description" />
</div>


<div class="form-row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <x-form.input type="number" step="0.1" name="price" :value="$product->price" label="Price" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <x-form.input type="number" step="0.1" name="compare_price" :value="$product->compare_price" label="Compare Price" />
        </div>
    </div>
</div>


<div class="form-groub mb-3">
    <x-form.label id="image">Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*" />
    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="" height="50">
    @endif
</div>

<div class="form-group mb-3">
    <label for="tags">Tags</label>
    <x-form.textarea name="tags" :value="$tags" />
</div>



<div class="form-groub mb-3">
    <label for="">Status</label>
    <x-form.radio name="status" :checked="$product->status" :options="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']" />
</div>

<div class="form-groub mb-3">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>


@push('styles')
    <link href="{{ asset('dist/css/tagify.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('dist/js/tagify.js') }}"></script>
    <script src="{{ asset('dist/tagify.polyfills.min.js') }}"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]')
        tagify = new Tagify(inputElm);
    </script>
@endpush
