@extends('system.master')

@section('content')

    <main class="main contacts-page">
        <div id="map"></div>
        <div class="auth-container">
            <section class="office-contacts">
                <div class="container">
                    <div class="small-title my-4">
                        сервисные центры
                    </div>
                    <div class="office-cards d-flex justify-content-center">
                        <div class="office-card">
                            <div class="office-photo">
                                <img src="" alt="">
                            </div>
                            <div class="office-card-info">
                                <img src="{{ asset('assets/img/offices/pin.svg') }}" alt="pin">
                                <span>Anniņmuižas 17</span>
                            </div>
                            <div class="office-card-info">
                                <img src="{{asset('assets/img/offices/phone-24px 1.svg')}}" alt="tel">
                                <span>25519951</span>
                            </div>
                            <div class="office-card-info">
                                <img src="{{asset('assets/img/offices/alternate_email-24px 1.svg')}}" alt="mail">
                                <span>info@promarket.lv</span>
                            </div>
                            <div class="office-card-info">
                                <img src="{{asset('assets/img/offices/local_parking-24px 2.svg')}}" alt="parking">
                                <span>Бесплатная парковка</span>
                            </div>
                        </div>
                        <div class="office-card">
                            <div class="office-photo">
                                <img src="" alt="">
                            </div>
                            <div class="office-card-info">
                                <img src="{{asset('assets/img/offices/pin.svg')}}" alt="pin">
                                <span>Ģertrudes 77</span>
                            </div>
                            <div class="office-card-info">
                                <img src="{{asset('assets/img/offices/phone-24px 1.svg')}}" alt="tel">
                                <span>25519270</span>
                            </div>
                            <div class="office-card-info">
                                <img src="{{asset('assets/img/offices/alternate_email-24px 1.svg')}}" alt="mail">
                                <span>info@promarket.lv</span>
                            </div>
                            <div class="office-card-info">
                                <img src="{{asset('assets/img/offices/local_parking-24px 2.svg')}}" alt="parking">
                                <span>Бесплатная парковка</span>
                            </div>
                        </div>
                    </div>
                    <div class="small-title mt-5 mb-3">
                        Форма обратной связи
                    </div>
                    <div class="mb-5 px-5 text-center hide-for-mobile">Вы можете оставить отзыв, поинтересоваться наличием товаром или узнать что-то в отношении ремонта техники.
                        Все что угодно, мы обязательно ответим вам.</div>
                    <div class="row">
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 m-auto">
                            <div class="call-back-form">
                                <form>
                                    <div class="call-back-form-wrapper">
                                        <label>
                                            <input type="text" placeholder="Имя" class="auth_control">
                                        </label>
                                        <label>
                                            <input type="email" placeholder="Электронная почта"
                                                   class="auth_control">
                                        </label>
                                        <label>
                                            <input type="number" placeholder="Ваш телефон" class="auth_control">
                                        </label>
                                        <div class="d-flex radio-buttons-row align-items-center justify-content-center">
                                            <label class="radio-type">
                                                <input type="radio" name="call-back-option">
                                                <span>
                                            Свяжитесь со мной по телефону
                                        </span>
                                            </label>
                                            <label class="radio-type">
                                                <input type="radio" name="call-back-option">
                                                <span>
                                            Свяжитесь со мной по email
                                        </span>
                                            </label>
                                        </div>
                                        <label class="textarea-label">
                                    <textarea placeholder="Комментарий к заказу"
                                              class="auth_control"></textarea>
                                        </label>
                                        <button class="default-button call-back-form-button" type="submit">
                                            отправить
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="our-team-section">
                    <div class="container">
                        <div class="small-title ">
                            наша команда
                        </div>
                        <div class= "our-team d-flex justify-content-center">
                            <div class="our-team-employee">
                                <div class="employee-photo">
                                    <img src="" alt="">
                                </div>
                                <div class="our-team-employee-name">
                                    Sed accumsan
                                </div>
                                <div>
                                    magna sit amet sodales ullamcorper
                                </div>
                            </div>
                            <div class="our-team-employee">
                                <div class="employee-photo">
                                    <img src="" alt="">
                                </div>
                                <div class="our-team-employee-name">
                                    Sed accumsan
                                </div>
                                <div>
                                    magna sit amet sodales ullamcorper
                                </div>
                            </div>
                            <div class="our-team-employee">
                                <div class="employee-photo">
                                    <img src="" alt="">
                                </div>
                                <div class="our-team-employee-name">
                                    Sed accumsan
                                </div>
                                <div>
                                    magna sit amet sodales ullamcorper
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

@endsection
