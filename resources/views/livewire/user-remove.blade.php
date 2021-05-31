<div>
    <x-adminlte-modal id="{{ $htmlid }}" title="Select a user to remove from {{ $name }}?" theme="danger"
        icon="fa fa-lg fa-fw fa-trash" size='lg'>

        {{-- <livewire:user-remove-l1 :big="$big" :pId="$pId" :name="$name"> --}}

        @livewire('add-user', ['is' => 'manager','big' => $big, 'pId' => $pId, 'name' => $name])

        Please reload the page after removing user.
        <x-slot name="footerSlot">
            <x-adminlte-button label="Close All" data-dismiss="modal"/>
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-button class="mr-auto" theme="info" label="Remove or add users" data-toggle="modal"
    data-target="#{{ $htmlid }}" />
</div>
