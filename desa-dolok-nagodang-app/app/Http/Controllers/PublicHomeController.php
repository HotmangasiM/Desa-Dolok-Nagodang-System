<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\LetterType;
use App\Models\News;
use App\Models\Official;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\VisitorLog;
use Carbon\Carbon;

class PublicHomeController extends Controller
{
    public function index(): View
    {
        // Statistik penduduk
        $totalCitizens = Citizen::count();

        $maleCitizens = Citizen::where('gender', 'Laki-laki')->count();

        $femaleCitizens = Citizen::where('gender', 'Perempuan')->count();

        // Statistik dusun dari field address
        $dusunStats = DB::table(function ($query) {
            $query->selectRaw("SUBSTRING_INDEX(address, ' ', 2) as dusun")
                ->from('citizens')
                ->whereNotNull('address')
                ->where('address', '!=', '');
        }, 't')
            ->select('dusun', DB::raw('COUNT(*) as total'))
            ->groupBy('dusun')
            ->orderBy('dusun')
            ->get();

        // Berita terbaru
        $latestNews = News::where('status', 'published')
            ->latest('published_at')
            ->latest('id')
            ->take(3)
            ->get();

        $totalPublishedNews = News::where('status', 'published')->count();

        // Aparat desa
        $officials = Official::orderBy('sort_order')
            ->orderBy('created_at')
            ->get();

        $villageHead = Official::where('position', 'like', '%Kepala Desa%')
            ->latest()
            ->first();

        // Layanan surat
        $letterTypes = LetterType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $totalLetterTypes = $letterTypes->count();

        /**
         * Statistik pengunjung
         */
        $today = now()->toDateString();

        $yesterday = now()->subDay()->toDateString();

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $startOfLastWeek = now()->subWeek()->startOfWeek();
        $endOfLastWeek = now()->subWeek()->endOfWeek();

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        $visitorStats = [
            'today' => VisitorLog::whereDate('visited_date', $today)->count(),

            'yesterday' => VisitorLog::whereDate('visited_date', $yesterday)->count(),

            'this_week' => VisitorLog::whereBetween('visited_date', [
                $startOfWeek,
                $endOfWeek
            ])->count(),

            'last_week' => VisitorLog::whereBetween('visited_date', [
                $startOfLastWeek,
                $endOfLastWeek
            ])->count(),

            'this_month' => VisitorLog::whereBetween('visited_date', [
                $startOfMonth,
                $endOfMonth
            ])->count(),

            'last_month' => VisitorLog::whereBetween('visited_date', [
                $startOfLastMonth,
                $endOfLastMonth
            ])->count(),

            'total' => VisitorLog::count(),
        ];

        return view('public.home', [
            'title' => 'Website Resmi Desa Dolok Nagodang',

            'totalCitizens' => $totalCitizens,
            'maleCitizens' => $maleCitizens,
            'femaleCitizens' => $femaleCitizens,
            'dusunStats' => $dusunStats,

            'latestNews' => $latestNews,
            'totalPublishedNews' => $totalPublishedNews,

            'officials' => $officials,
            'villageHead' => $villageHead,

            'letterTypes' => $letterTypes,
            'totalLetterTypes' => $totalLetterTypes,

            'visitorStats' => $visitorStats,
        ]);
    }
}