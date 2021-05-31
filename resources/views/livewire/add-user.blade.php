<div>
    <livewire:user-remove-l1 :big="$big" :pId="$pId" :name="$name">

    <div class="d-flex">

        <input wire:model="search" wire:click="click" wire:keydown.escape="resetX" wire:keydown.tab="resetX"
        wire:keydown.arrow-up="highlightUp" wire:keydown.arrow-down="highlightDown" wire:keydown.enter="selectEnter"
        type="text" placeholder="Enter Registered User to Become {{ $word }}"
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

        <button wire:click="madeRole" class="search-lw-button" @if (!$ifRegistered) disabled @endif>Become {{ $word }}</button>
    </div>
</div>
<style>
/* w-10/12 p-3 m-3 mr-0 bg-gray-100 border-none rounded-md focus:bg-gray-200 */
.search-lw{
    width: 83.333333%;
    padding: 0.75rem/* 12px */;
    margin: 0.75rem/* 12px */;
    margin-right: 0px;
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    border-style: none;
    border-radius: 0.375rem/* 6px */;
}
.search-lw:focus{
    --tw-bg-opacity: 1;
    background-color: rgba(229, 231, 235, var(--tw-bg-opacity));
}
/* absolute overflow-hidden transform translate-x-3 translate-y-16 border-gray-700 divide-y rounded-md shadow-2xl */
.search-lw-lists{
    position: absolute;
    overflow: hidden;
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    --tw-translate-x: 0.75rem/* 12px */;
    --tw-translate-y: 4rem/* 64px */;
    --tw-border-opacity: 1;
    border-color: rgba(55, 65, 81, var(--tw-border-opacity));
    --tw-divide-y-reverse: 0;
    border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
    border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
    border-radius: 0.375rem/* 6px */;
    --tw-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}
/* grid grid-cols-2 bg-gray-100 p-2 w-full border-gray-300 hover:bg-blue-600 hover:text-white */
.search-lw-list{
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    padding: 0.5rem/* 8px */;
    width: 100%;
    --tw-border-opacity: 1;
    border-color: rgba(209, 213, 219, var(--tw-border-opacity));
}
.search-lw-list:hover{
    --tw-bg-opacity: 1;
    background-color: rgba(37, 99, 235, var(--tw-bg-opacity));
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
}
/* bg-blue-300 */
.search-lw-list-h{
    --tw-bg-opacity: 1;
    background-color: rgba(147, 197, 253, var(--tw-bg-opacity));
}
/* pr-2 font-bold text-right */
.search-lw-list-name{
    padding-right: 0.5rem/* 8px */;
    font-weight: 700;
    text-align: right;
}
/* pl-2 text-left */
.search-lw-list-email{
    padding-left: 0.5rem/* 8px */;
    text-align: left;
}
/* w-full p-2 text-center text-gray-600 bg-gray-100 border-gray-300 */
.search-lw-list-none{
    width: 100%;
    padding: 0.5rem/* 8px */;
    text-align: center;
    --tw-text-opacity: 1;
    color: rgba(75, 85, 99, var(--tw-text-opacity));
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    --tw-border-opacity: 1;
    border-color: rgba(209, 213, 219, var(--tw-border-opacity));
}
/* flex-grow p-3 m-3 font-bold text-white bg-green-600 rounded-md disabled:opacity-50 */
.search-lw-button{
    flex-grow: 1;
    padding: 0.75rem/* 12px */;
    margin: 0.75rem/* 12px */;
    font-weight: 700;
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    --tw-bg-opacity: 1;
    background-color: rgba(5, 150, 105, var(--tw-bg-opacity));
    border-radius: 0.375rem/* 6px */;
}
.search-lw-button:disabled{
    opacity: 0.5;
}
</style>
