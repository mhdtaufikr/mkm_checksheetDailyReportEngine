@extends('layouts.master')

@section('content')

<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xxl px-4 mt-n10">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <form action="{{ url('/checksheet/detail/store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">{{ \Carbon\Carbon::parse($item->date)->format('d F Y') }} ({{$item->shift}})</h3>
                                        <button hidden type="submit" class="btn btn-primary">Submit</button>
                                    </div>

                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach($details as $detail)
                                            <li class="nav-item">
                                                <a style="color: black; font-size:13.9px;" class="nav-link {{ $loop->first ? 'active' : '' }}" id="nav-{{ $detail->shop }}-tab" data-bs-toggle="tab" href="#nav-{{ Str::slug($detail->shop) }}" role="tab" aria-controls="nav-{{ Str::slug($detail->shop) }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $detail->shop }}</a>
                                            </li>
                                        @endforeach

                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <input readonly type="hidden" name="id" value="{{$id}}">
                                            @foreach($details as $key => $detail)
                                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="nav-{{ Str::slug($detail->shop) }}" role="tabpanel" aria-labelledby="nav-{{ $detail->shop }}-tab">

                                                <div class="form-group mt-4">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="man_power_planning">Man Power Planning</label>
                                                            <input readonly type="number" name="man_power_planning[]" class="form-control" style="width: 100px;" value="{{ $detail->mp_plan ?? '0' }}" min="0">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="man_power_actual">Man Power Actual</label>
                                                            <input readonly type="number" name="man_power_actual[]" class="form-control" style="width: 100px;" value="{{ $detail->mp_actual ?? '0' }}" min="0">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="time">Time From</label>
                                                            <input readonly type="time" name="timefrom[]" class="form-control" value="{{ $detail->time_from ?? '' }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="time">Time Until</label>
                                                            <input readonly type="time" name="timeto[]" class="form-control" value="{{ $detail->time_to ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="pic">PIC</label>
                                                            <input readonly type="text" name="pic[]" class="form-control" value="{{ $detail->pic ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="problem">Problem</label>
                                                            <textarea readonly name="problem[]" class="form-control" rows="3">{{ $detail->problem ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="cause">Cause</label>
                                                            <textarea readonly name="cause[]" class="form-control" rows="3">{{ $detail->cause ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="action">Action</label>
                                                            <textarea readonly name="action[]" class="form-control" rows="3">{{ $detail->action ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Model</th>
                                                                <th>Production Planning</th>
                                                                <th>Production Actual</th>
                                                                <th>Production Different</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($footers as $footer)
                                                            @if($footer['id_checksheetdtl'] == $detail->id)
                                                                <tr>
                                                                    <td>{{ $footer['model'] }}</td>
                                                                    <td>{{ $footer['prod_plan'] }}</td>
                                                                    <td>{{ $footer['prod_actual'] }}</td>
                                                                    <td>{{ $footer['prod_diff'] }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        // Select input fields within each table row
        $('.production-planning').on('input', function() {
            calculateDifferent($(this).closest('tr'));
        });

        $('.production-actual').on('input', function() {
            calculateDifferent($(this).closest('tr'));
        });

        function calculateDifferent(row) {
            var planningInput = row.find('.production-planning');
            var actualInput = row.find('.production-actual');
            var differentInput = row.find('.production-different');

            var planningValue = parseFloat(planningInput.val());
            var actualValue = parseFloat(actualInput.val());

            if (!isNaN(planningValue) && !isNaN(actualValue)) {
                var difference = actualValue - planningValue;
                differentInput.val(difference);
            }
        }
    });
</script>
<!-- For Datatables -->
<script>
    $(document).ready(function() {
        var table = $("#tableUser").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    });
</script>
@endsection
