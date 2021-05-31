@extends('adminlte::page')

@section('title', 'Your projects')

@section('content_header')
    <h1 class="m-0 text-dark">Your Projects</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                <x-adminlte-card title="A card without body"/>
                                <i class="fab fa-500px"></i>
                                <x-adminlte-card title="Purple Card" theme="purple" icon="fab fa-500px" removable collapsible>
                                    A removable and collapsible card with purple theme...
                                </x-adminlte-card>
                                <x-adminlte-card title="Info Card" theme="info" icon="fas fa-lg fa-bell" collapsible removable maximizable>
                                    An info theme card with all the tool buttons...
                                </x-adminlte-card>

                                <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
                                    <x-adminlte-button class="btn-lg" type="reset" label="Reset" theme="outline-danger" icon="fas fa-lg fa-trash"/>
                                <x-adminlte-button class="btn-sm bg-gradient-info" type="button" label="Help" icon="fas fa-lg fa-question"/>


                                <x-adminlte-input-slider name="isMin"/>

                                {{-- Disabled --}}
                                <x-adminlte-input-slider name="isDisabled" disabled/>

                                {{-- With min, max, step and value --}}
                                <x-adminlte-input-slider name="isMinMax" min=5 max=15 step=0.5 value=11.5 color="purple"/>

                                {{-- Label, prepend icon and sm size --}}
                                <x-adminlte-input-slider name="isSizeSm" label="Slider" igroup-size="sm"
                                    color="#3c8dbc" data-slider-handle="square">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-lightblue">
                                            <i class="fas fa-sliders-h"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-slider>

                                {{-- With slots, range mode and lg size --}}
                                @php
                                $config = [
                                    'handle' => 'square',
                                    'range' => true,
                                    'value' => [3, 8],
                                ];
                                @endphp
                                <x-adminlte-input-slider name="isSizeLg" label="Range" size="lg"
                                    color="orange" label-class="text-orange" :config="$config">
                                    <x-slot name="prependSlot">
                                        <x-adminlte-button theme="warning" icon="fas fa-minus" title="Decrement"/>
                                    </x-slot>
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button theme="warning" icon="fas fa-plus" title="Increment"/>
                                    </x-slot>
                                </x-adminlte-input-slider>

                                {{-- Vertical slider with ticks --}}
                                @php
                                $config = [
                                    'value' => 150,
                                    'orientation' => 'vertical',
                                    'ticks' => [0, 100, 200, 300],
                                    'ticks_labels' => ['$0', '$100', '$200', '$300'],
                                ];
                                @endphp
                                <x-adminlte-input-slider name="isVertical" label="Vertical" color="#77dd77"
                                    label-class="text-olive" :config="$config"/>



                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

