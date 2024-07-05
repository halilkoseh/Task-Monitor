<!-- Mesai Başlatma Butonu -->
<form action="{{ route('startWorkSession') }}" method="POST">
    @csrf
    <button type="submit">Mesaiye Başla</button>
</form>

<!-- Mevcut Mesai Oturumunu Göster -->
@if($currentWorkSession)
    <!-- Mola Butonu -->
    @if($currentWorkSession->status == 'in_progress')
        <form action="{{ route('takeBreak', $currentWorkSession->id) }}" method="POST">
            @csrf
            <button type="submit">Mola Ver</button>
        </form>
    @endif

    <!-- Mesai Bitirme Butonu -->
    @if($currentWorkSession->status == 'in_progress' || $currentWorkSession->status == 'on_break')
        <form action="{{ route('endWorkSession', $currentWorkSession->id) }}" method="POST">
            @csrf
            <button type="submit">Mesaiyi Bitir</button>
        </form>
    @endif
@endif
