<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Gudang extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['kode', 'nama', 'catatan'];

    // log configuration
    protected static $logAttributes = ['kode', 'nama', 'catatan'];
    protected static $igonoreChangedAttributes = ['updated_at'];
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'warehouse';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} warehouse";
    }


    public function barangs()
    {
    	return $this->hasMany(Barang::class);
    }
}
