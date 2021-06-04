<div class="search-result">
    @if(!empty($products))
        <div class="results_product">
        <h3>{{__("store")}} {{ $products->total() }}</h3>
        <ul>
	        @foreach($products as $result)
             <li class="result_item">
                <img src="{{ $result->img }}">
                <p><a href="{{ route('shop-inner', [$result->subCategory[0]->category->code, $result->subCategory[0]->code, $result->code]) }}">{{$result->name}}</a>
                <span class="price">€ {{ $result->price }}</span></p>

             </li>
             @endforeach
        </ul>
        </div>
    @endif

    @if(!empty($fixing_details))
        <div class="results_fixing">
        <h3>{{__("repairs")}} {{ $fixing_details->total() }}</h3>
        <ul>
            <?php $i = 1; ?>
            @foreach($fixing_details as $result2)
               @if($i <= 3)
             <li class="result_item">
                     <img src="{{Voyager::image($result2->manufacturerModel->manufacturer->fixingType->small_img) }}">
                <p><a href="{{ route('fixing-order-detail', [$result2->manufacturerModel->manufacturer->fixingType->code, $result2->manufacturerModel->manufacturer->code, $result2->manufacturerModel->code]) .'?id='.$result2->id }}">{{$result2->name}}</a>
                <span class="price">€ {{ $result2->price }}</span></p>

             </li>
             @endif
             <?php $i++; ?>
             @endforeach
        </ul>
        </div>
    @endif

    <div class="link_all_result"><a class="all_results" href="#">+ {{__("See more")}}</a></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.all_results').click(function(){
            $('.search_form_submit').trigger('click');
        });
    });
</script>
