<x-adminlte-modal id="{{ $htmlid }}" title="Remove or add user from {{ $name }}" theme="info" icon="fas fa-users" size='lg'>

    @livewire('add-user', ['isManager' => true, 'proj' => $proj, 'name' => $name])

    Press the user input (not the button) if users list not refresh. Please reload the page after removing user.
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" label="Reload Page" wire:click="reloadPage" theme="warning"/>
        <x-adminlte-button label="Close All" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>
<x-adminlte-button class="mr-auto" theme="info" label="Remove or add users" data-toggle="modal" data-target="#{{ $htmlid }}" />
