@extends('layouts.header')
    @section('headercontent')

    <div class="page-header">
        <h1 style="text-align: center;">
            二战风云<small>阿登战役</small>
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12 ">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="input-group input-group-lg loginInput">
                        <span class="input-group-addon">账号</span> <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="input-group input-group-lg loginInput">
                        <span class="input-group-addon">密码</span> <input id="password" type="password" class="form-control" name="password" required>
                    </div>
                    <div >
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group" style="text-align: right;">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        忘记密码?
                    </a>
                </div>
                <div class="form-group">
                    <div class="col-xs-3  col-xs-offset-2">
                        <button type="submit"  class="btn btn-lg btn-primary">
                            登录
                        </button>                       
                    </div>
                    <div class="col-xs-3 col-xs-offset-1">                       
                        <span class="btn btn-info btn-lg leftBtn"><a href="{{ asset('register') }}" style="color:#fff">注册</a></span>
                    </div>
                </div>
            </form>
           </div>
    </div>


@endsection