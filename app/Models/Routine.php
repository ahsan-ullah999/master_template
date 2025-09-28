<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $fillable = [
        'company_id','branch_id','building_id','floor_id','flat_id','room_id',
        'slot_id','day_of_week','date','product_count','notes'
    ];

    public function slot() { return $this->belongsTo(Slot::class); }
    public function product() { return $this->belongsTo(Product::class); }

    // new
    public function items()
    {
        return $this->hasMany(RoutineItem::class)->orderBy('position');
    }

    public function company() { return $this->belongsTo(\App\Models\Company::class,'company_id'); }
    public function branch() { return $this->belongsTo(\App\Models\Branch::class,'branch_id'); }
    public function building() { return $this->belongsTo(\App\Models\Building::class,'building_id'); }
    public function floor() { return $this->belongsTo(\App\Models\Floor::class,'floor_id'); }
    public function flat() { return $this->belongsTo(\App\Models\Flat::class,'flat_id'); }
    public function room() { return $this->belongsTo(\App\Models\Room::class,'room_id'); }

    /**
     * Convenience: returns day name or '-' when not set
     */
    public function dayName()
    {
        if ($this->day_of_week === null) return '-';
        $names = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        return $names[(int)$this->day_of_week] ?? '-';
    }

    /**
     * Find routine for a given date/slot and optional scope (unchanged).
     */
    public static function findForDateSlot(\Carbon\Carbon $date, $slotId, array $scope = [])
    {
        $query = self::where('slot_id',$slotId)->where('date',$date->toDateString());
        foreach ($scope as $col => $val) {
            $query->where(function($q) use ($col,$val){
                $q->whereNull($col)->orWhere($col,$val);
            });
        }
        $routine = $query->orderByDesc('id')->first();
        if ($routine) return $routine;

        $dow = $date->dayOfWeek;
        $query = self::where('slot_id',$slotId)->where('day_of_week',$dow);
        foreach ($scope as $col => $val) {
            $query->where(function($q) use ($col,$val){
                $q->whereNull($col)->orWhere($col,$val);
            });
        }
        return $query->orderByDesc('id')->first();
    }
}
