<div>
    <!-- Styles -->
    {{-- <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet"> --}}
    <div class="d-flex w-100">

        @foreach ([
            ['id' => 'target'   ,'name' =>'Subject:', 'options' => $tarOps              , 'inx' => true],
            ['id' => 'sort'     , 'name' => 'Sort:' , 'options' => ['desc','asc']       , 'inx' => false],
            ['id' => 'limit'    , 'name' => 'Limit:', 'options' => [15,50,100,250,1000] , 'inx' => false],
        ] as $select)
            <label for="{{$select['id']}}" class="ml-3 pt-2 mr-2">{{$select['name']}}</label>
            <select name="{{$select['id']}}" id="{{$select['id']}}" wire:model="{{$select['id']}}">
                @foreach ($select['options'] as $option)
                    <option value="{{$select['inx'] ? $loop->index : $option}}">{{$option}}</option>
                @endforeach
            </select>
        @endforeach

    </div>

    @foreach ($histories as $history)
        <div class="d-flex p-1">
            <div class=""><div class="bg-primary rounded pl-1 pr-1 mr-1">{{$history->created_at->diffForHumans()}}</div></div>
            <div>{{$history->details}}</div>
        </div>
    @endforeach

    @php
        // dd($subjects);
    @endphp
</div>
