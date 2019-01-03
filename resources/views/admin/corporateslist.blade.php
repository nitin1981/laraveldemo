@extends('layouts.app')
@section('content')
<!-- Main content -->
<div class="content-wrapper">
  <div class="card">
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
          <h4 class="page-title">Manage Corporates</h4>
          <div class="d-flex align-items-center">
            <div class="wrapper">
              <button type="button" class="btn btn-primary btn-fw" data-toggle="modal" data-target="#addcorporate"><span class="fa fa-plus"> &nbsp;</span>Add Corporate</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 table-responsive">
          <table id="order-listing" class="table">
          <thead>
          <tr>
            <th>Sr. No.</th>
            <th>Name</th>
            <th>Email Id</th>
            <th>Phone Number</th>
            <th>Create Date</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
        <?php $i=1 ;?>
         @foreach($corporates as $corporate)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{$corporate->name}}</td>
            <td>{{$corporate->email}}</td>
            <td>{{$corporate->phone}}</td>
            <td>{{date('d M Y g:i a',strtotime($corporate->created_at." UTC"))}}</td>
            <td>
              <a href="javascript:void();" data-toggle="modal" data-target="#editcorporate{{$corporate->id}}" title="Edit"><i class="fa fa-edit"></i></a>
            </td>
          </tr>
         @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

@foreach($corporates as $corporate)

<div class="modal fade" id="editcorporate{{$corporate->id}}" tabindex="-1" role="dialog" aria-labelledby="editcorporate{{$corporate->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ url('corporates/update') }}" method="post" id="myform1" class="form-horizontal">
      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
      <input type="hidden" name="corporate_id" value="{{$corporate->id}}">
      <input type="hidden" name="user_id" value="{{$corporate->user_id}}">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel-4">Edit Corporate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 10px;">
        <div class="form-group">
          <label for="name" class="col-form-label">Name:</label>
          <input type="text" class="form-control" id="name" required name="corporatename" value="{{$corporate->name}}">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Email ID:</label>
          <input type="text" class="form-control" required name="corporatemail" value="{{$corporate->email}}">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col">
              <label for="name" class="col-form-label">Phone Number:</label>
              <input type="text" class="form-control" id="name" name="corporatephone" value="{{$corporate->phone}}">
            </div>
            <div class="col">
              <label for="name" class="col-form-label">Unique Id:</label>
              <input type="text" class="form-control" id="name" name="corporatephone" value="{{$corporate->phone}}">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endforeach
<div class="modal fade" id="addcorporate" tabindex="-1" role="dialog" aria-labelledby="addcorporate" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:60%;">
    <div class="modal-content">
      <form action="{{ url('corporates/save') }}" method="post" id="myform1" class="form-horizontal">
      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel-4">Add Corporate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 10px;">
        <div class="form-group">
          <div class="row">
            <div class="col">
              <label for="name" class="col-form-label">Corporate Name:</label>
              <input type="text" class="form-control" id="name" required name="corporatename" value="">
            </div>
            <div class="col">
              <label for="message-text" class="col-form-label">Email ID:</label>
              <input type="text" class="form-control" required name="corporatemail" value="">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col">
              <label for="name" class="col-form-label">Phone Number:</label>
              <input type="text" class="form-control" id="name" name="corporatephone" value="">
            </div>
            <div class="col">
              <label for="name" class="col-form-label">Unique Id:</label>
              <input type="text" class="form-control" id="name" name="uniqueid" value="">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
@include('layouts.includes.message_boxes')
@endsection
@section('js')
<script src="{{ asset('public/js/wizard.js')}}"></script>
<script type="text/javascript">
  $(function () {
    $('.select2').select2({});

    $("#example1").dataTable({
      paging: false
    });

    $('.dateSelect').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd-mm-yyyy',
    });
  });

  function openmailmodel(id){
    var vouchercode = $("#vcode"+id).val();
    $("#voucherid").val(id);
    $("#vouchercode").html(vouchercode);
    $('#sendvoucher').modal({
        show: 'false'
    }); 
  }
</script>
@endsection