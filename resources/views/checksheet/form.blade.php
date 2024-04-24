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
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">{{$item->no_document}}</h3>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach($groupedShopMaster as $key => $models)
                                        <li class="nav-item">
                                            <a style="color: black" class="nav-link {{ $loop->first ? 'active' : '' }}" id="nav-{{ $key }}-tab" data-bs-toggle="tab" href="#nav-{{ Str::slug($key) }}" role="tab" aria-controls="nav-{{ Str::slug($key) }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $key }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        @foreach($groupedShopMaster as $key => $models)
                                        @csrf
                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="nav-{{ Str::slug($key) }}" role="tabpanel" aria-labelledby="nav-{{ $key }}-tab">
                                            <div class="form-group mt-4">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label for="man_power_planning">Man Power Planning</label>
                                                        <input type="number" name="man_power_planning[]" class="form-control" style="width: 100px;" value="0" min="0">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="man_power_actual">Man Power Actual</label>
                                                        <input type="number" name="man_power_actual[]" class="form-control" style="width: 100px;" value="0" min="0">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="time">Time</label>
                                                        <input type="time" name="time[]" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="pic">PIC</label>
                                                        <input type="text" name="pic[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="problem">Problem</label>
                                                        <textarea name="problem[]" class="form-control" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="cause">Cause</label>
                                                        <textarea name="cause[]" class="form-control" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="action">Action</label>
                                                        <textarea name="action[]" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="table-responsive mb-4">
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
                                                        @foreach($models as $model)
                                                        <tr>
                                                            <input type="hidden" name="model[]" value="{{ $model->model }}">
                                                            <input type="hidden" name="shop[]" value="{{ $model->shop }}">
                                                            <td>{{ $model->model }}</td>
                                                            <td><input type="number" name="production_planning[]" class="production-planning" style="width: 70px;" value="0" min="0"></td>
                                                            <td><input type="number" name="production_actual[]" class="production-actual" style="width: 70px;" value="0" min="0"></td>
                                                            <td><input type="number" name="production_different[]" class="production-different" style="width: 70px;" readonly value="0"></td>
                                                        </tr>
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
