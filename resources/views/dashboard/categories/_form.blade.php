@if ($errors->any())
    <div class="alert alert-danger">
        <h3>There is an Error!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-groub mb-3">
    {{-- <label for="">Category Name</label> --}}
    <x-form.input label="Category Name" name="name" role="input" value="{{ $category->name }}" />
</div>

<div class="form-groub mb-3">
    <label for="">Category Parent</label>
    <select name="parent_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-groub mb-3">
    <label for="">Dsecription</label>
    <x-form.textarea name="description" :value="$category->description" />
</div>

<div class="form-groub mb-3">
    <x-form.label id="image">Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*" />
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" height="50">
    @endif
</div>

<div class="form-groub mb-3">
    <label for="">Status</label>
    <x-form.radio name="status" :checked="$category->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
</div>

<div class="form-groub mb-3">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
