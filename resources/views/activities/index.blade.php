@extends('layouts.base')
@section('content')
<div class="container-sm">
   <div class="row">
     <div class="col ">
            <h1>Actividades   
              <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">Agregar</button>
            </h1>
           </div> 
           <div class="col col-lg-2">
               <button type="button"  onclick="logout()" class="btn btn-default  "> 
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0d6efd" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
              </button>
           </div>
     </div>
      
           
           
        <table id="example" class="table mt-3 activities-datatable" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
               <th>Activividad</th>
                <th>Horas</th>
                 <th></th>
            </tr>
        </thead>
    </table>
        </div>
<!-- modal -->
@include('activities.modal-form')
<!-- /.modal -->

<script>
  let ACTIVITY_ID;
$(document).ready(function() {
    listActivities();
} );
$('#exampleModal').on('hidden.bs.modal', function () {
  $('#form-activity').trigger("reset");
  $('#form-times').trigger("reset");
  $('.modal-title').html("Agregar actividad");
  
})
$("#form-activity" ).submit(function( event ) {

    event.preventDefault();
    const USER_TOKEN =  Cookies.get('USER-TOKEN');
    const USER_ID =  Cookies.get('USER-ID');

    let json ={ 
      name:$('input[name=activity]').val(),
      user_id:USER_ID
    }
    console.log( ACTIVITY_ID)
    console.log( ACTIVITY_ID?'actualizar':'crear')

    ACTIVITY_ID?editActivity(json):saveActivity(json)

});

function saveActivity(json){
  $.ajax({
        url:"{{ route('store') }}",
        type:"POST",
        data:json,
        dataType:'JSON',
    }).done(function (data) {
      const{ message,activity_id} = data
      ACTIVITY_ID = activity_id;
      if(ACTIVITY_ID){
        $("#fieldset-activity").attr('disabled','disabled');
        $("#fieldset-times").prop('disabled', false);
        listActivities();
        swal("",message, "success");
        return 
      }
      swal("",message, "error");
     
    }).fail(function(error) {
      swal("", "Error procesando datos", "error");
    })
}
function editActivity(json){
  $.ajax({
        url:`/${ACTIVITY_ID}`,
        type:"PUT",
        data:json,
        dataType:'JSON',
    }).done(function (data) {
      const{ message,error} = data
      if(!error){
        listActivities();
        swal("",message, "success");
        return 
      }
      swal("",message, "error");
     
    }).fail(function(error) {
      swal("", "Error procesando datos", "error");
    })
}


function getActivity (id){
   $('.modal-title').html("Actualizar actividad");
   ACTIVITY_ID = id;
   
     $('#button-img-activity').attr("src",'{{asset("images/edit.svg") }}')
   $.ajax({
        url:`/${ACTIVITY_ID}`,
        type:"GET",
        dataType:'JSON',
    }).done(function (data) {
      $('input[name=activity]').val(data.name)
      listTimes(ACTIVITY_ID);
      $("#fieldset-times").prop('disabled', false);
    }).fail(function(error) {
      swal("", "Error procesando datos", "error");
    })
}

function deleteActivity (id,name){
    swal({
    title: "Eliminar actividad ?"+name,
    text: "Si einina la activida se eliminan los tienpos asociados a eta actividad",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
          url:`/${id}`,
          type:"DELETE",
          dataType:'JSON',
      }).done(function (data) {
        const {error,message} = data;
        if(error){
          swal("",error, "error");
        }
       listActivities();
      }).fail(function(error) {
        swal("", "Error procesando datos", "error");
      })
    } 
  });
}

$("#form-times" ).submit(function( event ) {
    event.preventDefault();
    let hours = $('input[name=hours]').val();
    if(hours<1){
      swal("",'Horas debe ser mayor a 0');
      return 
    }
    let json ={ 
      date_time:$('input[name=date_time]').val(),
      hours:$('input[name=hours]').val(),
      activity_id:ACTIVITY_ID
    }

   $.ajax({
        url:"{{ route('times.store') }}",
        type:"POST",
        data:json,
        dataType:'JSON',
    }).done(function (data) {
      const{ message,id} =  data[0]? data[0]:data
      if(id){
        $('#form-times').trigger("reset");
        listTimes(ACTIVITY_ID)
        listActivities();
        return 
      }
      swal("",message, "error");

    }).fail(function(error) {
      swal("", "Error procesando datos", "error");
    })

});

function deleteTime(id){
     $.ajax({
          url:`/times/${id}`,
          type:"DELETE",
          dataType:'JSON',
      }).done(function (data) {
        const {error} = data;
        if(error){
          swal("",error, "error");
        }
        listTimes(ACTIVITY_ID)
      }).fail(function(error) {
        swal("", "Error procesando datos", "error");
      })
}

function listActivities(){
    if ($.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy();
    }
    let table = $('#example').DataTable({
        processing: true,
        pageLength: 10,
        ajax: "{{ route('index') }}",

        
        columns: [
          {data: null},
           {data: 'name'},
          {data: 'hours'},
          {data: null,
              render: function ( data, type, row ) {
              let edit = '<button type="submit" onclick="getActivity('+ row.id+')"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-default button-add"> <img src="{{asset("images/edit.svg") }}" alt="" > </button>'
              let remove = '<button type="submit"  onclick="deleteActivity('+row.id+',\'' +row.name+ '\')" class="btn btn-default button-add"> <img src="{{asset("images/delete.svg") }}" alt="" > </button>'
              return edit+remove;
              
            }
          },
        ]
    });
    table.on('order.dt search.dt', function () {
      table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
          cell.innerHTML = i + 1;
      });
    }).draw();
    
}
function listTimes(id=null){
    if ($.fn.DataTable.isDataTable('#times-datatables')) {
        $('#times-datatables').DataTable().destroy();
    }
 
    let table = $('#times-datatables').DataTable({
        processing: true,
        paging:   false,
        info:     false,
        searching:false,
        ajax:{
          url:`times/activity/${id}`,
        },
        columns: [
          {data: null},
          {data: 'date_time'},
          {data: 'hours'},
          {data: null,
              render: function ( data, type, row ) {
              let remove = '<button type="submit"  onclick="deleteTime('+row.id+')" class="btn btn-default button-add"> <img src="{{asset("images/delete.svg") }}" alt="" > </button>'
              return remove;
              
            }
          }
        ]
    });
     table.on('order.dt search.dt', function () {
      table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
          cell.innerHTML = i + 1;
      });
    }).draw();
    
}

function logout() {
  $.ajax({
      url:" {{route('logout')}}",
      type:"POST",
      dataType:'JSON',
  }).done(function (data) {
    const {error,message} = data;
    if(error){
      swal("",error, "error");
    }
    Cookies.remove('USER-TOKEN')
    Cookies.remove('USER-ID')
    window.location.href = "/";
  }).fail(function(fail) {
    console.log(fail)
    const {responseJSON} = fail;
    const {error,message} = responseJSON
    if(error){
      swal("", "Error procesando datos", "error");
    }
    if(message){
      swal("",message, "error");
    }
  })
}

</script>
@endsection