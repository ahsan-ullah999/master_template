<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Member;
use App\Models\ProductOrder;
use App\Models\Routine;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class DashboardController extends Controller
{

    public function index()
    {
        $companies = Company::orderBy('name')->get();
        return view('dashboard', compact('companies'));
    }


    public function routineMeals()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // Today's routines (based on either fixed date or matching day_of_week)
        $todaysMeals = Routine::with('slot')
            ->whereDate('date', $today)
            //->orWhere('day_of_week', $today->dayOfWeek)
            ->orderBy('slot_id')
            ->get();

        // Tomorrow's routines (either date or weekday)
        $nextDayMeals = Routine::with('slot')
            ->whereDate('date', $tomorrow)
            //->orWhere('day_of_week', $tomorrow->dayOfWeek)
            ->orderBy('slot_id')
            ->get();

        return response()->json([
            'today' => $todaysMeals,
            'tomorrow' => $nextDayMeals,
        ]);
    }

    // Provide stats for AJAX
    

    public function stats(Request $request)
    {
        $filters = $request->only(['company_id','branch_id','building_id','floor_id','flat_id','room_id']);

        $query = Member::query();
        foreach ($filters as $col => $val) {
            if ($val) $query->where($col, $val);
        }

        $totalMembers = $query->count();

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $yesterday = Carbon::yesterday();

        // Meals from ProductOrders (as before)
        $lastDayOrders = ProductOrder::whereDate('order_date',$yesterday)->count();
        $deliveredMeals = ProductOrder::whereDate('order_date',$yesterday)->where('status','delivered')->count();

        // 🔹 Routines for today
        $todaysMeals = Routine::whereDate('date', $today)
            ->orWhere('day_of_week', $today->dayOfWeek)
            ->count();

        // 🔹 Routines for tomorrow
        $nextDayMeals = Routine::whereDate('date', $tomorrow)
            ->orWhere('day_of_week', $tomorrow->dayOfWeek)
            ->count();

        return response()->json(compact(
            'totalMembers','todaysMeals','nextDayMeals','lastDayOrders','deliveredMeals'
        ));
    }


}
