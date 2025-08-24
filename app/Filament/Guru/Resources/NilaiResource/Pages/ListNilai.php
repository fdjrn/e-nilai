<?php

namespace App\Filament\Guru\Resources\NilaiResource\Pages;

use App\Filament\Resources\NilaiResource;
use App\Filament\Widgets\FilterData;
use App\Filament\Widgets\NilaiInfo;
use App\Models\Nilai;
use App\Models\Rombel;
use App\Models\TahunAkademik;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListNilai extends ListRecords
{
    protected static string $resource = NilaiResource::class;
    protected ?string $heading = 'Input Nilai Akademik Siswa';
    protected static ?string $title = 'Nilai Akademik Siswa';

    public ?array $filters = [];
    public bool $filtered = false;

    protected function getHeaderWidgets(): array
    {
        return [
            FilterData::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            NilaiInfo::class,
        ];
    }

    protected $listeners = ['filter-updated' => 'applyFilter'];

    public function applyFilter(array $filters): void
    {
        $this->filters = $filters;
        $this->filtered = true;

        if (
            !empty($filters['tahun_akademik_id']) &&
            !empty($filters['kelas_id'])
        ) {
            $rombels = Rombel::query()
                ->where('tahun_akademik_id', $filters['tahun_akademik_id'])
                ->where('kelas_id', $filters['kelas_id'])
                ->get();

            $ta = TahunAkademik::find($filters['tahun_akademik_id']);
            $semester = $ta?->semester;

            foreach ($rombels as $rombel) {
                Nilai::firstOrCreate([
                    'tahun_akademik_id' => $rombel->tahun_akademik_id,
                    'semester' => $semester,
                    'kelas_id' => $rombel->kelas_id,
                    'siswa_id' => $rombel->siswa_id,
                    'mapel_id' => $filters['mapel_id'],
                ]);
            }
        }
        $this->resetTable();

    }

    protected function getTableQuery(): ?Builder
    {
        if (!$this->filtered) {
            return Nilai::query()->whereRaw('1=0');
        }

        return Nilai::query()
            ->where('tahun_akademik_id', $this->filters['tahun_akademik_id'] ?? null)
            ->where('kelas_id', $this->filters['kelas_id'] ?? null)
            ->where('mapel_id', $this->filters['mapel_id'] ?? null)
            ->with('siswa');
    }

}
