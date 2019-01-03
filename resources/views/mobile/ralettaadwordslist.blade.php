@extends('layouts.app_mobile')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.dataTables.css')}}">
<style>
td.details-control {
/*  text-align:center;
  color:forestgreen;*/
  cursor: pointer;
}
tr.shown{
  background-color: #f9f9f9 !important;
}
.leaddetails tr{
  background-color: #ececec !important; 
}
.dataTables_filter{
  text-align:right !important;
}
</style>
<input type="hidden" id="saveurl" value="{{url('storelead')}}">
<input type="hidden" id="updateurl" value="{{url('updatelead')}}">
<div class="content-wrapper" style="padding:1.5rem 0.7rem">
  <div class="row grid-margin">
    <div class="col-12">
      <div class="col-12 d-flex align-items-center justify-content-between" style="padding: 0px">
        <ol class="breadcrumb bg-light">
          <li class="breadcrumb-item"><a href="#">{{$leadtype_heading}}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{$leadstatus_heading}}</li>
        </ol>
      </div>
      <form action="{{ url('updateleadstatus') }}" method="post" id="myform1" style="top: -50px !important;position: relative;">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <input type="hidden" id="leadtype" name="leadtype" value="{{$leadtype_id}}">
        <input type="hidden" id="leadstatusid" name="leadstatusid" value="{{$leadstatusid}}">
        <div style="position: relative;z-index: 1;padding: 0px;float: right;right: -104px;" class="col-6">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addnewlead">&nbsp;<i class="fa fa-plus"></i></button>
          @if($leadstatusid==8)
              <a href="{{url('downloadcsv')}}" class="btn btn-link btn-sm font-weight-bold">
                <i class="icon-share-alt"></i>Export CSV</a>
          @endif
        </div>
        <table id="leadsdata" class="display" style="width: 100%;border: 1px solid rgba(242, 242, 242, 0.58);font-size: 12px; margin-top: 20px">
        <thead>
          <tr style="background-color: #fff">
            <th>#</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th></th>
          </tr>
        </thead>
        </table>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addnewlead" tabindex="-1" role="dialog" aria-labelledby="addnewleadLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="{{ url('storelead') }}" method="post" id="newlead" class="form-horizontal">
      <div class="modal-header">
        <h5 class="modal-title" id="addnewleadLabel">Add New Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 10px;">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" id="leadtype" name="leadtype" value="{{$leadtype_id}}">
        <input type="hidden" id="leadstatusid" name="leadstatusid" value="{{$leadstatusid}}">
        <div class="form-group row">
          <div class="col">
            <label class="col-form-label">Lead name:</label>
            <input type="text" class="form-control" name="leadname" required>
          </div>
          <div class="col">
            <label class="col-form-label">Phone Number:</label>
            <input type="text" class="form-control" name="phonenumber" required>
          </div>
        </div>
        <div class="form-group">
          <label class="col-form-label">Email:</label>
          <input type="text" class="form-control" name="leademail">
        </div>
        <div class="form-group row">
          <div class="col">
          <label class="col-form-label">Lead Source:</label>
          <select name="leadsource" class="form-control" required>
            @foreach($leadsources as $sourcerow)
            @if($sourcerow['id']==1)
              <option selected value="{{$sourcerow['id']}}">{{$sourcerow['name']}}</option>
            @else
              <option value="{{$sourcerow['id']}}">{{$sourcerow['name']}}</option>
            @endif
            @endforeach
          </select>
          </div>
          <div class="col">
          <label class="col-form-label">Lead Status:</label>
          <select name="leadstatus" class="form-control" required>
            @foreach($leadstatudata as $statusrow)
              <option value="{{$statusrow['id']}}">{{$statusrow['name']}}</option>
            @endforeach
          </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col">
            <label class="col-form-label">City:</label>
            <input type="text" class="form-control" name="leadcity">
          </div>
          <div class="col">
            <label class="col-form-label">Country:</label>
            <?php $countries_data = json_decode($countries); ?>
            <select name="leadcountry" onchange="loadstaesdata(this.value);" class="form-control">
              @foreach($countries_data as $countryd)
                @if($countryd->id==101)
                  <option selected value="{{$countryd->id}}">{{$countryd->name}}</option>
                @else
                  <option value="{{$countryd->id}}">{{$countryd->name}}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col">
            <label class="col-form-label">State:</label>
            <?php $states_data = json_decode($states); ?>
            <select name="leadstate" onchange="loadstaesdata(this.value);" class="form-control">
              @foreach($states_data as $stated)
                @if($stated->country_id==101)
                  <option value="{{$stated->id}}">{{$stated->name}}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="col">
            <label class="col-form-label">Pincode:</label>
            <input type="text" class="form-control" name="leadpincode">
          </div>
        </div>
        <div class="form-group row">
          <div class="col">
            <label class="col-form-label">Lead Owner:</label>
            <select name="leadowner" class="form-control">
              <option value=""></option>
            </select>
          </div>
          <div class="col">
            <label class="col-form-label">Lead Price:</label>
            <input type="text" class="form-control" name="leadprice">
          </div>
        </div>
        <div class="form-group row">
          <div class="col">
            <label class="col-form-label">Address1:</label>
            <input type="text" class="form-control" name="address1">
          </div>
          <div class="col">
            <label class="col-form-label">Address2:</label>
            <input type="text" class="form-control" name="address2">
          </div>
        </div>
        <div class="form-group">
          <label class="col-form-label">Note:</label>
          <input type="text" class="form-control" name="client_note">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<!-- Custom js for this page-->
