<x-app-layout>
    <x-slot name="header">
        {{ !empty($model) ? 'View' : 'Error!' }}
    </x-slot>
    <div class="row">
        @if (!empty($model))
        <div class="col-md-12 col-xs-12">
            <h3>{{ $model->title }}</h3>
        </div>
        <div class="col-md-12 col-xs-12">
            <p>{{ $model->content }}</p>
        </div>
        <div class="col-md-12 col-xs-12 text-right">
            Update at: {{ $model->updated_at }}
        </div>
        <div class="col-md-12 col-xs-12">
            <a href="{{ url()->previous() }}">Go back</a>
        </div>
        @else
        <div class="col-md-12 col-xs-12">
            <div class="alert alert-warning">
                <b>Oops!</b><br>
                News not found, <a href="{{ url()->previous() }}">go to list</a>.
            </div>
        </div>
        @endif
    </div>
</x-app-layout>