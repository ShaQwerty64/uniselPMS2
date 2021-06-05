<div>
    @if ($isManager)
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
    @endif
    <div class="d-flex">

        <input wire:model="search" wire:click="click" wire:keydown.escape="resetX" wire:keydown.tab="resetX"
        wire:keydown.arrow-up="highlightUp" wire:keydown.arrow-down="highlightDown" wire:keydown.enter="selectEnter"
        type="text" placeholder="{{ $word2 }}"
        class="search-lw">

        @if ($search !== '' && $active)
            <div class="search-lw-lists">
                    @forelse ($users as $i => $user)
                        <div class=" search-lw-list {{ $highlightIndex == $i ? 'search-lw-list-h' : '' }}"
                        wire:click="select({{ $i }})">
                            @if ($this->isProject)
                                <div class="search-lw-list-proj">{{ $user->name }}</div>
                            @else
                                <div class="search-lw-list-name">{{ $user->name }}</div>
                                <div class="search-lw-list-email">{{ $user->email }}</div>
                            @endif
                        </div>
                    @empty
                        <div class="search-lw-list-none">None</div>
                    @endforelse

            </div>
        @endif

        <button wire:click="madeRole" class="search-lw-button" @if (!$ifRegistered) disabled @endif>{{ $word }}</button>
    </div>
</div>
