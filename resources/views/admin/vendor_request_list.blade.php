@extends('layouts.app')
@section('content')
<!-- Main content -->
<div class="content-wrapper">
  <div class="card">
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
          <h4 class="page-title">Manage Requests</h4>
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
            <th>Status</th>
            <th>Create Date</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
        <?php $i=1 ;?>
         @foreach($requestlists as $requestlist)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{$requestlist->company_name}}</td>
            <td>{{$requestlist->company_email}}</td>
            <td>{{$requestlist->company_phone}}</td>
            <td>@if($requestlist->status==0) Pending @elseif($requestlist->status==1) Accepted @else Decline @endif</td>
            <td>{{date('d M Y g:i a',strtotime($requestlist->created_at." UTC"))}}</td>
            <td>
              @if($requestlist->status==0)
                <a href="javascript:void();" onclick="requestapprove({{$requestlist->id}});" title="Approve">Accept</a>
                <a href="javascript:void();" onclick="requestdecline({{$requestlist->id}});" title="Decline">Decline</a>
              @else
                <a href="javascript:void();" onclick="requestapprove({{$requestlist->id}});" title="Invoices">Invoices</a>
              @endif
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

<div class="modal fade" id="editstatus" tabindex="-1" role="dialog" aria-labelledby="editstatus" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ url('vendorrequest/changestatus') }}" method="post" id="myform1" class="form-horizontal">
      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
      <input type="hidden" name="requestid" id="requestid">
      <input type="hidden" name="status" id="status">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel-4">Update Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 10px;">
        <div class="form-group" id="statuscomment"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Yes</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
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

  function requestapprove(id){
    $("#requestid").val(id);
    $("#status").val(1);
    $("#statuscomment").html("Do you want to Accept this request?");
    $("#editstatus").modal('show');
  }

  function requestdecline(id){
    $("#requestid").val(id); 
    $("#status").val(2);
    $("#statuscomment").html("Do you want to Decline this request?");
    $("#editstatus").modal('show');
  }

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