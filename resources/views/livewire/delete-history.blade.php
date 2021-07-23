<div>
    @php
        function monthS(int $months): String{
            return $months . ' month' . ($months > 1 ? 's' : '');
        }
    @endphp

    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <p>Projects History Items Count: {{App\Models\ProjectsHistory::count()}}</p>

    <div class="d-flex align-items-center">
        <p class="mb-0 mr-1">Delete all projects history item older than </p>
        <select wire:model="monthsAfterToDelete">
            @foreach ([0,1,2,3,4,6,8,10,12,18,24,36] as $n)
                <option value="{{$n}}" {{$n == 3 ? 'selected' : ''}}>{{monthS($n)}}</option>
            @endforeach
        </select>
    </div>

    <div class="d-flex align-items-center mt-2 mr-2">
        <p class="mb-0 mr-1">
            Projects History Items older than
            {{monthS($monthsAfterToDelete)}}
            Count: {{$toDeleteCount}}
        </p>

        {{-- Example button to open modal --}}
        <x-adminlte-button label="Delete" data-toggle="modal" data-target="#modalDeleteHistory" class="bg-danger"/>
    </div>


    <x-adminlte-modal id="modalDeleteHistory" title="Delete Projects History?" theme="danger" icon="fa fa-lg fa-fw fa-trash">
        <p class="font-weight-bold">Delete all projects history item older than {{monthS($monthsAfterToDelete)}} ({{$toDeleteCount}})?</p>
        <x-slot name="footerSlot">
            <x-adminlte-button wire:click="comfirmDelete" class="mr-auto" theme="danger" label="Yes, delete!"/>
            <x-adminlte-button theme="info" label="No, don't do it!" data-dismiss="modal"/>
        </x-slot>
    </x-adminlte-modal>
</div>
