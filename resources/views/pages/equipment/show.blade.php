@extends('layouts.content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="py-3 mb-0"><a class="text-muted fw-light" href="{{ route('equipment.index') }}">Unit Peralatan /</a> Detail</h4>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div id="calendar" data-id="{{ $equipment->id }}"></div>
    </div>
</div>
@endsection

@push('script')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
<script>
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'multiMonthYear',
        events: '/api/equipment/' + (document.getElementById('calendar').dataset.id) + '/event',
    });
    calendar.render();
</script>
@endpush
