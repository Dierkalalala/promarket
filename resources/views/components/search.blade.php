@extends('system.master')

@section('content')
<main class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 shop-sidebar login-content sidebar">

                <div class="shop-sidebar-wrapper">

                   <x-search-filter search="{{request('query')}}" />
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="shop-main-wrapper brand-product">
                    <div class="collapsing-control">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="bread-crumbs">
                                <ul class="d-flex">
                                    <li class="bread-crumb-link bread-crumb-link-prev">
                                        <a href="#">
                                            Главная
                                        </a>
                                    </li>
                                    <li class="bread-crumb-link">
                                        Поиск  
                                    </li>
                                </ul>
                            </div>
                            <div class="market_sorting-wrapper">
                                <div class="market_sorting d-flex align-items-center">
                                    <a href="#" class="market-sorting-trigger">
                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0)">
                                                <path d="M3 17H9V15H3V17ZM3 5V7H21V5H3ZM3 12H15V10H3V12Z"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0">
                                                    <rect width="24" height="24" fill="white"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <span>Сортировать</span>
                                    </a>
                                    <a href="#" class="market-sorting-trigger market-filtering-trigger">
                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0)">
                                                <path d="M3 17H9V15H3V17ZM3 5V7H21V5H3ZM3 12H15V10H3V12Z"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0">
                                                    <rect width="24" height="24" fill="white"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <span>Фильтры</span>
                                    </a>
                                    <a href="#" class="market-make-list">
                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="M3 5V19H20V5H3ZM7 7V9H5V7H7ZM5 13V11H7V13H5ZM5 15H7V17H5V15ZM18 17H9V15H18V17ZM18 13H9V11H18V13ZM18 9H9V7H18V9Z"/>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="sorting-controller">
                            <div class="sorting-pages d-flex justify-content-between align-items-center">
                                <div class="sorting-pagination">
                                <span class="muted">
                                    {{$results->currentPage()}}-{{$results->count()}} из {{$results->total()}}
                                </span>
                                </div>
                                  <div class="d-flex align-items-center sorting-filter-row">
                                            <div class="sorting-filter select-drop-down drop-down-sorting sorting">
                                                <select name="order" id="order"
                                                        class="sorting_select sorting-filter-content dropping__element__wrapper1">
                                                    <option value="ASC" style="padding: 10px">Цена по возрастанию
                                                    </option>
                                                    <option value="DESC">Цена по убыванию</option>
                                                </select>
                                            </div>
                                            <div class="sorting-filter select-drop-down drop-down-sorting showing">
                                                <select name="per_page" id="per_page"
                                                        class="sorting_select sorting-filter-content dropping__element__wrapper1">
                                                    <option value="12">Показать 12</option>
                                                    <option value="24">Показать 24</option>
                                                    <option value="48">Показать 48</option>
                                                    <option value="120">Показать 120</option>
                                                </select>
                                            @csrf
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="small-title">
                        по запросу '{{ request('query') }}' было найдено {{ $results->count() }} результата
                    </h3>
                    <div id="sort">
                        <div class="row additional-commodities-wrapper">
                                <!-- <h2>{{-- ucfirst($type) --}}</h2> -->
                                @foreach($results as $product)  
                                   <div class="col-lg-4 col-md-4 col-6">
                                                @include('components.market.card', compact('product'))
                                            </div>
                                @endforeach
                          
                        </div>
                    {{$results->onEachSide(1)->links('components.pagination')}}
                </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
     var url = '<?= Request::url(); ?>';
        $('.sorting_select').change(function () {
            var token = $('input[name="_token"]').val();
            var min_price = $('input[name="min_price"]').val();
            var max_price = $('input[name="max_price"]').val();
            var order = $('#order').children("option:selected").val();
            var per_page = $('#per_page').children("option:selected").val();
            console.log(order);
            console.log(per_page);
            var quantity = [];
            var device = [];
            var manufacturer = [];
            var model = [];
            var color = [];
            $.each($(".filter-el input[name='quantity']:checked"), function () {
                quantity.push($(this).val());
            });
            $.each($(".filter-el input[name='device']:checked"), function () {
                device.push($(this).val());
            });
            $.each($(".filter-el input[name='manufacturer']:checked"), function () {
                manufacturer.push($(this).val());
            });
            $.each($(".filter-el input[name='model']:checked"), function () {
                model.push($(this).val());
            });
            $.each($(".filter-el input[name='color']:checked"), function () {
                color.push($(this).val());
            });

            data = {
                'filter': '1',
                'min_price': min_price,
                'max_price': max_price,
                'order': order,
                'per_page': per_page,
                'attrs': {
                    'quantity': quantity,
                    'manufacturer': manufacturer,
                    'model': model,
                    'color': color,
                }
            };
            console.log(data);
            $.ajax({
                type: 'POST',
                url: url,
                data: data
            }).done(function (data) {
                $('#sort').html(data);
            });

        });
</script>

@endsection
 