<x-app-layout>
    <x-slot name="header">
        {{ !empty($result) && $result['status'] == 'ok' ? 'Success!' : 'Error!' }}
    </x-slot>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <h3>{{ $result['model']['title'] }}</h3>
        </div>
        <div class="col-md-12 col-xs-12">
            <p>{{ $result['model']['content'] }}</p>
        </div>
        <div class="col-md-12 col-xs-12">
            <a href="{{ url()->previous() }}">Go back</a>
        </div>
        <div class="col-md-12 col-xs-12">
            @if (!empty($result) && $result['status'] == 'ok')
            <div class="alert alert-success">
                <b>A new record has been added!</b>
            </div>    
            @else
            <div class="alert alert-warning">
                <b>Oops!</b><br>
                Something went wrong, <a href="{{ url()->previous() }}">go to list</a>.
            </div>
            @endif
        </div>
    </div>
</x-app-layout>