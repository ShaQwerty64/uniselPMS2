    <div class="outside02">

    <div class="d-flex">
        <p>For asigning user to project.</p>
        <div wire:loading class="loading">
            Loading...
        </div>
    </div>
    <hr class="hr">

    <label for="user"><b>User Name</b></label>
    <div class="search-lw-out">

        @if ($search !== '' && $active)
            <div class="search-lw-reset" wire:click="resetX"></div>
        @endif

        <input wire:model="search" wire:click="click" wire:keydown.escape="resetX" wire:keydown.tab="resetX"
        wire:keydown.arrow-up="highlightUp" wire:keydown.arrow-down="highlightDown" wire:keydown.enter="selectEnter"
        type="text" placeholder="Enter Registered User"
        class="search-lw2" required>

        @if ($search !== '' && $active)

            <div class="search-lw2-lists1">

                @forelse ($users as $i => $user)
                    <div class="search-lw-list {{ $highlightIndex == $i ? 'search-lw-list-h' : '' }}"
                    wire:click="select('{{ $user->name }}')">
                    <div class="search-lw-list-name">{{ $user->name }}</div>
                    <div class="search-lw-list-email">{{ $user->email }}</div>
                    </div>
                @empty
                    <div class="search-lw-list-none">None</div>
                @endforelse

            </div>
        @endif

        <div class="search-lw2-text">
            @if ($ifRegistered && $search !== '')
                <div>User "{{ $search }}" found, email: {{ $theUser->email }}</div>
            @elseif ($search !== '')
                <div class="search-lw2-text-r">User "{{ $search }}" did not found in the database.</div>
            @endif
        </div>
    </div>



    <label for="PTJ"><b>Pusat Tanggung Jawab: </b></label>
    <select class="search-lw2-select" name="PTJ" wire:model="PTJ">
        <option value="CICT">CICT</option>
        <option value="Aset">Aset</option>
        <option value="JPP">JPP</option>
    </select>

    <label for="big"><b>Project Under: </b></label>
    <select class="search-lw2-select" name="big" wire:model="theBigProject">
        <option value="[None]">[None]</option>
        <option value="[Make New Big Project]">[Make New Big Project]</option>
        @foreach ($bigProjects as $bigProject)
            <option value="{{$bigProject->name}}">{{$bigProject->name}}</option>
        @endforeach
    </select>

    <label for="project"><b>
    @if ($theBigProject == '[Make New Big Project]') Big @endif
    Project Name </b></label>

    <div @if ($searchP !== '' && $activeP) class="search-lw-reset" @endif wire:click="resetP"></div>

    <div class="search-lw-out">

        <input wire:model="searchP" wire:click="clickP" wire:keydown.escape="resetP" wire:keydown.tab="resetP"
        wire:keydown.arrow-up="highlightUpP" wire:keydown.arrow-down="highlightDownP" wire:keydown.enter="selectEnterP"
        type="text" placeholder="Enter @if ($theBigProject == '[Make New Big Project]')Big @endif Project Name"
        class="search-lw2" required>

        @if ($searchP !== '' && $activeP)

            <div class="search-lw2-lists2">

                @foreach ($projects as $i => $project)
                    <div class=" search-lw2-list2
                    {{ $highlightIndexP == $i ? 'search-lw-list-h' : '' }}"
                    wire:click="selectP('{{ $project->name }}')"
                    >{{ $project->name }}</div>
                @endforeach

            </div>
        @endif

        <div class="search-lw2-text">
            @if ($ifReal && $searchP !== '')
                "{{ $searchP }}" @if ($theBigProject == '[Make New Big Project]') big @endif project has {{ $usersCount }} users asign to it already.
            @elseif ($searchP == '')

            @else
                Will make new "{{ $searchP }}" @if ($theBigProject == '[Make New Big Project]') big @endif project.
                @if ($closestLike !== '')
                    Do you mean "{{ $closestLike }}"?
                @endif
            @endif
        </div>
    </div>

    <hr class="hr">

    <button type="button" wire:click="makeBigProject" class="search-lw2-button"
    @if (!($ifRegistered && $searchP != '')) disabled @endif>
        Asign Project
    </button>
</div>
