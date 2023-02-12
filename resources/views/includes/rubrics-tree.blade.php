@foreach ($rubrics as $r)
    <option value="{{ $r->id }}">
        @for ($i = 0; $i < $level; $i++)
            &nbsp;
        @endfor
        {{ $r->name }}
    </option>
    @if (!empty($r->children))
        @include('includes.rubrics-tree', ['rubrics' => $r->children, 'level' => $level + 1])
    @endif
@endforeach