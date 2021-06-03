<div>
    <form wire:submit.prevent="upgrade">
        @error('bigProjectName') <span class="error text-red">{{ $message }}</span> @enderror
        <x-adminlte-input wire:model="bigProjectName" name="big" label="Big Project Name" placeholder="Enter Big Project Name" fgroup-class="" disable-feedback/>

        @error('subProjectName') <span class="error text-red">{{ $message }}</span> @enderror
        <x-adminlte-input wire:model="subProjectName" name="big" label="Sub Project Name" placeholder="Enter Sub Project Name" fgroup-class="" disable-feedback/>

        <x-adminlte-button type="submit" class="mr-auto" theme="warning" label="Upgrade"/>
    </form>
</div>
