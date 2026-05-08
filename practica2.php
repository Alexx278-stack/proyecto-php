<?php
function sanitize($value) {
    return htmlspecialchars(trim($value));
}

function formatMoney($value) {
    return number_format($value, 2, ',', '.');
}

$exercise1 = [];
$exercise2 = [];
$exercise3 = [];
$exercise4 = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['exercise']) && $_POST['exercise'] === '1') {
        $p1 = floatval($_POST['p1'] ?? 0);
        $p2 = floatval($_POST['p2'] ?? 0);
        $p3 = floatval($_POST['p3'] ?? 0);
        $examen = floatval($_POST['examen'] ?? 0);
        $trabajo = floatval($_POST['trabajo'] ?? 0);

        $promedioParciales = ($p1 + $p2 + $p3) / 3;
        $notaFinal = $promedioParciales * 0.35 + $examen * 0.35 + $trabajo * 0.30;
        $aprobado = $notaFinal >= 3;

        $exercise1 = [
            'promedioParciales' => $promedioParciales,
            'notaFinal' => $notaFinal,
            'mensaje' => $aprobado ? 'Aprobó' : 'No aprobó',
        ];
    }

    if (isset($_POST['exercise']) && $_POST['exercise'] === '2') {
        $autos = intval($_POST['autos'] ?? 0);
        $valorVenta = floatval($_POST['valorVenta'] ?? 0);

        $salarioBasico = 737000;
        $comisionPorAuto = 50000;
        $comisionVenta = $valorVenta * 0.05;
        $salarioTotal = $salarioBasico + $autos * $comisionPorAuto + $comisionVenta;

        $exercise2 = [
            'autos' => $autos,
            'valorVenta' => $valorVenta,
            'salarioTotal' => $salarioTotal,
        ];
    }

    if (isset($_POST['exercise']) && $_POST['exercise'] === '3') {
        $peso = floatval($_POST['peso'] ?? 0);
        $altura = floatval($_POST['altura'] ?? 0);
        $imc = $altura > 0 ? $peso / ($altura * $altura) : 0;

        if ($imc <= 0) {
            $categoria = 'Datos inválidos';
        } elseif ($imc < 18.5) {
            $categoria = 'Bajo peso';
        } elseif ($imc < 25) {
            $categoria = 'Normal';
        } elseif ($imc < 30) {
            $categoria = 'Sobrepeso';
        } elseif ($imc < 35) {
            $categoria = 'Obesidad grado I';
        } elseif ($imc < 40) {
            $categoria = 'Obesidad grado II';
        } else {
            $categoria = 'Obesidad grado III';
        }

        $exercise3 = [
            'peso' => $peso,
            'altura' => $altura,
            'imc' => $imc,
            'categoria' => $categoria,
        ];
    }

    if (isset($_POST['exercise']) && $_POST['exercise'] === '4') {
        $cedula = sanitize($_POST['cedula'] ?? '');
        $nombre = sanitize($_POST['nombre'] ?? '');
        $monto = floatval($_POST['monto'] ?? 0);
        $tasa = floatval($_POST['tasa'] ?? 0) / 100;
        $plazo = intval($_POST['plazo'] ?? 0);

        if ($monto > 0 && $plazo > 0 && $tasa >= 0) {
            $factor = pow(1 + $tasa, $plazo);
            $cuota = $monto * ($tasa * $factor) / ($factor - 1);
            $saldo = $monto;
            $tabla = [];

            for ($mes = 1; $mes <= $plazo; $mes++) {
                $interes = $saldo * $tasa;
                $amortizacion = $cuota - $interes;
                $saldo -= $amortizacion;
                if ($saldo < 0.01) {
                    $saldo = 0;
                }
                $tabla[] = [
                    'mes' => $mes,
                    'cuota' => $cuota,
                    'interes' => $interes,
                    'amortizacion' => $amortizacion,
                    'saldo' => $saldo,
                ];
            }

            $exercise4 = [
                'cedula' => $cedula,
                'nombre' => $nombre,
                'monto' => $monto,
                'tasa' => $tasa * 100,
                'plazo' => $plazo,
                'cuota' => $cuota,
                'tabla' => $tabla,
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 2 - Ejercicios PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        fieldset { margin-bottom: 30px; padding: 20px; }
        legend { font-weight: bold; }
        label { display: block; margin: 8px 0 4px; }
        input[type="text"], input[type="number"] { width: 100%; max-width: 240px; padding: 6px; }
        button { padding: 10px 16px; margin-top: 10px; }
        .result { margin-top: 12px; padding: 12px; background: #f2f2f2; border-radius: 6px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: right; }
        th { background: #efefef; }
        td:first-child, th:first-child { text-align: center; }
    </style>
</head>
<body>
    <h1>Práctica 2 - Ejercicios PHP</h1>

    <form method="post">
        <fieldset>
            <legend>Ejercicio 1: Nota final de la materia</legend>
            <input type="hidden" name="exercise" value="1">
            <label>Parcial 1:</label>
            <input type="number" step="0.01" name="p1" required>
            <label>Parcial 2:</label>
            <input type="number" step="0.01" name="p2" required>
            <label>Parcial 3:</label>
            <input type="number" step="0.01" name="p3" required>
            <label>Examen final:</label>
            <input type="number" step="0.01" name="examen" required>
            <label>Trabajo final:</label>
            <input type="number" step="0.01" name="trabajo" required>
            <button type="submit">Calcular nota final</button>

            <?php if ($exercise1): ?>
                <div class="result">
                    <strong>Promedio parciales:</strong> <?= number_format($exercise1['promedioParciales'], 2, ',', '.') ?><br>
                    <strong>Nota final:</strong> <?= number_format($exercise1['notaFinal'], 2, ',', '.') ?><br>
                    <strong>Resultado:</strong> <?= $exercise1['mensaje'] ?>
                </div>
            <?php endif; ?>
        </fieldset>
    </form>

    <form method="post">
        <fieldset>
            <legend>Ejercicio 2: Salario de vendedor de automóviles</legend>
            <input type="hidden" name="exercise" value="2">
            <label>Autos vendidos:</label>
            <input type="number" name="autos" min="0" required>
            <label>Valor total de ventas:</label>
            <input type="number" step="0.01" name="valorVenta" min="0" required>
            <button type="submit">Calcular salario</button>

            <?php if ($exercise2): ?>
                <div class="result">
                    <strong>Autos vendidos:</strong> <?= $exercise2['autos'] ?><br>
                    <strong>Valor total de ventas:</strong> $<?= formatMoney($exercise2['valorVenta']) ?><br>
                    <strong>Salario total:</strong> $<?= formatMoney($exercise2['salarioTotal']) ?><br>
                </div>
            <?php endif; ?>
        </fieldset>
    </form>

    <form method="post">
        <fieldset>
            <legend>Ejercicio 3: Índice de masa corporal (IMC)</legend>
            <input type="hidden" name="exercise" value="3">
            <label>Peso (kg):</label>
            <input type="number" step="0.1" name="peso" min="0.1" required>
            <label>Altura (m):</label>
            <input type="number" step="0.01" name="altura" min="0.1" required>
            <button type="submit">Calcular IMC</button>

            <?php if ($exercise3): ?>
                <div class="result">
                    <strong>Peso:</strong> <?= number_format($exercise3['peso'], 1, ',', '.') ?> kg<br>
                    <strong>Altura:</strong> <?= number_format($exercise3['altura'], 2, ',', '.') ?> m<br>
                    <strong>IMC:</strong> <?= number_format($exercise3['imc'], 2, ',', '.') ?><br>
                    <strong>Categoría:</strong> <?= $exercise3['categoria'] ?>
                </div>
            <?php endif; ?>
        </fieldset>
    </form>

    <form method="post">
        <fieldset>
            <legend>Ejercicio 4: Tabla de amortización (método francés)</legend>
            <input type="hidden" name="exercise" value="4">
            <label>Cédula del cliente:</label>
            <input type="text" name="cedula" required>
            <label>Nombre del cliente:</label>
            <input type="text" name="nombre" required>
            <label>Monto del crédito:</label>
            <input type="number" step="0.01" name="monto" min="0" required>
            <label>Tasa de interés mensual (%):</label>
            <input type="number" step="0.01" name="tasa" min="0" required>
            <label>Plazo en meses:</label>
            <input type="number" name="plazo" min="1" required>
            <button type="submit">Generar tabla</button>

            <?php if ($exercise4): ?>
                <div class="result">
                    <strong>Cédula:</strong> <?= $exercise4['cedula'] ?><br>
                    <strong>Nombre:</strong> <?= $exercise4['nombre'] ?><br>
                    <strong>Monto:</strong> $<?= formatMoney($exercise4['monto']) ?><br>
                    <strong>Tasa mensual:</strong> <?= number_format($exercise4['tasa'], 2, ',', '.') ?> %<br>
                    <strong>Plazo:</strong> <?= $exercise4['plazo'] ?> meses<br>
                    <strong>Cuota fija:</strong> $<?= formatMoney($exercise4['cuota']) ?><br>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Cuota</th>
                            <th>Interés</th>
                            <th>Amortización</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($exercise4['tabla'] as $fila): ?>
                            <tr>
                                <td><?= $fila['mes'] ?></td>
                                <td>$<?= formatMoney($fila['cuota']) ?></td>
                                <td>$<?= formatMoney($fila['interes']) ?></td>
                                <td>$<?= formatMoney($fila['amortizacion']) ?></td>
                                <td>$<?= formatMoney($fila['saldo']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </fieldset>
    </form>
</body>
</html>
