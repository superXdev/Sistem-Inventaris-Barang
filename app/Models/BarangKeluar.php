<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BarangKeluar extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['penerima', 'berat', 'barang_id', 'harga', 'jumlah'];

    // log configuration
    protected static $logAttributes = ['berat', 'harga', 'jumlah', 'penerima'];
    protected static $igonoreChangedAttributes = ['updated_at'];
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'goods';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} stock-out";
    }


    public function barang()
    {
    	return $this->belongsTo(Barang::class);
    }
}
