<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Barang extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['kode', 'nama', 'jumlah', 'kondisi', 'gudang_id'];

    // log configuration
    protected static $logAttributes = ['kode', 'nama', 'jumlah', 'kondisi'];
    protected static $igonoreChangedAttributes = ['updated_at'];
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'goods';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} goods";
    }

    public function barang_masuks()
    {
    	return $this->hasMany(BarangMasuk::class);
    }

    public function gudang()
    {
    	return $this->belongsTo(Gudang::class);
    }
}
