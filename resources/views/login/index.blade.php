@extends('layouts.base')
@section('content')
<div div class="container">
    <div class="row justify-content-center">
        <div class="row">
                <div class="col-md-6 login-form-1">
                    <h3>INGRESAR AL SISTEMA  </h3>
                    <form id="form-login" method="POST"  >
                        <div class="form-group">
                            <input 
                                type="text"
                                name="email" 
                                class="form-control" 
                                value="" 
                                required 
                                autocomplete="email"
                                autofocus
                            />
                        </div>
                        <div class="form-group">
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                 required 
                                placeholder="Your Password *" value="" 
                            />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                        <div class="form-group">
                            {{-- <a href="#" class="ForgetPwd">Forget Password?</a> --}}
                        </div>
                    </form>
                </div>
    </div>
</div>
<script>
$("#form-login" ).submit(function( event ) {
    event.preventDefault();
    let json ={ 
        email:$('input[name=email]').val(),
        password:$('input[name=password]').val()
    }

   $.ajax({
        url:"{{ env('API_REST',null)}}/login",
        type:"POST",
        data:json,
        dataType:'JSON',
    }).done(function (data) {
        Cookies.set('USER-TOKEN',data.token , { expires: 1 })
        Cookies.set('USER-ID',data.user_id , { expires: 1 })
        window.location.href = "/";
    }).fail(function(data) {
        const{errors, message} = data.responseJSON
        if(errors?.email){
            swal(message, errors.email[0]);
        }
        if(message==='Unauthorized'){
            swal('', 'Datos incorrecto');
        }
    })
});

</script>
@endsection