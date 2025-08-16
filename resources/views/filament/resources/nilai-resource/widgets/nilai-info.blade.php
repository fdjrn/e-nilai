<x-filament-widgets::widget>
    <x-filament::section>
        <h2 class="p-2 pb-4 text-l font-bold ">{{ strtoupper('keterangan')}}</h2>
        <hr/>
        <div class="p-2 rounded-lg shadow-inner text-sm ">
            <ul class="space-y-1">
                @foreach ($info as $key => $desc)
                    <li><strong>{{ strtoupper($key) }}:</strong> {{ $desc }}</li>
                @endforeach
            </ul>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
