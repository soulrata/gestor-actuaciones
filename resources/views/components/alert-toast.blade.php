@php
    // Recopilar todos los mensajes de sesión disponibles
    $messages = [];
    if (session('success')) {
        $messages[] = ['type' => 'success', 'message' => session('success')];
    }
    if (session('error')) {
        $messages[] = ['type' => 'error', 'message' => session('error')];
    }
    if (session('warning')) {
        $messages[] = ['type' => 'warning', 'message' => session('warning')];
    }
    if (session('info')) {
        $messages[] = ['type' => 'info', 'message' => session('info')];
    }
    if (session('question')) {
        $messages[] = ['type' => 'question', 'message' => session('question')];
    }
@endphp

@if (!empty($messages))
    <script>
        @foreach ($messages as $msg)
            Swal.fire({
                toast: true,
                position: "{{ $position ?? 'top' }}",  // Parámetro opcional con valor por defecto
                icon: "{{ $msg['type'] }}", // Ícono dinámico según el mensaje
                title: "{{ $msg['message'] }}", // Mensaje dinámico
                showConfirmButton: false,
                timer: {{ $timer ?? 6000 }},  // Duración del toast, con valor por defecto
                timerProgressBar: true
            });
        @endforeach
    </script>
@endif
