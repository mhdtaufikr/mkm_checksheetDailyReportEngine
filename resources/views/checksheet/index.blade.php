@extends('layouts.master')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                {{-- <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="tool"></i></div>
                            Dropdown App Menu
                        </h1>
                        <div class="page-header-subtitle">Use this blank page as a starting point for creating new pages inside your project!</div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">Optional page header content</div>
                </div> --}}
            </div>
        </div>
    </header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      {{-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>    </h1>
          </div>
        </div>
      </div><!-- /.container-fluid --> --}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Checksheet Daily Report</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-sm-12">
                        <button type="button" class="btn btn-dark btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-add">
                            <i class="fas fa-plus-square"></i>
                          </button>

                          <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-add-label">Add Daily Report</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ url('/checksheet/store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="dept">Department</label>
                                                        <input type="text" class="form-control" id="dept" name="dept" placeholder="Enter Dept." required value="Engine Operation Dept." readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="section">Section</label>
                                                        <input type="text" class="form-control" id="section" name="section" placeholder="Enter Section" required value="Machining Section" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="revision">Revision</label>
                                                        <input type="number" class="form-control" id="revision" name="revision" placeholder="Enter Revision" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="no_document">No. Document</label>
                                                        <input type="text" class="form-control" id="no_document" name="no_document" placeholder="Enter No. Document" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="shift">Shift</label>
                                                        <select id="shift" name="shift" class="form-control" required>
                                                            <option value="">- Select Shift -</option>
                                                            @foreach ($dropdownShift as $dropdown)
                                                            <option value="{{ $dropdown->name_value }}">{{ $dropdown->name_value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                    <div class="col-sm-12">
                      <!--alert success -->
                      @if (session('status'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('status') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif

                    @if (session('failed'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>{{ session('failed') }}</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif

                      <!--alert success -->
                      <!--validasi form-->
                        @if (count($errors)>0)
                          <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <ul>
                                  <li><strong>Data Process Failed !</strong></li>
                                  @foreach ($errors->all() as $error)
                                      <li><strong>{{ $error }}</strong></li>
                                  @endforeach
                              </ul>
                          </div>
                        @endif
                      <!--end validasi form-->
                    </div>
                </div>
                <div class="table-responsive">
                <table id="tableUser" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>No. Document</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                      $no=1;
                    @endphp
                    @foreach ($item as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{$data->no_document}}</td>
                        <td>{{$data->date}}</td>
                        <td>{{$data->shift}}</td>
                        <td>

                                <button title="Edit Checksheet" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button title="Delete Checksheet" class="btn btn-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <a title="Detail Checksheet" href="{{url('/checksheet/detail/'.encrypt($data->id))}}" class="btn btn-info btn-sm me-2"><i class="fas fa-info"></i></a>
                                @if($data->status == 0)
                                    <a href="{{ url('/checksheet/form/' . encrypt($data->id)) }}" class="btn btn-success btn-sm" title="Continue Work">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                @endif
                        </td>
                    </tr>

                    {{-- Modal Update --}}
                    <div class="modal fade" id="modal-update{{ $data->id }}" tabindex="-1" aria-labelledby="modal-update{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="modal-update{{ $data->id }}-label">Edit Dropdown</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/mst/shop/update/'.$data->id) }}" method="POST">
                              @csrf
                              @method('patch')
                              <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="model_name" name="model_name" placeholder="Enter Model Name" required>
                                </div>
                                <br>
                                <div class="form-group">
                                  <input value="{{$data->model}}" type="text" class="form-control" id="model_name" name="model_name" placeholder="Enter Model Name" required>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    {{-- Modal Update --}}

                    {{-- Modal Delete --}}
                    <div class="modal fade" id="modal-delete{{ $data->id }}" tabindex="-1" aria-labelledby="modal-delete{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-delete{{ $data->id }}-label">Delete Shop Master</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/mst/shop/delete/'.$data->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <div class="modal-body">
                                <div class="form-group">
                                Are you sure you want to delete <label for="Dropdown">{{ $data->model }}</label>?
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    {{-- Modal Delete --}}

                    {{-- Modal Access --}}
                    <div class="modal fade" id="modal-access}">
                      <div class="modal-dialog">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title">Give User Access</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <form action="{{ url('') }}" enctype="multipart/form-data" method="GET">
                          @csrf
                          <div class="modal-body">

                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-dark btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Submit">
                          </div>
                          </form>
                          </div>
                          <!-- /.modal-content -->
                      </div>
                    <!-- /.modal-dialog -->
                    </div>
                    {{-- Modal Revoke --}}

                    @endforeach
                  </tbody>
                </table>
              </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>


</main>
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
