@extends('layouts.app')

@section('title')
    {{$data->name}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('') }}modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('')}}modules/jquery-selectric/selectric.css">
@endpush

@section('content')
@if (session()->has('success'))
    <div class="alert alert-success">
        {{session()->get('success')}}
    </div>
@endif
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data Mahasiswa Pada Semester {{$data->name}}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Data Mahasiswa Yang Belum Memiliki Semester</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bodered table-striped text-center" id="table" style="width: 100%">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white text-center">Nim Mahasiswa</th>
                            <th class="text-white text-center">Nama Mahasiswa</th>
                            <th class="text-white text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <form action="{{route('admin.semesters.saveMhs')}}" method="POST">
        @csrf
        <input type="hidden" name="semesters_id" value="{{$data->id}}">
        <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                   <table class="table table-bodered table-striped text-center" id="table" style="width: 100%">
                       <thead class="bg-primary">
                           <tr>
                               <th class="text-white text-center">#</th>
                               <th class="text-white text-center">Nim Mahasiswa</th>
                               <th class="text-white text-center">Nama Mahasiswa</th>
                           </tr>
                       </thead>
                       <tbody>
                        @forelse ($mhs as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="users_id[]" id="users_id" value="{{$item->id}}">
                                </td>
                                <td>
                                    {{$item->username}}
                                </td>
                                <td>
                                    {{$item->name}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Tidak Ada Data Mahasiswa</td>
                            </tr>
                        @endforelse
                       </tbody>
                   </table>
               </div>
               {{$mhs->links()}}
            </div>
        </div>
    </form>
  </div>
</div>
@endsection

@push('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ganti Semester</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        @csrf
        @method("PUT")
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
            <div class="form-group">
                <label for="">Pilih Semester</label>
                <select name="semesters_id" id="semesters_id" class="form-control">
                    @foreach ($semesters as $sm)
                        <option value="{{$sm->id}}">{{$sm->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="enroll_update">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endpush

@push('js')
    <script src="{{ asset('') }}modules/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('')}}modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script>
        $(document).ready(function() {
            let table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{url('/admin/semesters/' . $data->id)}}",
                columns: [
                    {data: 'nim'},
                    {data: 'name'},
                    {data: 'action'},
                ]
            });

            $(document).on('click', '#enroll', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: "{{url('/admin/semesters/edit')}}/" + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $("#exampleModal").modal('show');
                        $("#id").val(data.id)
                        $("#semesters_id").val(data.semesters_id)
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })

            $("#enroll_update").click(function(e) {
                e.preventDefault();
                let id = $("#id").val();
                let semesters_id = $("#semesters_id").val();
                $.ajax({
                    url: "{{url('/admin/semesters/enroll')}}/ " + id,
                    method: 'PUT',
                    data: {
                        semesters_id: semesters_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        $("#exampleModal").modal('hide');
                        let timerInterval;
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil..",
                            html: "Data akan di enroll dalam <b></b> milliseconds.",
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                                table.draw();
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                table.draw();
                            }
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })
        })
    </script>
@endpush