<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Quest extends Model
{
    use HasFactory;

    protected $table = 'quests';

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'checked',
        'color'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'checked' => 'boolean',
    ];

    public const STATUS_MENDATANG = 'mendatang';
    public const STATUS_TERLEWAT = 'terlewat';
    public const STATUS_SUDAH_DILAKUKAN = 'sudah_dilakukan';

    public const COLOR_MENDATANG = 'yellow';
    public const COLOR_TERLEWAT = 'red';
    public const COLOR_SUDAH_DILAKUKAN = 'green';

    /**
     * Menghitung status quest secara otomatis berdasarkan due_date dan checked
     */
    public function getStatusAttribute()
    {
        if ($this->checked) {
            return self::STATUS_SUDAH_DILAKUKAN;
        } elseif ($this->due_date && now()->greaterThan($this->due_date)) {
            return self::STATUS_TERLEWAT;
        } else {
            return self::STATUS_MENDATANG;
        }
    }

    /**
     * Menghitung warna berdasarkan status quest
     */
    public function getColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_MENDATANG => self::COLOR_MENDATANG,
            self::STATUS_TERLEWAT => self::COLOR_TERLEWAT,
            self::STATUS_SUDAH_DILAKUKAN => self::COLOR_SUDAH_DILAKUKAN,
            default => 'gray',
        };
    }
}
