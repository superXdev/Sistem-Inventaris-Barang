<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Supplier extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['nama', 'alamat', 'telepon', 'catatan'];

    // log configuration
    protected static $logAttributes = ['nama', 'alamat', 'telepon', 'catatan'];
    protected static $igonoreChangedAttributes = ['updated_at'];
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'supplier';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} supplier";
    }


    public function barang_masuks()
    {
    	return $this->hasMany(BarangMasuk::class);
    }
}
