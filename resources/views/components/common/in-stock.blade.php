@if($quantity > 2)
    <img src="{{asset('assets/img/common/tick.svg')}}" alt="">
    <span>
                                                       В наличии
                                                    </span>
@elseif ($quantity > 0)
    <img src="{{asset('assets/img/common/low.svg')}}" alt="">
    <span>
                                                            1  в наличии
                                                        </span>
@else
    <img src="{{asset('assets/img/common/order.svg')}}" alt="">
    <span>
                                                            Под заказ
                                                        </span>
@endif