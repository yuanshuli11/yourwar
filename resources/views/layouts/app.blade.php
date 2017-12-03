

@extends('layouts.header')
@section('headercontent')
 
<div class="main-container homenav">
    <ul class="nav nav-pills">
        <li role="presentation"><a href="{{ asset('/chat') }}">聊天</a></li>
        <li role="presentation"><a href="{{ asset('/mail') }}">邮件</a></li>
        <li role="presentation"><a href="{{ asset('/report') }}">军报</a></li>
        <li role="presentation"><a href="{{ asset('/task') }}">任务</a></li>
        <li role="presentation"  class="active"><a href="{{ asset('/') }}">首页</a></li>
    </ul>
        @yield('content')
    <div class="content-foot">
            <a href="{{ asset('part/army') }}">军事区</a>
            <a href="{{ asset('part/resource')}}" >资源区</a>
            <a href="{{ asset('part/map') }}" >地图区</a>
            <a href="{{ asset('part/trade') }}" >交易所</a>
            <a href="javascript:reflsehPart()">刷新</a>
            <a href="{{ asset('part/tech') }}" >科研中心</a>
            <a href="{{ asset('part/school') }}" >军校</a>
            <a href="{{ asset('part/battle') }}" >出征</a>
    </div>
    <div class="footer-span">
        <span class="footer-spans">军团</span>
        
        <span class="footer-spans">宝物</span>
        <span class="footer-spans">商城</span>
        <span class="footer-spans">聊天</span>
        <span class="footer-spans">帮助</span>
        <span class="footer-spans">充值</span>
        <span class="footer-spans">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            退出
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        </span>
        <div class="world-chat">
            <span>世界聊天:</span><span style="margin-left:10px;color:#428BCA">设置</span>        
            <div class="chat-row">
                  <span class="homeleft">偷你一颗草：</span>
                  <span>
                        这是说话的内容
                  </span>
            </div>
            <div class="chat-row">
                  <span class="homeleft">偷你两颗草：</span>
                  <span>
                        这是说话的内容
                  </span>
            </div>
            <div class="chat-row">
                  <span class="homeleft">偷你三颗草：</span>
                  <span>
                        这是说话的内容
                  </span>
            </div>
        </div>
    </div>
</div>
  <script type="text/javascript">
      
      function reflsehPart(){
         location.reload();
      }

  </script>
@endsection
