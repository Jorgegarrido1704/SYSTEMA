<?php

namespace App\Jobs;

use App\Models\listasDeCorte;
use App\Models\maintainRoutings;
use App\Models\routingModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB; // REQUERIDO para extraer elementos aleatorios de tus arrays

class updateRoutingsTimes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $setHeadShrink = [2.157, 3.134, 2.645, 3.44, 3.88];
        $burnHeatGun = [5.84, 5.44, 6.15, 6.05, 5.77];
        $setSplice = [1.15, 1.25, 1.3, 1.05, 1.18];
        $applySpleceInMachine = [4, 4.23, 4.15, 4.05, 4.84, 5.1, 5.05, 4.15, 4.33, 4.25];
        $plugIn = [3.95, 5.15, 4.84, 5.05, 4.23, 4.15, 4.05, 4.84, 5.1, 5.05, 4.15, 4.33, 4.25];
        $twistMm = [0.047, 0.050, 0.040, 0.043, 0.039, 0.050, 0.049, 0.043, 0.049, 0.054, 0.044, 0.053, 0.045, 0.039, 0.053, 0.048, 0.038, 0.056, 0.035, 0.054, 0.042, 0.039, 0.046, 0.043, 0.036, 0.042, 0.050, 0.054, 0.039, 0.052, 0.052, 0.038, 0.053, 0.039, 0.052, 0.037, 0.047, 0.052, 0.051, 0.053, 0.055, 0.043, 0.054, 0.050, 0.048, 0.040, 0.039, 0.036, 0.055, 0.040];
        $corte = [0.0033, 0.0038, 0.0040, 0.0036, 0.0033, 0.0035, 0.0041, 0.0039, 0.0029, 0.0037, 0.0042, 0.0036, 0.0037, 0.0036, 0.0044, 0.0041, 0.0040, 0.0033, 0.0043, 0.0039, 0.0045, 0.0037, 0.0043, 0.0036, 0.0036, 0.0039, 0.0037, 0.0037, 0.0028, 0.0031, 0.0044, 0.0033, 0.0031, 0.0031, 0.0039, 0.0043, 0.0034, 0.0043, 0.0036, 0.0037, 0.0041, 0.0039, 0.0043, 0.0041, 0.0045, 0.0042, 0.0037, 0.0035, 0.0030, 0.0030, 0.0028, 0.0032, 0.0036, 0.0031, 0.0036, 0.0033, 0.0037, 0.0033, 0.0043, 0.0044, 0.0039, 0.0029, 0.0032, 0.0043, 0.0032, 0.0030, 0.0043, 0.0031, 0.0044, 0.0037, 0.0041, 0.0033, 0.0037, 0.0035, 0.0034, 0.0042, 0.0043, 0.0032, 0.0036, 0.0036, 0.0030, 0.0036, 0.0031, 0.0044, 0.0042, 0.0043, 0.0045, 0.0028, 0.0042, 0.0038, 0.0043, 0.0043, 0.0036, 0.0042, 0.0042, 0.0035, 0.0044, 0.0035, 0.0034, 0.0039, 0.0045, 0.0031, 0.0031, 0.0042, 0.0040, 0.0032, 0.0035, 0.0031, 0.0034, 0.0036, 0.0031, 0.0037, 0.0044, 0.0036, 0.0042, 0.0029, 0.0041, 0.0040, 0.0040, 0.0037, 0.0031, 0.0030, 0.0038, 0.0040, 0.0044, 0.0041, 0.0033, 0.0028, 0.0031, 0.0030, 0.0038, 0.0036, 0.0033, 0.0041, 0.0031, 0.0032, 0.0029, 0.0038, 0.0030, 0.0038, 0.0043, 0.0034, 0.0043, 0.0033, 0.0031, 0.0031, 0.0039, 0.0029, 0.0033, 0.0032, 0.0037, 0.0035, 0.0034, 0.0035, 0.0028, 0.0032, 0.0037, 0.0032, 0.0041, 0.0030, 0.0028, 0.0031, 0.0036, 0.0040, 0.0036, 0.0038, 0.0040, 0.0034, 0.0037, 0.0030, 0.0029, 0.0031, 0.0037, 0.0036, 0.0028, 0.0042, 0.0035, 0.0031, 0.0031, 0.0035, 0.0037, 0.0039, 0.0029, 0.0029, 0.0028, 0.0038, 0.0039, 0.0028, 0.0028, 0.0034, 0.0037, 0.0043, 0.0032, 0.0036, 0.0030, 0.0043, 0.0040, 0.0034, 0.0032, 0.0041, 0.0040, 0.0035, 0.0035, 0.0030, 0.0038, 0.0031, 0.0040, 0.0044, 0.0044, 0.0031, 0.0030, 0.0033, 0.0038, 0.0043, 0.0044, 0.0033, 0.0029, 0.0042, 0.0035, 0.0042, 0.0035, 0.0038, 0.0042, 0.0035, 0.0039, 0.0029, 0.0041, 0.0029, 0.0029, 0.0044, 0.0045, 0.0032, 0.0030, 0.0040, 0.0034, 0.0038, 0.0041, 0.0034, 0.0029, 0.0036, 0.0041, 0.0030, 0.0029, 0.0037, 0.0045, 0.0037, 0.0036, 0.0042, 0.0035, 0.0036, 0.0029, 0.0032, 0.0043, 0.0029, 0.0045, 0.0030, 0.0035, 0.0034, 0.0037, 0.0029, 0.0035, 0.0030, 0.0035, 0.0035, 0.0030, 0.0036, 0.0043, 0.0037, 0.0039, 0.0032, 0.0035, 0.0036, 0.0037, 0.0038, 0.0032, 0.0042, 0.0037, 0.0029, 0.0034, 0.0044, 0.0040, 0.0039, 0.0043, 0.0045, 0.0043, 0.0035, 0.0031, 0.0029, 0.0033, 0.0040, 0.0028, 0.0029, 0.0035, 0.0041, 0.0032, 0.0033, 0.0036, 0.0037, 0.0039, 0.0034, 0.0040, 0.0030, 0.0043, 0.0037, 0.0037, 0.0032, 0.0028, 0.0031, 0.0042, 0.0040, 0.0036, 0.0037, 0.0034, 0.0036, 0.0036, 0.0032, 0.0044, 0.0040, 0.0035, 0.0033, 0.0038, 0.0033, 0.0041, 0.0036, 0.0045, 0.0044, 0.0032, 0.0028, 0.0043, 0.0033, 0.0034, 0.0043, 0.0030, 0.0043, 0.0030, 0.0043, 0.0033, 0.0037, 0.0044, 0.0040, 0.0044, 0.0029, 0.0031, 0.0035, 0.0034, 0.0030, 0.0037, 0.0041, 0.0035, 0.0045, 0.0038, 0.0032, 0.0033, 0.0042, 0.0040, 0.0035, 0.0043, 0.0033, 0.0043, 0.0044, 0.0038, 0.0043, 0.0029, 0.0036, 0.0039, 0.0042, 0.0041, 0.0039, 0.0034, 0.0044, 0.0037, 0.0040, 0.0042, 0.0030, 0.0030, 0.0040, 0.0043, 0.0043, 0.0029, 0.0033, 0.0038, 0.0030, 0.0028, 0.0042, 0.0033, 0.0044, 0.0034, 0.0042, 0.0040, 0.0045, 0.0044, 0.0042, 0.0040, 0.0030, 0.0045, 0.0043, 0.0028, 0.0037, 0.0033, 0.0039, 0.0032, 0.0032, 0.0028, 0.0042, 0.0039, 0.0032, 0.0040, 0.0033, 0.0042, 0.0041, 0.0035, 0.0041, 0.0036, 0.0032, 0.0031, 0.0044, 0.0035, 0.0038, 0.0044, 0.0031, 0.0042, 0.0034, 0.0031, 0.0036, 0.0029, 0.0043, 0.0037, 0.0028, 0.0040, 0.0032, 0.0044, 0.0029, 0.0040, 0.0035, 0.0043, 0.0033, 0.0035, 0.0043, 0.0045, 0.0043, 0.0034, 0.0034, 0.0042, 0.0037, 0.0030, 0.0031, 0.0030, 0.0033, 0.0034, 0.0031, 0.0038, 0.0033, 0.0041, 0.0041, 0.0041, 0.0045, 0.0029, 0.0039, 0.0036, 0.0029, 0.0029, 0.0045, 0.0039, 0.0038, 0.0033, 0.0038, 0.0039, 0.0029, 0.0039, 0.0029, 0.0043, 0.0037, 0.0031, 0.0037, 0.0030, 0.0040, 0.0036, 0.0042, 0.0033, 0.0037, 0.0040, 0.0033, 0.0032, 0.0040, 0.0042, 0.0032, 0.0030, 0.0032, 0.0032, 0.0040, 0.0030, 0.0033, 0.0036, 0.0041, 0.0043, 0.0044, 0.0045, 0.0039, 0.0041, 0.0037];
        $tinSet = [6.289, 8.789, 5.186, 6.112, 5.018, 4.679, 7.627, 7.648, 5.066, 5.214, 6.552, 6.809, 5.843, 6.601, 6.616, 6.404, 5.452, 6.360, 6.087, 6.787, 5.186, 6.724, 6.963, 6.132, 5.440, 6.189, 6.601, 5.501, 6.955, 6.774, 6.720, 5.638, 6.560, 6.206, 6.888, 5.603, 6.158, 6.304, 6.389, 5.488, 6.798, 6.524, 5.760, 6.974, 6.300, 6.179, 5.986, 6.943, 6.908, 6.513, 5.208, 6.330, 6.178, 6.286, 5.979, 6.601, 6.080, 5.516, 6.524, 6.785, 6.799, 5.851, 6.711, 6.016, 6.919, 5.641, 6.049, 6.557, 6.652, 5.407, 6.022, 6.933, 5.058, 6.619, 6.413, 6.497, 5.714, 6.149, 6.285, 6.688, 5.959, 6.728, 6.544, 6.338, 5.141, 6.631, 6.295, 6.712, 5.216, 6.051, 6.723, 5.847, 6.475, 6.761, 6.650, 5.378, 6.306, 6.235, 6.484, 5.301, 6.295, 6.046, 6.831, 5.735, 6.831, 6.427, 5.687, 6.062, 6.603, 6.229, 5.408, 6.753];
        $setSealTime = [8.284, 6.299, 6.816, 6.810, 7.979, 5.776, 6.301, 8.726, 6.847, 5.841, 5.525, 7.982, 6.349, 5.572, 8.371, 7.960, 6.498, 7.941, 7.311, 5.911, 5.463, 5.962, 6.082, 6.965, 6.381, 5.815, 8.357, 8.009, 6.493, 5.557, 6.187, 5.454, 5.724, 6.545, 7.384, 5.895, 7.530, 6.148, 6.863, 5.777, 8.533, 5.469, 7.376, 6.244, 6.143, 6.971, 7.579, 6.697];
        $loomingTime = [9.09347015229888, 11.4200808883884, 9.09894134418457, 9.98362268442559, 10.7049662465539, 11.1075551669628, 10.9722037066511, 9.0263837478315, 12.4387004686721, 9.65205478158289, 11.5668723725776, 10.3415977854312, 11.9663717283251, 10.175275427593, 11.6973524607737, 11.0543452140643, 11.9876478380792, 11.3578828539977, 11.0599598394668, 9.36468478424024, 10.7685688062687, 10.7854656442101, 9.88307060070758, 11.7074189652612, 10.948877453327, 12.2662054034385, 11.2836881053431, 9.3419943631346, 10.7203033645858, 9.72766628833672, 11.2264973101293, 10.3836193962763, 11.0362884056142, 10.9366200134748, 11.9040962688853, 11.8599758515516, 10.852680264818, 10.4980482635134, 10.93500884067, 10.7933399676839, 10.7781191041112, 10.0469944158269, 11.1888977139395, 9.85664297842095, 11.850257134896, 11.393911023163, 10.2609643038759, 10.0469300715228, 12.2843344548904, 9.26281043559292, 11.4099999776553];
        $routingBoardTime = [5.635, 4.16, 4.625, 8.085, 7.32, 4.455, 5.94, 5.745, 7.06, 5.12, 5.95, 4.41, 7.18, 4.04, 5.03, 6.255, 6.29, 8.165, 5.15, 7.59, 3.635, 8.215, 7, 7.455, 6.695, 4.02, 7.395, 6.9, 6.135, 5.575]; // (Truncado visualmente)

        $NoRequeridas = ['TT2-139'];

        // Estaciones de trabajo a limpiar
        $worksToDelete = [
            '10001', '11501', '11701', '10061', '10081', '10951',
            '10960', '10381', '10431', '10361', '10401', '10341',
            '10301', '11001', '10601', '11101', '10701', '11000',
            '11050', '10801', '10901',
        ];

        // 1. Obtener los PNs que están pendientes (Cambiado de 'Pendinete' a 'Pendiente' si es necesario corregir typos)
        $deledataPN = maintainRoutings::where('routing_status', 'Pendiente')
            ->orderBy('id', 'DESC')
            ->limit(30)
            ->pluck('pn')
            ->toArray();

        if (empty($deledataPN)) {
            return;
        }

        // Ejecutar todo el proceso masivo en una transacción SQL única por seguridad y rendimiento
        DB::transaction(function () use ($deledataPN, $worksToDelete, $corte, $twistMm, $setSealTime, $plugIn, $routingBoardTime, $tinSet, $setHeadShrink, $burnHeatGun, $setSplice, $applySpleceInMachine, $loomingTime, $NoRequeridas) {

            // Limpieza masiva inicial
            routingModel::whereIn('pn_routing', $deledataPN)
                ->whereIn('work_routing', $worksToDelete)
                ->delete();

            $bulkInserts = [];

            // 2. Procesamiento principal por cada Número de Parte (PN)
            foreach ($deledataPN as $np) {

                $totalCircuitsCorte = 0;
                $agrupadoTwist = [];
                $terminalesConteo1 = [];
                $terminalesConteo2 = [];
                $terminalesSello1 = [];
                $terminalesSello2 = [];
                $totalSoldar = 0;
                $cantidadMangas = 0;
                $tipoSplice = [];

                // --- A. CONSULTA CON ELOQUENT A LISTASCORTE ---
                $buscarCorte = listasDeCorte::where('pn', $np)->get();

                foreach ($buscarCorte as $row) {
                    $cons = $row->cons ?? '';
                    $tipo = $row->tipo ?? '';
                    $aws = $row->aws ?? '';
                    $color = $row->color ?? '';
                    $tamano = floatval($row->tamano ?? 0);
                    $t1 = $row->terminal1 ?? '';
                    $t2 = $row->terminal2 ?? '';
                    $df = $row->dataFrom ?? '';
                    $dt = $row->dataTo ?? '';

                    // LÓGICA 1: Registro de Corte (10001)
                    if ($tamano > 0) {
                        $totalCircuitsCorte++;
                        $randomTiempoCorte = Arr::random($corte);
                        $tiempoCorte = $tamano * $randomTiempoCorte;
                        $dataLabelCorte = "Cutting cons {$cons} // Tipo:{$tipo}// AWG: {$aws}// Color: {$color}";

                        $bulkInserts[] = [
                            'pn_routing' => $np,
                            'work_routing' => '10001',
                            'posible_stations' => 'FB036',
                            'work_description' => $dataLabelCorte,
                            'QtyTimes' => 1,
                            'timePerProcess' => $tiempoCorte,
                            'setUp_routing' => 300,
                        ];
                    }

                    // LÓGICA 2: Twist (10061)
                    if ($tamano > 0 && (strpos($cons, 'T') === 0)) {
                        $randomTiempoTwist = Arr::random($twistMm);
                        $tiempoTwist = $tamano * $randomTiempoTwist;
                        $verificacion = 'Twist '.explode('-', $cons)[0];

                        if (! isset($agrupadoTwist[$verificacion])) {
                            $agrupadoTwist[$verificacion] = [
                                'labels' => [$cons],
                                'tiempo' => $tiempoTwist,
                            ];
                        } else {
                            $agrupadoTwist[$verificacion]['labels'][] = $cons;
                        }
                    }

                    // LÓGICA 3: Sellos en Terminal 1 (10381)
                    if (stripos($t1, 'Sello') !== false) {
                        $termClean = $t1;
                        if (($pos1 = strpos($termClean, '(')) !== false) {
                            $termClean = explode('(', $termClean)[1];
                        }
                        if (($pos2 = strpos($termClean, ')')) !== false) {
                            $termClean = explode(')', $termClean)[0];
                        }
                        $terminalesSello1[$termClean] = ($terminalesSello1[$termClean] ?? 0) + 1;
                    }

                    // LÓGICA 4: Sellos en Terminal 2 (10381)
                    if (stripos($t2, 'Sello') !== false) {
                        $termClean = $t2;
                        if (($pos1 = strpos($termClean, '(')) !== false) {
                            $termClean = explode('(', $termClean)[1];
                        }
                        if (($pos2 = strpos($termClean, ')')) !== false) {
                            $termClean = explode(')', $termClean)[0];
                        }
                        $terminalesSello2[$termClean] = ($terminalesSello2[$termClean] ?? 0) + 1;
                    }

                    // LÓGICA 5: Terminales 1 (10951, 10960)
                    $esTerminal1Valida = ! empty($t1) && ! preg_match('/^(Empalme|EMPALME|SPL|SPLICE|JUMPER|CONECTOR|Blunt|PORTA|CORTAR|N\/T|BLUNT)/i', $t1);
                    if ($esTerminal1Valida) {
                        $termClean1 = $t1;
                        if (($pos = strpos($termClean1, '(')) !== false) {
                            $termClean1 = substr($termClean1, 0, $pos);
                        }

                        $terminalesConteo1[$termClean1] = ($terminalesConteo1[$termClean1] ?? 0) + 1;

                        if (strpos($termClean1, 'T3-') === false && strpos($termClean1, 'T4-') === false && ! in_array($termClean1, $NoRequeridas)) {
                            $bulkInserts[] = [
                                'pn_routing' => $np,
                                'work_routing' => '10951',
                                'posible_stations' => 'pend',
                                'work_description' => "Plug {$termClean1} Terminal in {$df}",
                                'QtyTimes' => 1,
                                'timePerProcess' => Arr::random($plugIn),
                                'setUp_routing' => 60,
                            ];
                            $bulkInserts[] = [
                                'pn_routing' => $np,
                                'work_routing' => '10960',
                                'posible_stations' => 'pend',
                                'work_description' => "Routing Wire in {$df}",
                                'QtyTimes' => 1,
                                'timePerProcess' => Arr::random($routingBoardTime),
                                'setUp_routing' => 30,
                            ];
                        }
                    }

                    // LÓGICA 6: Terminales 2 (10951, 10960)
                    $esTerminal2Valida = ! empty($t2) && ! preg_match('/^(Empalme|EMPALME|SPL|SPLICE|JUMPER|Jumper|CONECTOR|Blunt|PORTA|CORTAR|N\/T|BLUNT)/i', $t2);
                    if ($esTerminal2Valida) {
                        $termClean2 = $t2;
                        if (($pos = strpos($termClean2, '(')) !== false) {
                            $termClean2 = substr($termClean2, 0, $pos);
                        }

                        $terminalesConteo2[$termClean2] = ($terminalesConteo2[$termClean2] ?? 0) + 1;

                        if (strpos($termClean2, 'T3-') === false && strpos($termClean2, 'T4-') === false && ! in_array($termClean2, $NoRequeridas)) {
                            $bulkInserts[] = [
                                'pn_routing' => $np,
                                'work_routing' => '10951',
                                'posible_stations' => 'pend',
                                'work_description' => "Plug {$termClean2} Terminal in {$dt}",
                                'QtyTimes' => 1,
                                'timePerProcess' => Arr::random($plugIn),
                                'setUp_routing' => 60,
                            ];
                            $bulkInserts[] = [
                                'pn_routing' => $np,
                                'work_routing' => '10960',
                                'posible_stations' => 'pend',
                                'work_description' => "Routing Wire in {$dt}",
                                'QtyTimes' => 1,
                                'timePerProcess' => Arr::random($routingBoardTime),
                                'setUp_routing' => 30,
                            ];
                        }
                    }

                    // LÓGICA 7: Soldadura (10431)
                    if (stripos($t1, 'SOLDAR') !== false || stripos($t2, 'SOLDAR') !== false) {
                        $totalSoldar++;
                    }

                    // LÓGICA 8: Mangas (10361, 10401)
                    if (stripos($t1, 'MANGA') !== false || stripos($t2, 'MANGA') !== false) {
                        $cantidadMangas++;
                    }

                    // LÓGICA 9: Splices (10341, 10301)
                    if (! empty($df) && preg_match('/^(SPL|spl|Spl|splice|SPLICE|Empalme)/i', $df)) {
                        $tipoSplice[$df] = ($tipoSplice[$df] ?? 0) + 1;
                    }
                    if (! empty($dt) && preg_match('/^(SPL|spl|Spl|splice|SPLICE|Empalme)/i', $dt)) {
                        $tipoSplice[$dt] = ($tipoSplice[$dt] ?? 0) + 1;
                    }
                }

                // --- B. PROCESAMIENTO TESTING Y PACKING ---
                if ($totalCircuitsCorte > 0) {
                    $testing = 720;
                    $packing = 300;
                    if ($totalCircuitsCorte <= 10) {
                        $testing = 60;
                        $packing = 60;
                    } elseif ($totalCircuitsCorte <= 20) {
                        $testing = 180;
                        $packing = 120;
                    } elseif ($totalCircuitsCorte <= 50) {
                        $testing = 240;
                        $packing = 180;
                    } elseif ($totalCircuitsCorte <= 100) {
                        $testing = 600;
                        $packing = 360;
                    } elseif ($totalCircuitsCorte > 100) {
                        $testing = 900;
                        $packing = 480;
                    }

                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '11501', 'posible_stations' => 'Pend', 'work_description' => "Testing: {$totalCircuitsCorte} Circuits", 'QtyTimes' => 1, 'timePerProcess' => $testing, 'setUp_routing' => 300];
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '11701', 'posible_stations' => 'Pend', 'work_description' => 'Packing', 'QtyTimes' => 1, 'timePerProcess' => $packing, 'setUp_routing' => 300];
                }

                // --- C. AGREGAR DATA DE ACUMULADORES (TWIST, SELLOS, SPLICES, ETC.) ---
                foreach ($agrupadoTwist as $prefijo => $info) {
                    rsort($info['labels']);
                    $bulkInserts[] = [
                        'pn_routing' => $np,
                        'work_routing' => '10061',
                        'posible_stations' => 'Pending',
                        'work_description' => $prefijo.' '.implode(' , ', $info['labels']),
                        'QtyTimes' => 1,
                        'timePerProcess' => $info['tiempo'],
                        'setUp_routing' => 300,
                    ];
                }

                $sealsGlobales = array_merge($terminalesSello1, $terminalesSello2);
                foreach ($sealsGlobales as $term => $qty) {
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10381', 'posible_stations' => 'Pend', 'work_description' => $term, 'QtyTimes' => $qty, 'timePerProcess' => Arr::random($setSealTime), 'setUp_routing' => 300];
                }

                foreach ($terminalesConteo1 as $term => $qty) {
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10081', 'posible_stations' => 'FB-081', 'work_description' => $term, 'QtyTimes' => $qty, 'timePerProcess' => 4.084, 'setUp_routing' => 300];
                }
                foreach ($terminalesConteo2 as $term => $qty) {
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10081', 'posible_stations' => 'FB-081', 'work_description' => $term, 'QtyTimes' => $qty, 'timePerProcess' => 3.084, 'setUp_routing' => 300];
                }

                if ($totalSoldar > 0) {
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10431', 'posible_stations' => 'Pend', 'work_description' => 'set tin point', 'QtyTimes' => $totalSoldar, 'timePerProcess' => Arr::random($tinSet), 'setUp_routing' => 300];
                }

                if ($cantidadMangas > 0) {
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10361', 'posible_stations' => 'Pend', 'work_description' => 'Set HeadShrink in Terminals ', 'QtyTimes' => $cantidadMangas, 'timePerProcess' => Arr::random($setHeadShrink), 'setUp_routing' => 300];
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10401', 'posible_stations' => 'Pend', 'work_description' => 'Burn Heatshrirnk w/headgun in Terminals ', 'QtyTimes' => $cantidadMangas, 'timePerProcess' => Arr::random($burnHeatGun), 'setUp_routing' => 300];
                }

                foreach ($tipoSplice as $key => $value) {
                    $QtySpliceA = intval($value / 2) + intval($value % 2);
                    $QtySpliceB = intval($value / 2);
                    $timpoSetSplice = ($QtySpliceA * Arr::random($setSplice)) * Arr::random($setSplice);

                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10341', 'posible_stations' => 'Pend', 'work_description' => "Create set for splice {$QtySpliceA} : {$QtySpliceB}", 'QtyTimes' => 1, 'timePerProcess' => $timpoSetSplice, 'setUp_routing' => 300];
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10301', 'posible_stations' => 'FB110', 'work_description' => 'splice set apply with machine', 'QtyTimes' => 1, 'timePerProcess' => Arr::random($applySpleceInMachine), 'setUp_routing' => 300];
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10361', 'posible_stations' => 'Pend', 'work_description' => 'Set HeadShrink in splice ', 'QtyTimes' => 1, 'timePerProcess' => Arr::random($setHeadShrink), 'setUp_routing' => 300];
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10401', 'posible_stations' => 'Pend', 'work_description' => 'Burn Heatshrirnk w/headgun in Splice ', 'QtyTimes' => 1, 'timePerProcess' => Arr::random($burnHeatGun), 'setUp_routing' => 300];
                }

                // --- D. TABLA DATOS (LOOM PROCESS) CON QUERY BUILDER ---
                $buscarLoom = DB::table('datos')
                    ->select('item', 'qty')
                    ->where('part_num', $np)
                    ->where(function ($query) {
                        $query->where('item', 'LIKE', 'LTP%')
                            ->orWhere('item', 'TAPE-835')
                            ->orWhere('item', 'TAPE-25')
                            ->orWhere('item', 'LIKE', 'LW-%')
                            ->orWhere('item', 'LIKE', 'LSL%-%')
                            ->orWhere('item', 'LIKE', 'PA%-%');
                    })->get();

                $loomingTotal835 = 0;
                $tapingTotal835 = 0;
                $normalTaping835 = 0;
                $loomingTotal25 = 0;
                $normalTaping25 = 0;
                $totalLabeling = 0;
                $braidTotal = 0;
                $totalTies = 0;

                foreach ($buscarLoom as $d) {
                    $item = $d->item;
                    $qty = floatval($d->qty);
                    $timeRand = Arr::random($loomingTime);

                    if ($item === 'TAPE-835') {
                        $tapingTotal835 += ($timeRand * 1.2 * $qty) * 1.15;
                    } elseif (strpos($item, 'LTP') === 0) {
                        $loomingTotal835 += ($timeRand * 1.2) * $qty;
                        $normalTaping835 += ($timeRand * 1.2) * $qty;
                        $loomingTotal25 += $timeRand * $qty;
                    }

                    if ($item === 'TAPE-25') {
                        $normalTaping25 += ($timeRand * $qty) * 1.25;
                    }
                    if (strpos($item, 'LW-') === 0) {
                        $totalLabeling += ($qty * 5);
                    }
                    if (strpos($item, 'LSL') === 0 && strpos($item, '-') !== false) {
                        $braidTotal += ($timeRand * $qty) * 1.33;
                    }
                    if (strpos($item, 'PA') === 0 && strpos($item, '-') !== false) {
                        $totalTies += ($qty * 5.3 * 1.15);
                    }
                }

                // Inserciones de la sección Loom
                if (($loomingTotal835 + $tapingTotal835 + $normalTaping835) > 0) {
                    $tappingandlooming = ($loomingTotal835 + $tapingTotal835) * 1.1;
                    $normalTaping835 *= 1.55;
                    if ($loomingTotal835 > 0) {
                        $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '11000', 'posible_stations' => 'Pend', 'work_description' => 'looming', 'QtyTimes' => 1, 'timePerProcess' => max(30, round($loomingTotal835)), 'setUp_routing' => 150];
                    }
                    if ($tappingandlooming > 0) {
                        $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '11001', 'posible_stations' => 'Pend', 'work_description' => 'Taping/Looming', 'QtyTimes' => 1, 'timePerProcess' => max(30, round($tappingandlooming)), 'setUp_routing' => 150];
                    }
                    if ($normalTaping835 > 0) {
                        $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10901', 'posible_stations' => 'Pend', 'work_description' => 'Taping Body/Assembly', 'QtyTimes' => 1, 'timePerProcess' => max(30, round($normalTaping835)), 'setUp_routing' => 150];
                    }
                }

                if ($loomingTotal25 <= 0 && $normalTaping25 > 0) {
                    $normalTaping25 = round(($normalTaping25 * 2.5), 2);
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10901', 'posible_stations' => 'Pend', 'work_description' => 'Taping Body/Assembly', 'QtyTimes' => 1, 'timePerProcess' => max(30, round($normalTaping25)), 'setUp_routing' => 150];
                }

                if ($totalLabeling > 0) {
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '11050', 'posible_stations' => 'Pend', 'work_description' => 'labeling', 'QtyTimes' => 1, 'timePerProcess' => max(30, round($totalLabeling)), 'setUp_routing' => 150];
                }
                if ($braidTotal > 0) {
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '11101', 'posible_stations' => 'Pend', 'work_description' => 'Braiding', 'QtyTimes' => 1, 'timePerProcess' => max(30, round($braidTotal)), 'setUp_routing' => 150];
                }
                if ($totalTies > 0) {
                    $bulkInserts[] = ['pn_routing' => $np, 'work_routing' => '10801', 'posible_stations' => 'Pend', 'work_description' => 'Add Ties', 'QtyTimes' => 1, 'timePerProcess' => max(30, round($totalTies)), 'setUp_routing' => 150];
                }
            }

            // ==========================================
            // 3. INSERCIÓN MASIVA FINAL POR CHUNKS (CADA 500 REGISTROS)
            // ==========================================
            if (! empty($bulkInserts)) {
                foreach (array_chunk($bulkInserts, 500) as $chunk) {
                    routingModel::insert($chunk);
                }
            }

            // Cambiar estatus final a Completado de los PNs procesados
            maintainRoutings::whereIn('pn', $deledataPN)->update(['routing_status' => 'Completado']);
        });
    }
}
