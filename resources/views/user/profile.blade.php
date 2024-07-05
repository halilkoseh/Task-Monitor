<form action="{{ route('startWorkSession') }}" method="POST">
    @csrf
    <button type="submit">Mesaiye Başla</button>
</form>

@if($currentWorkSession)
    @if($currentWorkSession->status == 'in_progress')
        <form action="{{ route('takeBreak', $currentWorkSession->id) }}" method="POST">
            @csrf
            <button type="submit">Mola Ver</button>
        </form>
    @endif

    @if($currentWorkSession->status == 'in_progress' || $currentWorkSession->status == 'on_break')
        <form action="{{ route('endWorkSession', $currentWorkSession->id) }}" method="POST">
            @csrf
            <button type="submit">Mesaiyi Bitir</button>
        </form>
    @endif
@endif
