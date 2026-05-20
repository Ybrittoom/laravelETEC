<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClockEntry;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboadController extends Controller
{
    // Rota /dashboard - Unificada com as estatísticas antigas e novas
    public function index()
    {
        // 1. Mantendo a sua lógica original
        $totalUsuarios = User::count();

        // 2. Nova lógica do Controle de Ponto
        $today = Carbon::today()->toDateString();
        $user = Auth::user();

        // Ponto do usuário logado hoje
        $myTodayClock = ClockEntry::where('user_id', $user->id)->where('date', $today)->first();

        // --- LÓGICA DO GRÁFICO (Últimos 7 dias) ---
        $last7Days = collect(range(6, 0))->map(function($i) {
            return Carbon::today()->subDays($i)->toDateString();
        });

        // Buscar todos os usuários e seus pontos nos últimos 7 dias
        $users = User::with(['clockEntries' => function($query) use ($last7Days) {
            $query->whereIn('date', $last7Days);
        }])->get();

        $chartData = [
            'labels' => $last7Days->map(fn($date) => Carbon::parse($date)->format('d/m'))->toArray(),
            'datasets' => []
        ];

        // Cores aleatórias para diferenciar os usuários no gráfico
        foreach ($users as $u) {
            $hoursData = [];
            foreach ($last7Days as $date) {
                $entry = $u->clockEntries->firstWhere('date', $date);
                // Converte minutos trabalhados em horas (ex: 480 min = 8.0 horas)
                $hoursData[] = $entry ? round($entry->total_minutes / 60, 2) : 0;
            }

            $chartData['datasets'][] = [
                'label' => $u->name,
                'data' => $hoursData,
                'borderColor' => '#' . substr(md5(rand()), 0, 6), // Corrigido para md5
                'fill' => false,
                'tension' => 0.1
            ];
        }

        // --- RANKING QUEM TRABALHOU MAIS ---
        $ranking = ClockEntry::where('date', $today)
            ->with('user')
            ->orderBy('total_minutes', 'desc')
            ->get();

        // Retorna a view com TODOS os dados compactados
        return view('dashboard', compact('totalUsuarios', 'myTodayClock', 'chartData', 'ranking'));
    }

    // Rota /home — redireciona para o dashboard (Mantido original)
    public function home()
    {
        return redirect()->route('dashboard');
    }

    // Nova action para processar as batidas de ponto
    public function registerClock(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        $clock = ClockEntry::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today]
        );

        // Lógica sequencial para bater o ponto
        if (!$clock->clock_in) {
            $clock->clock_in = $now;
            $msg = "Entrada registrada com sucesso!";
        } elseif (!$clock->lunch_start) {
            $clock->lunch_start = $now;
            $msg = "Saída para o almoço registrada!";
        } elseif (!$clock->lunch_end) {
            $clock->lunch_end = $now;
            $msg = "Retorno do almoço registrado!";
        } elseif (!$clock->clock_out) {
            $clock->clock_out = $now;
            $msg = "Saída final registrada! Bom descanso.";
        } else {
            return redirect()->back()->with('error', 'Você já realizou todas as marcações de hoje.');
        }

        // Atualiza a carga horária líquida do dia usando a função do Model
        $clock->total_minutes = $clock->calculateTotalMinutes();
        $clock->save();

        return redirect()->back()->with('success', $msg);
    }
}