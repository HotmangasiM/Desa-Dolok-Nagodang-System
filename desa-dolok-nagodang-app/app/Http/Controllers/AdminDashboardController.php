<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Citizen;
use App\Models\Letter;
use App\Models\News;
use App\Models\Official;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // =============================
        // 📊 CITIZENS
        // =============================
        $totalCitizens = Citizen::count();
        $maleCitizens = Citizen::where('gender', 'Laki-laki')->count();
        $femaleCitizens = Citizen::where('gender', 'Perempuan')->count();

        // =============================
        // 👨‍💼 OFFICIALS
        // =============================
        $totalOfficials = Official::count();

        // =============================
        // 📰 NEWS
        // =============================
        $totalNews = News::count();
        $publishedNews = News::where('status', 'published')->count();

        // =============================
        // 📦 ASSETS
        // =============================
        $totalAssets = Asset::count();
        $goodAssets = Asset::where('condition', 'good')->count();

        // =============================
        // 📄 LETTERS
        // =============================
        $totalLetters = Letter::count();
        $submittedLetters = Letter::where('status', 'SUBMITTED')->count();
        $processedLetters = Letter::where('status', 'PROCESSING')->count();
        $completedLetters = Letter::where('status', 'COMPLETED')->count();

        $recentLetters = Letter::with(['letterType', 'citizen'])
            ->latest('submission_date')
            ->latest('id')
            ->take(5)
            ->get();

        // =============================
        // 📊 LETTER PER MONTH
        // =============================
        $currentYear = now()->year;

        $lettersByMonth = Letter::query()
            ->whereYear('submission_date', $currentYear)
            ->whereNotNull('submission_date')
            ->pluck('submission_date')
            ->countBy(fn ($date): int => (int) $date->format('n'));

        $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyData = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = (int) ($lettersByMonth[$i] ?? 0);
        }

        $dusunStats = Citizen::query()
            ->whereNotNull('address')
            ->pluck('address')
            ->map(function (string $address): string {
                return str($address)->squish()->explode(' ')->take(2)->implode(' ');
            })
            ->filter()
            ->countBy()
            ->sortKeys()
            ->map(fn (int $total, string $dusun): object => (object) [
                'dusun' => $dusun,
                'total' => $total,
            ])
            ->values();

        // format untuk chart
        $dusunLabels = $dusunStats->pluck('dusun');
        $dusunData = $dusunStats->pluck('total');

        return view('admin.dashboard.index', [
            'title' => 'Admin Desa - Dashboard',
            'pageTitle' => 'Dashboard',
            'pageDescription' => 'Ringkasan data sistem informasi desa.',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => null],
            ],

            // citizens
            'totalCitizens' => $totalCitizens,
            'maleCitizens' => $maleCitizens,
            'femaleCitizens' => $femaleCitizens,

            // officials
            'totalOfficials' => $totalOfficials,

            // news
            'totalNews' => $totalNews,
            'publishedNews' => $publishedNews,

            // assets
            'totalAssets' => $totalAssets,
            'goodAssets' => $goodAssets,

            // letters
            'totalLetters' => $totalLetters,
            'submittedLetters' => $submittedLetters,
            'processedLetters' => $processedLetters,
            'completedLetters' => $completedLetters,

            'recentLetters' => $recentLetters,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,

            // 🔥 NEW (dusun)
            'dusunLabels' => $dusunLabels,
            'dusunData' => $dusunData,
            'dusunStats' => $dusunStats,

            // alias kompatibilitas
            'allCitizens' => $totalCitizens,
            'allOfficials' => $totalOfficials,
            'allNews' => $totalNews,
            'allAssets' => $totalAssets,
            'allLetters' => $totalLetters,
            'approvedLetters' => $completedLetters,
        ]);
    }
}
