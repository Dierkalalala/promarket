@extends('system.master')

@section('content')
<main class="main">
 <div class="auth-container">
    <section class="login login-primary-page">
      <div class="container">
          {{ Breadcrumbs::render('auth') }}
        <div class="login-content">
          <h1 class="main-title">
            Войти в систему
          </h1>
          <form novalidate="novalidate" method="POST" action="{{ route('login') }}" class="login_form">
            @csrf
            <div class="outer-service-auth-wrapper">
              @foreach(['facebook', 'google'] as $provider)
                  <a class="btn btn-link {{ $provider }}-auth outer-service-auth" href="{{ route('social.login', ['provider' => $provider]) }}">
                  <img src="{{ asset('assets/img/common/') }}/{{$provider}}_login.svg" alt="">
                <span>
                Войти через {{ ucwords($provider)}}
              </span></a>
              @endforeach
            </div>
            <label>
              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>  {{ $errors->first('email') }}</strong>
                  </span>
              @enderror
              <input class="auth_control" placeholder="Электронная почта" type="email" name="email">
            </label>
            <label>
              @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @enderror
              <input class="auth_control" placeholder="Пароль" type="password" name="password">
            </label>
            <button type="submit" class="submit-form default-button">
              OK
            </button>
            <div class="additional-auth-links">
              <div class="forgot-password">
                 @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                           Я забыл пароль! <span class="underlined"> Восстановить его скорее</span>
                        </a>
                @endif
              </div>
              <div class="account-registration">
                <a href="{{ route('register') }}">
                  Нет аккаунт? <span class="underlined"> Зарегистрироваться</span>
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</main>


<script>
    // $(function() {

    //     var app = {
    //         DOM: {},
    //         init: function () {

    //             // only applies to register form
    //             if (window.location.pathname == '/login') {

    //                 this.DOM.form = $('form');
    //                 this.DOM.form.email = this.DOM.form.find('input[name="email"]');
    //                 this.DOM.form.token = this.DOM.form.find('input[name="_token"]');
    //                 this.DOM.form.pwd   = this.DOM.form.find('input[name="password"]');


    //                 this.DOM.form.email.group = this.DOM.form.email.prev('span.error');
    //                 this.DOM.form.pwd.group = this.DOM.form.pwd.prev('span.error');
    //                 this.DOM.form.submit( function(e) {
    //                     e.preventDefault();

    //                     var self = this; // native form object

    //                     error = {};

    //                     app.DOM.form.email.group.find('strong').text('');
    //                     app.DOM.form.pwd.group.find('strong').text('');

    //                     app.DOM.form.email.group.removeClass('has-error');
    //                     app.DOM.form.pwd.group.removeClass('has-error');

    //                     var user = {};
    //                     user.email = app.DOM.form.email.val();
    //                     user.token = app.DOM.form.token.val();
    //                     user.password = app.DOM.form.pwd.val();

    //                     var request = $.ajax({
    //                         headers: {
    //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                         },
    //                         url: '/login',
    //                         type: 'POST',
    //                         contentType: 'application/json',
    //                         data: JSON.stringify(user)
    //                     });
    //                     request.done( function(data)
    //                     {
    //                         // native form submit
    //                         self.submit();
    //                     });
    //                     request.fail( function(jqXHR)
    //                     {
    //                         error = jqXHR.responseJSON;
    //                         // alert(error.errors.email);
    //                         console.log(error.errors);

    //                         if (error.errors.email) {
    //                             app.DOM.form.email.group.find('strong').text(error.errors.email[0]);
    //                             app.DOM.form.email.group.addClass('has-error');
    //                         }
    //                         if (error.errors.password) {
    //                             app.DOM.form.pwd.group.find('strong').text(error.errors.password[0]);
    //                             app.DOM.form.pwd.group.addClass('has-error');
    //                         }

    //                     });

    //                 });
    //             }
    //         }
    //     }

    //     app.init();

    // });

$(document).ready(function(){

  $.extend($.validator.messages, {
      required: "Это поле обязательно для заполнения",
      email: "Пожалуйста, введите действительный адрес электронной почты."
});

$("form.login_form").validate({
    rules: {

      email: {
        required: true,
        email: true
      },
      password: {
        required: true
      }
    },
    ignore: [],
    errorPlacement: function (error, element) {
               $(error).insertAfter(element.prev(".error"));
           },

});

});
    </script>

@endsection
