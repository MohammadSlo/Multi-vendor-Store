@if (session()->has($type))
    <div class="alert alert-{{ $type }}">
        {{ session($type) }}
    </div>
    {{-- @elseif (session()->has('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
    </div>
@elseif (session()->has('delete'))
    <div class="alert alert-danger">
        {{ session('delete') }}
    </div> --}}
@endif
