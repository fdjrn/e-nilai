{{--<x-filament::widget class="w-full">--}}
{{--    <x-filament::card>--}}
{{--        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">--}}
{{--            {{ $this->form }}--}}
{{--        </div>--}}
{{--    </x-filament::card>--}}
{{--</x-filament::widget>--}}


<x-filament-widgets::widget>
    <x-filament::section>
        {{ $this->form }}
    </x-filament::section>
</x-filament-widgets::widget>
