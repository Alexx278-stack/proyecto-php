<?php
// Datos del campeonato de bolos
$primera = [
    'Equipo 1' => [280, 150, 195, 270, 190],
    'Equipo 2' => [190, 90, 101, 112, 98],
    'Equipo 3' => [145, 167, 189, 198, 80]
];

$segunda = [
    'Equipo 1' => [101, 198, 165, 145, 178],
    'Equipo 2' => [123, 189, 210, 250, 202],
    'Equipo 3' => [110, 90, 115, 190, 120]
];

// Función para calcular suma de un equipo en una línea
function sumaEquipo($linea, $equipo) {
    return array_sum($linea[$equipo]);
}

// Función para calcular suma total de un equipo
function sumaTotalEquipo($primera, $segunda, $equipo) {
    return sumaEquipo($primera, $equipo) + sumaEquipo($segunda, $equipo);
}


// 1. Promedio del equipo 1
$sumaEquipo1 = sumaTotalEquipo($primera, $segunda, 'Equipo 1');
$promedioEquipo1 = $sumaEquipo1 / 10; // 5 jugadores * 2 líneas  


// 2. Sumar los puntos del equipo 3
$sumaEquipo3 = sumaTotalEquipo($primera, $segunda, 'Equipo 3');

// Sumar los puntos del equipo 2 para el ganador del campeonato
$sumaEquipo2 = sumaTotalEquipo($primera, $segunda, 'Equipo 2');

// 3. Promedio del Equipo 2 sin contar el jugador 4 (índice 3)
$sumaEquipo2SinJ4 = 0;
foreach ($primera['Equipo 2'] as $i => $puntaje) {
    if ($i != 3) $sumaEquipo2SinJ4 += $puntaje;
}
foreach ($segunda['Equipo 2'] as $i => $puntaje) {
    if ($i != 3) $sumaEquipo2SinJ4 += $puntaje;
}
$promedioEquipo2SinJ4 = $sumaEquipo2SinJ4 / 8; // 4 jugadores * 2 líneas

// 4. Promedio de los jugadores 2 de todos los equipos
$sumaJugador2 = 0;
$totalJugadores = 0;

foreach ($primera as $equipo => $puntajes) {
    if (isset($puntajes[1])) {
        $sumaJugador2 += $puntajes[1];
        $totalJugadores++;
    }
}

foreach ($segunda as $equipo => $puntajes) {
    if (isset($puntajes[1])) {
        $sumaJugador2 += $puntajes[1];
        $totalJugadores++;
    }
}

$promedioJugador2 = $totalJugadores > 0 ? $sumaJugador2 / $totalJugadores : 0;

// 5. Jugador con mejor puntaje en la línea 1 y a que equipo pertenece
$mejorJugador1 = null;
$equipoMejorJugador1 = null;

foreach ($primera as $equipo => $puntajes) {
    if (isset($puntajes[0]) && ($mejorJugador1 === null || $puntajes[0] > $mejorJugador1)) {
        $mejorJugador1 = $puntajes[0];
        $equipoMejorJugador1 = $equipo;
    }
}

foreach ($segunda as $equipo => $puntajes) {
    if (isset($puntajes[0]) && ($mejorJugador1 === null || $puntajes[0] > $mejorJugador1)) {
        $mejorJugador1 = $puntajes[0];
        $equipoMejorJugador1 = $equipo;
    }
}


// 6. Jugador ganador de la segunda línea y a que equipo pertenece
$mejorJugador2 = null;
$equipoMejorJugador2 = null;

foreach ($segunda as $equipo => $puntajes) {
    foreach ($puntajes as $puntaje) {
        if ($mejorJugador2 === null || $puntaje > $mejorJugador2) {
            $mejorJugador2 = $puntaje;
            $equipoMejorJugador2 = $equipo;
        }
    }
}


// 7. Jugador ganador del torneo
$mejorJugadorTorneo = null;
$equipoMejorJugadorTorneo = null;

foreach ($primera as $equipo => $puntajes) {
    foreach ($puntajes as $puntaje) {
        if ($mejorJugadorTorneo === null || $puntaje > $mejorJugadorTorneo) {
            $mejorJugadorTorneo = $puntaje;
            $equipoMejorJugadorTorneo = $equipo;
        }
    }
}

foreach ($segunda as $equipo => $puntajes) {
    foreach ($puntajes as $puntaje) {
        if ($mejorJugadorTorneo === null || $puntaje > $mejorJugadorTorneo) {
            $mejorJugadorTorneo = $puntaje;
            $equipoMejorJugadorTorneo = $equipo;
        }
    }
}


