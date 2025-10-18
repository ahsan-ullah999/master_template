<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Notice;
use App\Models\ProductOrder;
use App\Models\Routine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user->member; // ✅ direct one-to-one relationship

        if (!$member) {
            abort(403, 'No member profile linked to this user.');
        }

        $member->load(['company', 'branch', 'building', 'floor', 'flat', 'room', 'seats']);

        $shortProfile = [
            'name'       => $member->name,
            'email'      => $member->email,
            'phone'      => $member->phone,
            'company'    => $member->company->name ?? '',
            'branch'     => $member->branch->name ?? '',
            'building'   => $member->building->name ?? '',
            'seat'       => $member->seats->pluck('seat_number')->join(', '),
        ];

        $today = Carbon::today();
        $time = Carbon::now()->format('h:i A');
        $formattedDate = Carbon::now()->format('l, d F Y');

        $routines = Routine::with(['slot', 'items.product', 'items.alternative'])
            ->whereDate('date', $today)
            ->get();

        $todayOrders = ProductOrder::with(['routine.slot'])
            ->where('member_id', $member->id)
            ->whereDate('order_date', $today)
            ->get();

        $notices = Notice::whereMonth('created_at', Carbon::now()->month)
            ->orderByDesc('created_at')
            ->get();

        return view('member.dashboard', compact(
            'shortProfile',
            'time',
            'formattedDate',
            'routines',
            'todayOrders',
            'notices'
        ));
    }

}
