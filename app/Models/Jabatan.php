<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Traits\HasEncryptedRouteKey;

class Jabatan extends Model
{
    use HasEncryptedRouteKey;

    public const DEFAULT_ESELON_OPTIONS = [
        'II.a',
        'II.b',
        'III.a',
        'III.b',
        'IV.a',
        'IV.b',
    ];

    public const EXCLUDED_ESELON_OPTIONS = [
        'I.a',
        'I.b',
    ];
    
    protected $table = 'jabatan';
    
    protected $fillable = [
        'kode',
        'nama',
        'eselon',
        'tunjangan',
        'keterangan',
    ];

    protected $casts = [
        'tunjangan' => 'decimal:2',
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

    public static function eselonOptions(): Collection
    {
        $existing = static::query()
            ->whereNotNull('eselon')
            ->where('eselon', '!=', '')
            ->distinct()
            ->pluck('eselon')
            ->map(fn ($value) => trim((string) $value))
            ->reject(fn ($value) => in_array($value, self::EXCLUDED_ESELON_OPTIONS, true))
            ->filter();

        $orderMap = array_flip(self::DEFAULT_ESELON_OPTIONS);

        return collect(self::DEFAULT_ESELON_OPTIONS)
            ->merge($existing)
            ->unique()
            ->sort(function ($a, $b) use ($orderMap) {
                $aIndex = $orderMap[$a] ?? 999;
                $bIndex = $orderMap[$b] ?? 999;

                if ($aIndex === $bIndex) {
                    return strcasecmp($a, $b);
                }

                return $aIndex <=> $bIndex;
            })
            ->values();
    }
}
