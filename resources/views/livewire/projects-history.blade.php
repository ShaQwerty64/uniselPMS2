<div>
    <!-- Styles -->
    {{-- <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet"> --}}
    <div class="d-flex mb-1">
        <h2 class="font-weight-bold">History</h2>

        <div class="w-25"></div>

        @foreach ([
            ['id' => 'target','name' =>'Subject', 'options' => $tarOps ],
            ['id' => 'sort'  , 'name' => 'Sort' , 'options' => $sortOps],
            ['id' => 'limit' , 'name' => 'Limit', 'options' => $limOps ],
        ] as $select)
            <div class="ml-3">
                {{-- <label for="{{$select['id']}}" class="ml-3 pt-2 mr-2">{{$select['name']}}</label> --}}
                <div class="font-weight-bold">{{$select['name']}}</div>
                <select name="{{$select['id']}}" id="{{$select['id']}}" wire:model="{{$select['id']}}">
                    @foreach ($select['options'] as $option)
                        <option value="{{$loop->index}}">{{$option}}</option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <div class="w-25"></div>
    </div>

    @forelse ($histories as $history)
        <div class="d-flex p-1">
            <div class="bg-primary rounded pl-1 pr-1 mr-1">{{$history->created_at->diffForHumans()}}</div>
            <div>{{$history->details}}</div>
        </div>
    @empty
        <div class="d-flex p-1">No history yet?</div>
    @endforelse
</div>