//8. Equipo Ganador del torneo
$equipoganador= null;
if ($sumaEquipo1 > $sumaEquipo2 && $sumaEquipo1 > $sumaEquipo3) {
    $equipoganador = 'Equipo 1';
} elseif ($sumaEquipo2 > $sumaEquipo1 && $sumaEquipo2 > $sumaEquipo3) {
    $equipoganador = 'Equipo 2';
} else {
    $equipoganador = 'Equipo 3';
}   


// 9. equipo que menos puntos realizo en la segunda línea
$equipoMenosPuntosSegunda = null;
$menorPuntajeSegunda = null;
foreach ($segunda as $equipo => $puntajes) {
    $sumaPuntajes = array_sum($puntajes);
    if ($menorPuntajeSegunda === null || $sumaPuntajes < $menorPuntajeSegunda) {
        $menorPuntajeSegunda = $sumaPuntajes;
        $equipoMenosPuntosSegunda = $equipo;
    }
}

// 10. Equipo que mas puntos realizó en la primer línea
$sumasPrimera = [];
foreach (['Equipo 1', 'Equipo 2', 'Equipo 3'] as $equipo) {
    $sumasPrimera[$equipo] = sumaEquipo($primera, $equipo);
}
$equipoMasPrimera = array_keys($sumasPrimera, max($sumasPrimera))[0];

// 11. Jugadores de la primer línea que obtuvieron mas de 200 puntos
$jugadoresMas200 = [];
foreach ($primera as $equipo => $jugadores) {
    foreach ($jugadores as $j => $puntaje) {
        if ($puntaje > 200) {
            $jugadoresMas200[] = "Jugador " . ($j + 1) . " del $equipo: $puntaje";
        }
    }
}

// 12. Jugadores de la segunda línea con puntaje entre 100 y 150
$jugadores100150 = [];
foreach ($segunda as $equipo => $jugadores) {
    foreach ($jugadores as $j => $puntaje) {
        if ($puntaje >= 100 && $puntaje <= 150) {
            $jugadores100150[] = "Jugador " . ($j + 1) . " del $equipo: $puntaje";
        }
    }
}

// 13. Ordenar la primer línea de mayor a menor con equipo y jugador
$puntajesOrdenados = [];
foreach ($primera as $equipo => $jugadores) {
    foreach ($jugadores as $j => $puntaje) {
        $puntajesOrdenados[] = ['puntaje' => $puntaje, 'equipo' => $equipo, 'jugador' => $j + 1];
    }
}
usort($puntajesOrdenados, function($a, $b) {
    return $b['puntaje'] <=> $a['puntaje'];
});








// Mostrar resultados
echo "<h1>Resultados del Campeonato de Bolos</h1>";
echo "<ol>";
echo "<li>Promedio del equipo 1: " . number_format($promedioEquipo1, 2) . "</li>";
echo "<li>Suma total del equipo 3: " . $sumaEquipo3 . "</li>";
echo "<li>Promedio del equipo 2 sin contar el jugador 4: " . number_format($promedioEquipo2SinJ4, 2) . "</li>";
echo "<li>Promedio de los jugadores 2 de todos los equipos: " . number_format($promedioJugador2, 2) . "</li>";
echo "<li>Jugador con mejor puntaje en la línea 1: " . $mejorJugador1 . " (Equipo: " . $equipoMejorJugador1 . ")</li>";
echo "<li>Jugador ganador de la segunda línea: " . $mejorJugador2 . " (Equipo: " . $equipoMejorJugador2 . ")</li>";
echo "<li>Jugador ganador del torneo: " . $mejorJugadorTorneo . " (Equipo: " . $equipoMejorJugadorTorneo . ")</li>";
echo "<li>Equipo ganador del campeonato: " . $equipoganador . "</li>";
echo "<li>Equipo que menos puntos realizó en la segunda línea: " . $equipoMenosPuntosSegunda . " (Puntos: " . $menorPuntajeSegunda . ")</li>";
echo "<li>Equipo que más puntos realizó en la primer línea: " . $equipoMasPrimera . " (Puntos: " . $sumasPrimera[$equipoMasPrimera] . ")</li>";
echo "<li>Jugadores de la primer línea que obtuvieron más de 200 puntos:</li>";
echo "<ul>";
foreach ($jugadoresMas200 as $jugador) {
    echo "<li>$jugador</li>";
}
echo "</ul>";
echo "<li>Jugadores de la segunda línea con puntaje entre 100 y 150:</li>";
echo "<ul>";
foreach ($jugadores100150 as $jugador) {
    echo "<li>$jugador</li>";
}
echo "</ul>";
echo "<li>Puntajes ordenados de la primer línea (de mayor a menor):</li>";
echo "<ul>";
foreach ($puntajesOrdenados as $dato) {
    echo "<li>" . $dato['equipo'] . " - Jugador " . $dato['jugador'] . ": " . $dato['puntaje'] . "</li>";
}
echo "</ul>";
echo "</ol>";
?>