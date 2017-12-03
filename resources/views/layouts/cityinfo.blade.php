<div class="show-city">
        城市：{{$userInfo['has_one_main_city']['name']}}（{{$userInfo['has_one_main_city']['lng']}},{{$userInfo['has_one_main_city']['lat']}}）<a>切</a>
</div>
@if(isset($partName))
<div class="part-name">
    {{$partName}}
    @if($partName=="交易所")
    <div class="btn-group">
      <button type="button" class="btn btn-primary dropdown-toggle" style="padding:0px 3px" data-toggle="dropdown" aria-expanded="false">向商人购买 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a href="javascript:test()">向玩家购买</a></li>
        <li><a href="#">出售给玩家</a></li>
        <li><a href="#">交易商队</a></li>
        <li><a href="#">向商人购买</a></li> 
      </ul>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-primary dropdown-toggle" style="padding:0px 3px" data-toggle="dropdown" aria-expanded="false">
             稀矿 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a href="#">稀矿</a></li>
        <li><a href="#">石油</a></li>
        <li><a href="#">钢铁</a></li>
        <li><a href="#">粮食</a></li> 
      </ul>
    </div>
    @endif
</div>
@endif