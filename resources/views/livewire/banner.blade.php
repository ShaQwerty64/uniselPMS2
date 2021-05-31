<div>
    {{-- <div class="toasts-top-right fixed"></div> --}}
    @if ($message != '' && $theme == 's')
        <x-adminlte-alert theme="success" title="Success!" dismissable>
            {{ $message }}
        </x-adminlte-alert>
    @elseif ($message != '' && $theme == 'w')
        <x-adminlte-alert theme="warning" title="Warning" dismissable>
            {{ $message }}
        </x-adminlte-alert>
    @elseif ($message != '' && $theme == 'd')
        <x-adminlte-alert theme="danger" title="Danger!" dismissable>
            {{ $message }}
        </x-adminlte-alert>
    @elseif ($message != '' && $theme == '')
        <x-adminlte-alert theme="info" title="Message" dismissable>
            {{ $message }}
        </x-adminlte-alert>
    @endif
</div>
