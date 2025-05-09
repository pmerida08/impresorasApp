<h1>Alerta: Nivel de Tóner Bajo</h1>

<p>La impresora {{ $impresora->tipo }} (IP: {{ $impresora->ip }}) tiene niveles bajos de tóner:</p>

<ul>
@foreach($tonerLevels as $color => $level)
    <li>{{ ucfirst($color) }}: {{ $level }}%</li>
@endforeach
</ul>

<p>Por favor, revise y reemplace los cartuchos necesarios.</p>