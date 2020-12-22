@extends('system.master')

@section('content')

<main class="main lk-main">
    <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 sidebar lk-sidebar">
                    <div class="sidebar-profile-overview">
                        <div class="d-flex align-items-center profile-overview justify-content-between">
                            <div class="profile-photo">
                                <img src="{{ asset('/uploads/avatar/') }}/{{Auth::user()->avatar}}" alt="">
                            </div>
                            <div class="profile-name">
                                {{ Auth::user()->username }}
                                {{ Auth::user()->firstname }}
                            </div>
                        </div>
                    </div>
                    <ul class="lk-tabs-changers">
                        <li class="sidebar-item lk-tabs-changer active">
                            <a href="#">
                                <img src="{{ asset('assets/img/lk/orders_icon.svg') }}" alt="">
                                <span>
                                    {{__("Your orders")}}
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item lk-tabs-changer">
                            <a href="#">
                                <img src="{{ asset('assets/img/lk/account_icon.svg') }}" alt="">
                                <span>
                                    {{__("account settings")}}
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="{{ asset('assets/img/lk/quit_icon.svg') }}" alt="">
                                <span>
                                   {{__("Log out")}}
                                </span>
                            </a>

    						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    						    {{ csrf_field() }}
    						</form>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-9 col-md-8 lk-container">
                    <div class="lk-profile-bread-crumbs">
                        {{ Breadcrumbs::render('account') }}
                    </div>
                    <div class="alert">
                         @if(session()->has('success'))
                            <p class="alert alert-success text-center">{{session()->get('success')}}</p>
                        @endif
                        @if(session()->has('error'))
                        <p class="alert alert-error alert-danger text-center">{{session()->get('error')}}</p>
                        @endif
                      @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    </div>
                    <div class="lk-tabs-wrapper">
                        <div class="lk-table-container active">
                            <div class="lk-arrow-back d-flex align-items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g opacity="0.54">
                                        <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z"
                                              fill="#202020"/>
                                    </g>
                                </svg>
                                <span>
                                    {{__("Back")}}
                                </span>
                            </div>
                            <div class="lk-table-wrapper">
                                <div class="lk-table">
                                    <div class="lk-row lk-first-row d-flex">
                                        <div class="lk-first-col">
                                            {{__("Date")}}
                                        </div>
                                        <div class="lk-second-col">
                                            {{__("Order number")}}
                                        </div>
                                        <div class="lk-third-col">
                                            {{__("amount")}}
                                        </div>
                                        <div class="lk-fourth-col">
                                            {{__("Order status")}}
                                        </div>
                                    </div>
                                    <?php $orders = Auth::user()->orders; ?>
                                    @foreach($orders as $order)
                                    <a href="/profile/order/{{$order->id}}" class="lk-row d-flex">
                                        <div class="lk-first-col">
                                            {{ date('d.m.Y', strtotime($order->created_at)) }}
                                        </div>
                                        <div class="lk-second-col">
                                           {{ $order->id}}
                                        </div>
                                        <div class="lk-third-col">
                                            {{ $order->total_amout }} €
                                        </div>
                                        <div class="lk-fourth-col">
                                            @if($order->status == 1)
                                                Обрабатывается
                                            @endif
                                            @if($order->status == 2)
                                                Завершено
                                            @endif
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="lk-personal-data ">
                            <div class="block-first">
                                <div class="lk-arrow-back d-flex align-items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.54">
                                            <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z"
                                                  fill="#202020"/>
                                        </g>
                                    </svg>
                                    <span>
                                        {{__("Back")}}
                                    </span>
                                </div>
                                <div class="profile-first-row">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="profile-details">
                                            <div class="profile-details-photo">
                                                <img src="{{ asset('/uploads/avatar/') }}/{{Auth::user()->avatar}}" class="user_avatar" alt="" style="width: auto; height: inherit;">

                                            <label for="avatar">
                                                <div class="profile-change-photo-icon">

                                               <input id="avatar" type="file" name="file" style="z-index: -1;opacity: 0;width: 0;" value="{{Auth::user()->avatar}}" />
                                                 <img src="{{ asset('assets/img/lk/change-photo') }}.svg" class="" alt="" >

                                                </div>
                                                    </label>
                                            </div>
                                            <div class="profile-details-name">
                                                {{ Auth::user()->username }}
                                                {{ Auth::user()->firstname }}
                                            </div>
                                        </div>
                                        <div class="password-change">
                                            <div>
                                                {{__("Change Password")}}
                                            </div>
                                            <a href="{{route('profile.new-password')}}">
                                                {{__("Change Password2")}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-data">
                                    <h3 class="small-title">
                                       {{__("USER DATA")}}
                                    </h3>
                                    <div class="profile-additional-data-form">
                                        <form action="{{ route('profile.edit') }}" method="POST">
                                         <!--
                                            <input type="file" id="avatar" name="avatar" style="width: 0;height: 0;opacity: 0;"> -->
                                            <div class="d-flex radio-buttons-row align-items-center justify-content-center">
                                                <label class="radio-type">
                                                    <input type="radio" name="identification_type" value="0" @if(Auth::user()->identification_type == 0) checked="checked" @endif >
                                                    <span>
                                                        {{__(("Individual"))}}
                                                    </span>
                                                </label>
                                                <label class="radio-type">
                                                    <input  type="radio" name="identification_type" value="1" @if(Auth::user()->identification_type == 1) checked="checked" @endif>
                                                    <span>
                                                        {{__("legal entity")}}
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="profile-data-controls-wrapper">
                                                <div class="profile-data-item">
                                                    <label>
                                                        <input type="text" name="username" placeholder="{{__('First Name')}} " class="auth_control" value="{{ Auth::user()->username }}">
                                                    </label>
                                                    <label>
                                                        <input type="text" name="firstname" placeholder="{{__('Last Name')}} " class="auth_control" value="{{ Auth::user()->firstname }}">
                                                    </label>
                                                    <label>
                                                        <input type="email" name="email" placeholder="{{__('Email')}}" value="{{ Auth::user()->email }}" class="auth_control">
                                                    </label>
                                                    <label>
                                                        <input type="number" name="phone" placeholder="{{__('Phone Number')}} " class="auth_control"  value="{{ Auth::user()->phone }}">
                                                    </label>
                                                </div>
                                                <h3 class="small-title">
                                                    {{__('DELIVERY ADDRESS')}}
                                                </h3>
                                                <div class="profile-data-item">
                                                    <div class="address-drop-down-wrapper">
                                                        <div class="address-drop-down-trigger">
                                                            <input type="hidden" id="region" name="region" value="{{ Auth::user()->region }}">
                                                            <div class="changing">{{ Auth::user()->region }}</div>
                                                            <img src="{{ asset('assets/img/common/chevron-down.svg') }}" alt="">
                                                        </div>
                                                        <div class="address-drop-down">
                                                            <ul>
                                                                <li class="address-changer">Латвия</li>
                                                                <li class="address-changer">Латвия 2</li>
                                                                <li class="address-changer">Латвия 3</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <label>
                                                        <input type="text" name="city" placeholder="{{__('City')}}" class="auth_control" value="{{ Auth::user()->city }}">
                                                    </label>
                                                    <label>
                                                        <input type="text" name="delivery_address" placeholder="{{__('Delivery address')}} " class="auth_control" value="{{ Auth::user()->delivery_address }}">
                                                    </label>
                                                    <label>
                                                        <input type="number" name="postcode" placeholder="{{__('Postcode')}} " class="auth_control"  value="{{ Auth::user()->postcode }}">
                                                    </label>
                                                </div>
                                                <button class="default-button lk-submit-button" type="submit">
                                                    {{__("Save")}}
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="block-second" style="display: none;">
                                <div class="lk-order-arrow-back d-flex align-items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.54">
                                            <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z"
                                                  fill="#202020"/>
                                        </g>
                                    </svg>
                                    <a href="/profile">
                                        <span>
                                            {{__("Back")}}
                                        </span>
                                     </a>
                                </div>
                              

                                <div class="lk-inner-cards-wrapper">
                                   <form action="{{ route('profile.new-password') }}" method="POST">
                                     {{ csrf_field() }}
                                                <div class="profile-data-controls-wrapper">
                                                    <div class="profile-data-item">
                                                       
                                                        <label>
                                                         <input id="password" type="password" class="auth_control" name="new_password" required autocomplete="new-password"  placeholder="Введите новый пароль">
                                                        </label>
                                                        <label>
                                                            <input id="password-confirm" type="password" class="auth_control " name="password_confirmation" required autocomplete="new-password" placeholder="Введите новый пароль ещё раз">
                                                        </label>
                                                    </div>
                                                    <button class="default-button lk-submit-button" type="submit">
                                                        {{__("Save")}}
                                                    </button>
                                                </div>

                                            </form>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
    </div>
</main>
<script type="text/javascript">
$(".password-change a").click(function(e){
    e.preventDefault();
    // alert();
    $('.block-first').hide();
    $('.block-second').show();
});
$(".block-second .lk-order-arrow-back a").click(function(e){
    e.preventDefault();
    // alert();
    $('.block-second').hide();
    $('.block-first').show();
});
$('#avatar').change(function(){
    //on change event
    formdata = new FormData();
    if($(this).prop('files').length > 0)
    {
        file =$(this).prop('files')[0];
        formdata.append("file", file);
    }
    // alert(formdata);
    jQuery.ajax({
    url: '/profile/avatar',
    type: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (result) {
         console.log(result);
         $(".user_avatar").attr("src","uploads/avatar/" + result);
         $(".profile-photo img").attr("src","uploads/avatar/" + result);
         // play the audio file
    }
});
});
</script>

@endsection