<script type="text/javascript">
     $(document).ready(function(){
         var duplinumber = "{{$duplicatenumber}}";
         $(".select2").select2();
         var table = $('#leadsdata').DataTable({
             "data": <?=$raletta_adwords?>,
             select: "single",
             "ordering": false,
             "searching": false,
             paging: false,
             "columns": [
                 { "className": 'details-control',"data": "srno","width":"10px" },
                 { "className": 'details-control',"data": "leadname" },
                 { "className": 'details-control',"data": "phonenumber" },
                 { "data": "duplicate" },
             ],
             "order": [[1, 'asc']]
         });

         // Add event listener for opening and closing details
         $('#leadsdata tbody').on('click', 'td.details-control', function () {
             var tr = $(this).closest('tr');
             var tdi = tr.find("i.fa");
             var row = table.row(tr);
             if (row.child.isShown()) {
                 // This row is already open - close it
                 row.child.hide();
                 tr.removeClass('shown');
                 tdi.first().removeClass('fa-minus-square');
                 tdi.first().addClass('fa-plus-square');
             }
             else {
                 // Open this row
                 row.child(format(row.data())).show();
                 tr.addClass('shown');
                 tdi.first().removeClass('fa-plus-square');
                 tdi.first().addClass('fa-minus-square');
                 tr.next('tr').css('background-color','#ececec');
                 tr.next('tr').css('box-shadow','rgb(119, 98, 98) 0px 10px 8px -11px inset, rgb(119, 98, 98) 0px -10px 8px -12px inset');
             }
             tr.next('tr').find('td:nth-child').css('padding','5px');
         });

         $('#leadsdata tbody').on('click', "#"+duplinumber, function () {
             var tr = $(this).closest('tr');
             var tdi = tr.find("i.fa");
             var row = table.row(tr);
             if (row.child.isShown()) {
                 // This row is already open - close it
                 row.child.hide();
                 tr.removeClass('shown');
                 tdi.first().removeClass('fa-minus-square');
                 tdi.first().addClass('fa-plus-square');
             }
             else {
                 // Open this row
                 row.child(format(row.data())).show();
                 tr.addClass('shown');
                 tdi.first().removeClass('fa-plus-square');
                 tdi.first().addClass('fa-minus-square');
                 tr.next('tr').css('background-color','#ececec');
                 tr.next('tr').css('box-shadow','rgb(119, 98, 98) 0px 10px 8px -11px inset, rgb(119, 98, 98) 0px -10px 8px -12px inset');
             }
         });

         table.on("user-select", function (e, dt, type, cell, originalEvent) {
             if ($(cell.node()).hasClass("details-control")) {
                 e.preventDefault();
             }
         });

          $( "#"+duplinumber ).trigger( "click" );
     });

    function format(d){
         // `d` is the original data object for the row
         var leadsource = <?=$adminLeadSource;?>;
         var leadstatus = <?=$leadstatus;?>;
         var childrow = "";
         var countryname = 101;
         var leademail = "";
         if(d.leadcountry!=null){
          countryname = d.leadcountry;
         }
         if(d.leademail!=null){
          leademail = d.leademail;
         }

         var countries  = <?=$countries;?>;
         var states = <?=$states;?>;
         childrow = '<form action="{{ url('updatelead') }}" method="post" id="newlead" class="form-horizontal"><input type="hidden" value="{{csrf_token()}}" name="_token"><input type="hidden" id="leadtype" name="leadtype" value="{{$leadtype_id}}"><input type="hidden" id="leadstatusid" name="leadstatusid" value="{{$leadstatusid}}"><input type="hidden" id="leadstatusid" name="leadid" value="' + d.Id + '">'+
             '<table cellpadding="5" class="leaddetails" cellspacing="0" border="0">' +
             '<tr>' +
                 '<td style="border:0;">Name:<input type="text" class="form-control" value="' + d.leadname + '" name="leadname" style="font-size:14px;width:150px;"></td>' +
                 '<td style="border:0;">Email:<input type="text" class="form-control" value="'+leademail+'" name="leademail" style="font-size:14px;width:150px;"></td>' +
             '</tr><tr>' +
                 '<td style="border:0;">Source:<select name="leadsource" style="font-size:14px;width:150px;">';
                  $.each( leadsource, function( key, value ) {
                    if(d.leadsource==value.id){
                      childrow += '<option selected value="'+value.id+'">'+value.name+'</option>'; 
                    }else{
                      childrow += '<option value="'+value.id+'">'+value.name+'</option>'; 
                    }
                  });
         childrow += '</select></td>' +
                 '<td style="border:0;">Status:<select name="leadstatus" style="font-size:14px;width:150px;">';
                  $.each( leadstatus, function( key, value ) {
                    if(d.status==value.id){
                      childrow += '<option selected value="'+value.id+'">'+value.name+'</option>'; 
                    }else{
                      childrow += '<option value="'+value.id+'">'+value.name+'</option>'; 
                    }
                  });
         childrow += '</select></td>'+
         '</tr><tr>' +
                 '<td style="border:0;">Address1:<input type="text" placeholder="Address Line1" class="form-control" name="address1" value="' + d.address1 + '" style="font-size:14px;width:150px;"></td>' +
                 '<td style="border:0;">Address2:<input type="text" placeholder="Address Line2" class="form-control" name="address2" value="' + d.address2 + '" style="font-size:14px;width:150px;"></td>' +
          '</tr><tr>' +
                 '<td style="border:0;">City:<input type="text" placeholder="City" class="form-control" value="' + d.leadcity + '" name="leadcity" style="font-size:14px;width:150px;"></td>' +
                 '<td style="border:0;">Pincode:<input type="text" placeholder="Pincode" class="form-control" name="leadpincode" value="' + d.pincode + '" style="font-size:14px;width:150px;"></td>'+
             '</tr><tr>';
         childrow += '<td style="border:0;width:150px;">Country:<select name="leadcountry" onchange="loadstaes('+d.Id+',this.value);" class="select2" style="font-size:14px;">';
                  $.each( countries, function( key, value ) {
                    if(countryname==value.id){
                      childrow += '<option selected value="'+value.id+'">'+value.name+'</option>'; 
                    }else if(value.id==101){
                      childrow += '<option selected value="'+value.id+'">'+value.name+'</option>'; 
                    }else{
                      childrow += '<option value="'+value.id+'">'+value.name+'</option>'; 
                    }
                  });
         childrow += '</select></td>';
         childrow += '<td style="border:0;">State:<select name="leadstate" id="leadstate'+d.Id+'" class="select2" style="font-size:14px;width:150px;"><option value="">Select State</option>';
                  $.each( states, function( key, value ) {
                    if(value.country_id==101){
                      if(d.leadstate==value.id){
                        childrow += '<option selected value="'+value.id+'">'+value.name+'</option>'; 
                      }else{
                        childrow += '<option value="'+value.id+'">'+value.name+'</option>'; 
                      }
                    }
                  });
         childrow += '</select></td>'+
             '</tr>' +
             '<tr>' +
                 '<td colspan="2" style="border:0;">Note:<input class="form-control" style="width:100%;" type="text" value="' + d.note + '" name="client_note" style="font-size:14px;"></td>' +
             '</tr>' +
             '<tr>' +
                 '<td style="border:0;">Lead Owner:<select class="form-control" name="leadowner" style="font-size:14px;width:150px;"><option value=""></option></select></td>' +
                 '<td style="border:0;">Amount:<input type="text" placeholder="Amount" class="form-control" name="leadprice" value="'+d.leadprice+'" style="font-size:14px;"></td>' +
            '</tr><tr>' +
                 '<td colspan="2" style="text-align:right;border:0;"><a href="tel:'+ d.phonenumber +'" class="btn btn-success btn-fw" style="padding:10px;width: 100%;margin-top: 22px;"><i class="icon-call-out"></i>Call</a>' +
                 '<button class="btn btn-warning dropdown-toggle" style="padding:10px;width: 100%;margin-top: 22px;" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-magic-wand"></i>Action</button>'+
                      '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="width:100%;">'+
                        '<a class="dropdown-item" href="#"><i class="icon-paper-plane"></i>&nbsp;&nbsp;Quote</a><div class="dropdown-divider"></div>'+
                        '<a class="dropdown-item" href="#"><i class="icon-paypal"></i>&nbsp;&nbsp;Invoice</a><div class="dropdown-divider"></div>'+
                        '<a class="dropdown-item" href="sms:'+ d.phonenumber +'"><i class="icon-screen-smartphone"></i>&nbsp;&nbsp;SMS</a><div class="dropdown-divider"></div>'+
                        '<a class="dropdown-item" href="#"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Email</a><div class="dropdown-divider"></div>'+
                        '<a class="dropdown-item" href="#"><i class="icon-layers"></i>&nbsp;&nbsp;Logs</a><div class="dropdown-divider"></div>'+
                        '<a class="dropdown-item" href="https://api.whatsapp.com/send?phone=+91'+ d.phonenumber +'"><i class="fa fa-whatsapp" aria-hidden="true"></i>&nbsp;&nbsp;WhatsApp</a>'+
                      '</div>'+
                    '</div>' +
                 '<button type="submit" class="btn btn-primary btn-fw btn-lg" style="padding:10px;width: 100%;margin-top: 22px;"><i class="fa fa-save"></i>Update</button></td>' +
             '</tr>' +
         '</table></form>';  
         return childrow;
    }


    function checkAll(e) {
        var checkboxes = document.getElementsByTagName('input');
        if (e.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                    if($("#selestatus").val()!=""){
                      $("#updateleadstatus").removeAttr('disabled');
                    }
                    $("#junkleads").removeAttr('disabled');
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                  checkboxes[i].checked = false;
                  $("#updateleadstatus").attr('disabled','');
                  $("#junkleads").attr('disabled','');
                }
            }
        }
    }

    function loadstaes(cid,id){
      var states = <?=$states;?>;
      childrow = "<option value=''>Select State</option>";
      $.each( states, function( key, value ) {
        if(value.country_id==id){
          childrow += '<option value="'+value.id+'">'+value.name+'</option>'; 
        }
      });
      $("#leadstate"+cid).html(childrow);
    }

    function deleteconfirm(){
      var r = confirm("Are you sure? These leads will be deleted permanently!");
      if(r==true){
        var token = $("#token").val();
        var leadsid = [];
        var checkboxes = document.getElementsByTagName('input');
        for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].type == 'checkbox') {
            if(checkboxes[i].checked==true){
              leadsid.push(checkboxes[i].value);
            }
          }
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{URL::to('removeleads')}}",
            data: {
              _token: token,
              leadsid: leadsid,
            },
            success: function (response) {
              if(response.status=="success"){
                location.reload();
              }
            },
            error: function (data) {
              console.log('An error occurred.');
              console.log(data);
            },
        });
      }
    }

    function checkleadsbox(obj){
      var flag = false;
      var flagtrash = false;
      var checkboxes = document.getElementsByTagName('input');
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if(checkboxes[i].checked==true && $("#selestatus").val()!=""){
            flag = true;
          }
          if(checkboxes[i].checked==true){
            flagtrash = true;
          }
        }
      }
      if(flag==true){
        $("#updateleadstatus").removeAttr('disabled');
      }else{
        $("#updateleadstatus").attr('disabled','');
      }

      if(flagtrash==true){
        $("#junkleads").removeAttr('disabled');
      }else{
        $("#junkleads").attr('disabled','');
      }
    }

    $("#selestatus").change(function(){
      var checkboxes = document.getElementsByTagName('input');
      if($(this).val()==""){
        $("#updateleadstatus").attr('disabled','');
      }else{
        for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].type == 'checkbox') {
            if(checkboxes[i].checked==true){
              $("#updateleadstatus").removeAttr('disabled');
            }
          }
        }
      }
    });

  $(document).ready(function(){
    $('#show').avgrund({
      height: 500,
      holderClass: 'custom',
      showClose: true,
      showCloseText: 'x',
      onBlurContainer: '.container-scroller',
      template: '<p>So implement your design and place content here! If you want to close modal, please hit "Esc", click somewhere on the screen or use special button.</p>' +
        '<div>' +
        '<a href="http://twitter.com/voronianski" target="_blank" class="twitter btn btn-twitter btn-block">Twitter</a>' +
        '<a href="http://dribbble.com/voronianski" target="_blank" class="dribble btn btn-dribbble btn-block">Dribbble</a>' +
        '</div>' +
        '<div class="text-center mt-4">' +
        '<a href="#" target="_blank" class="btn btn-success mr-2">Great!</a>' +
        '<a href="#" target="_blank" class="btn btn-light">Cancel</a>' +
        '</div>'
    });
  });
</script>
@endsection