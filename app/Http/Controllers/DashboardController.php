<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Charge;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Geral
        $totalPaid = Charge::where('status', 'paid')->sum('amount');
        $totalPending = Charge::where('status', 'pending')->sum('amount');

        // Mês atual
        $monthlyPaid = Charge::where('status', 'paid')
            ->whereBetween('payment_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyPending = Charge::where('status', 'pending')
            ->whereBetween('due_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Organizações: quem pagou / não pagou
        $organizationsThatPaid = Charge::where('status', 'paid')
            ->distinct('organization_id')
            ->pluck('organization_id');

        $organizationsCount = Organization::count();
        $orgsPaid = $organizationsThatPaid->count();
        $orgsNotPaid = $organizationsCount - $orgsPaid;

        // Dados para gráfico: entradas pagas por mês
        $year = $request->input('year', $now->year);

        $graphData = Charge::select(
            DB::raw("TO_CHAR(payment_date, 'YYYY-MM') as month"),
            DB::raw("SUM(amount) as total_paid")
        )
            ->where('status', 'paid')
            ->whereYear('payment_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'general' => [
                'total_paid' => $totalPaid,
                'total_pending' => $totalPending,
                'orgs_paid' => $orgsPaid,
                'orgs_not_paid' => $orgsNotPaid,
            ],
            'current_month' => [
                'paid' => $monthlyPaid,
                'pending' => $monthlyPending,
            ],
            'chart' => $graphData,
        ]);
    }
}
