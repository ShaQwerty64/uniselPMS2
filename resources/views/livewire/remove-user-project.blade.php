<div>
    Press Remove to remove project, press Cancel to not remove, then press the comfrim button.
    <div>
        {{-- Setup data for datatables in AddUser.php --}}
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($config['data'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
    <x-adminlte-button label="Confirm Remove" theme="danger" icon="fas fa-lg fa-trash" wire:click="confirm"/>

    <div x-data="{ tab: 'foo' }">
        <button :class="{ 'active': tab === 'foo' }" @click="tab = 'foo'">Foo</button>
        <button :class="{ 'active': tab === 'bar' }" @click="tab = 'bar'">Bar</button>

        <div x-show="tab === 'foo'">Tab Foo</div>
        <div x-show="tab === 'bar'">Tab Bar</div>
    </div>
</div>
