@extends('system.master')

@section('content')
    <main class="main">
        <div class="fixing-container">
            <div class="container">
                <div class="row">

                    @include('components.fixing-sidebar')

                    <div class="col-lg-9">
                        <div class="brand-product">
                            <div class="brand-fixing-container">
                                {{ Breadcrumbs::render('fixing-type-with-brand', $manufacturer) }}
                                <h1 class="main-title">
                                    {{ $manufacturer->title }}
                                </h1>


                                @include('components.common.inner-search', ['selector' => '.fixing-brand-card p'])
                            </div>
                            <h3 class="small-title">
                                Популярные модели:
                            </h3>
                            <div class="row fixing-brand-card-row">
                                @foreach($manufacturer->models as $model)
                                    @include('components.fixing.model', $model)
                                @endforeach
                            </div>

                            <h3 class="small-title">
                                Другие модели:
                            </h3>

                            <div class="row fixing-brand-card-row">
                                <a href="#" class="col-lg-4 col-md-4 col-6">
                                    <div class="fixing-brand-card">
                                        <p>
                                            iPhone 6
                                        </p>
                                    </div>
                                </a>
                            </div>

                            <div class="pagination d-flex align-items-center justify-content-center">
                                <a href="#" class="get-back pagination-bullet">
                                    &lt;&lt;
                                </a>
                                <a href="#" class="pagination-bullet">
                                    1
                                </a>
                                <a href="#" class="pagination-bullet active">
                                    2
                                </a>
                                <a href="#" class="pagination-bullet">
                                    3
                                </a>
                                <a href="#" class="pagination-bullet get-next">
                                    &gt;&gt;
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
