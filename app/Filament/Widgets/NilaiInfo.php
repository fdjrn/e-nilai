<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class NilaiInfo extends Widget
{
    protected static string $view = 'filament.resources.nilai-resource.widgets.nilai-info';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isDiscovered = false;

    public $info = [
        'nslm' => 'Nilai Satuan Lingkup Materi (contoh: 1–100)',
        'nsas' => 'Nilai Sumatif Akhr Semester (contoh: 1–100)',
        'rata_nslm' => 'Rata-rata nilai TP1–TP7 (hanya > 0)',
        'nr' => 'Nilai Raport = 60% x Rata_nslm + 40% x NSAS',
    ];
}
