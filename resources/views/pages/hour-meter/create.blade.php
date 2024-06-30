@extends('layouts.content')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="py-3 mb-0"><a class="text-muted fw-light" href="{{ route('report.hour-meter.index') }}">Hour Meter
                /</a> Baru</h4>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('report.hour-meter.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <label class="form-label" for="title">Tanggal</label>
                    <input type="date" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                           value="{{ old('title', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                    <span class="error invalid-feedback">{{ $errors->first('title') }}</span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="user">Pelapor</label>
                    <input type="text" class="form-control" id="user" value="{{ auth()->user()->name }}" disabled>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="" class="form-label">Unit Peralatan</label>
                        <a class="cursor-pointer" href="#" data-bs-toggle="modal"
                           data-bs-target="#equipment-input-modal">
                            + Unit Peralatan
                        </a>
                    </div>
                    <div id="equipment-wrapper">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="equipment-input-modal" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label for="search-equipment-input"></label>
                    <input type="text" id="search-equipment-input"
                           class="form-control"
                           placeholder="Cari Unit Peralatan...">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="wrapper-equipment-input">
                        <li class="list-group-item d-flex justify-content-start">
                            <input class="form-check-input me-2" type="checkbox" value="1"/>
                            <div class=" flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <div class="fw-semibold">92416</div>
                                    <small>12 Hour Meter</small>
                                </div>
                                SN. 4916145853530
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="submit-equipment-input" data-bs-dismiss="modal" class="btn btn-primary">
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const equipmentWrapper = document.getElementById('equipment-wrapper');
        const searchEquipmentInput = document.getElementById('search-equipment-input');
        const submitEquipmentInput = document.getElementById('submit-equipment-input');
        const wrapperEquipmentInput = document.getElementById('wrapper-equipment-input');

        let selected = [];

        $('#wrapper-equipment-input').on('change', 'input.form-check-input', function (e) {
            const equipment = JSON.parse(e.target.dataset.equipment);
            if (this.checked) {
                selected.push(equipment);
            } else {
                selected = selected.filter(e => e.id !== equipment.id);
            }
        });

        function getDetailServiceFromHourMeter (e) {
            const index = e.target.dataset.index;
            const categoryId = selected[index].category_id;
            fetch(`/category/${categoryId}/rule-search?hm=${e.target.value}`).then(res => res.json()).then(res => {
                $('input[name="service_plan[' + index + ']"]').val(res?.service_plan);
            });
        }

        $('#equipment-wrapper').on('change', 'input.new-hour-meter', getDetailServiceFromHourMeter);
        $('#equipment-wrapper').on('keyup', 'input.new-hour-meter', getDetailServiceFromHourMeter);

        submitEquipmentInput.addEventListener('click', function (e) {
            equipmentWrapper.innerHTML = '';
            for (let i = 0; i < selected.length; i++) {
                equipmentWrapper.innerHTML += `
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <input type="hidden" name="equipment_id[${i}]" value="${selected[i].id}" />
                                    <label class="form-label" for="${`serial-number-` + i}">Serial Number</label>
                                    <input type="text" class="form-control" id="${`serial-number-` + i}" value="${selected[i].serial_number}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="${`hour-meter-` + i}">Hour Meter</label>
                                    <input type="number" name="new_hour_meter[${i}]" required data-index="${i}" class="form-control new-hour-meter" id="${`hour-meter-` + i}" value="${selected[i].last_hour_meter}" min="${selected[i].last_hour_meter}">
                                    <small>Hour meter sebelumnya: ${selected[i].last_hour_meter}</small>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="${`service-plan-` + i}">Detail Servis</label>
                                    <input type="text" name="service_plan[${i}]" required class="form-control" id="${`service-plan-` + i}" value="">
                                </div>
                            </div>
                        </div>`;
            }
        });

        const reloadEquipmentList = (search) => fetch('/api/equipment?q=' + search).then(res => res.json()).then(res => {
            wrapperEquipmentInput.innerHTML = '';
            res.forEach(equipment => {
                const isSelected = selected.find(e => e.id === equipment.id);
                wrapperEquipmentInput.innerHTML += `
                        <li class="list-group-item d-flex justify-content-start">
                            <input class="form-check-input me-2" ${isSelected ? 'checked' : ''} data-equipment='${JSON.stringify(equipment)}' type="checkbox" value="${equipment.id}"/>
                            <div class=" flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <div class="fw-semibold">${equipment.code}</div>
                                    <small>${equipment.last_hour_meter} Hour Meter</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>SN. ${equipment.serial_number}</div>
                                </div>
                            </div>
                        </li>`;
            });
        });

        document.getElementById('equipment-input-modal').addEventListener('show.bs.modal', _ => reloadEquipmentList(searchEquipmentInput.value));

        searchEquipmentInput.addEventListener('keyup', e => reloadEquipmentList(e.target.value));
    </script>
@endpush
