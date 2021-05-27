<div class="d-flex">

    <input wire:model="search" wire:click="click" wire:keydown.escape="resetX" wire:keydown.tab="resetX"
    wire:keydown.arrow-up="highlightUp" wire:keydown.arrow-down="highlightDown" wire:keydown.enter="selectEnter"
    type="text" placeholder="Enter Registered User to Become Admin"
    class="search-lw">

    @if ($search !== '' && $active)
        <div class="search-lw-lists">
            @forelse ($users as $i => $user)
                <div class=" search-lw-list {{ $highlightIndex == $i ? 'search-lw-list-h' : '' }}"
                wire:click="select('{{ $user->name }}')">
                <div class="search-lw-list-name">{{ $user->name }}</div>
                <div class="search-lw-list-email">{{ $user->email }}</div>
                </div>
            @empty
                <div class="search-lw-list-none">None</div>
            @endforelse
        </div>
    @endif

    <button wire:click="madeAdmin" class="search-lw-button" @if (!$ifRegistered) disabled @endif>Become Admin</button>
</div>
