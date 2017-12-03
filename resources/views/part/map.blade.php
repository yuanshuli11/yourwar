@extends('layouts.app')

@section('content')
@include('layouts.cityinfo')

<div class="home-content">
    <div class="part-body">
        <div class="map_input"> 
        移动至 x:<input id="city_lng" placeholder="x" value="{{$userInfo['has_one_main_city']['lng']}}">y:<input id="city_lat" value="{{$userInfo['has_one_main_city']['lat']}}" placeholder="y">
        <button class="btn btn-info btn-sm" onclick="skipto()">移动</button>
        </div>
        <div class="row">
            @foreach($map['data'] as $item )
                <div  class="col-xs-6" >
                    <div ><a>{{$item['city']}}({{$item['lng'].','.$item['lat']}})@if(!$item['user_id']) {{$item['level']}}级 @endif</a></div>
                </div>
            @endforeach
        </div>
        <div class="show-page-btn">           
            <a class="btn btn-info btn-sm" href="{{ asset('/part/map?lng='.$pageBtn['left']['lng'].'&lat='.$pageBtn['left']['lat']) }}">左移</a>
            <a class="btn btn-info btn-sm" href="{{ asset('/part/map?lng='.$pageBtn['right']['lng'].'&lat='.$pageBtn['right']['lat']) }}">右移</a>
            <a class="btn btn-info btn-sm" href="{{ asset('/part/map?lng='.$pageBtn['up']['lng'].'&lat='.$pageBtn['up']['lat']) }}">上移</a>
            <a class="btn btn-info btn-sm" href="{{ asset('/part/map?lng='.$pageBtn['down']['lng'].'&lat='.$pageBtn['down']['lat']) }}">下移</a>
       </div>
    </div>

</div>
<script type="text/javascript">
   function skipto(){
    var lng = $("#city_lng").val();
    var lat = $("#city_lat").val();
    url = '{{ asset('/part/map') }}'+'?lat='+lat+'&lng='+lng;
    window.location.href=url;       
   }
</script>

@endsection