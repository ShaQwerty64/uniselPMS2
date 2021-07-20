    <div class="outside02">

    <div class="d-flex">
        <p>For asigning user to project.</p>
        <div wire:loading class="loading">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden"></span>
            </div>
        </div>
    </div>
    <hr class="hr">

    <label for="user"><b>User Email (can search using user name)</b></label>
    <div class="search-lw-out">

        <input wire:model="search" list="search-user-list" type="text"
        placeholder="Enter Registered User Email or Name" class="search-lw2" required>

        <datalist id="search-user-list">
            @foreach ($users as $user)
                <option value="{{ $user->email }}"><div>{{ $user->name }}</div></option>
            @endforeach
        </datalist>

        <div class="search-lw2-text">
            @if ($ifRegistered && $search !== '')
                <div>Found "{{ $theUser->email }}", user name: "{{ $theUser->name }}"</div>
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

    <div class="search-lw-out">

        <input wire:model="searchP" list="search-proj-list" type="text"
        placeholder="Enter @if ($theBigProject == '[Make New Big Project]')Big @endif Project Name"
        class="search-lw2" required>

        <datalist id="search-proj-list">
            @foreach ($projects as $project)
                <option value="{{ $project->name }}">
            @endforeach
        </datalist>

        <div class="search-lw2-text">
            @if ($searchP == '')
            @elseif ($ifExist)
                "{{ $searchP }}" @if ($theBigProject == '[Make New Big Project]') big @endif project has {{ $usersCount }} users asign to it already.
            @elseif (!$bigSameName)
                "{{ $searchP }}" big project already exist in other PTJ.
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
    @if (!($ifRegistered && $searchP != '' && $bigSameName)) disabled @endif>
        Asign Project
    </button>
</div>
