@extends('layouts.header')
    @section('headercontent')

    <div class="page-header">
        <h1 style="text-align: center;">
            二战风云<small>阿登战役</small>
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12 ">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                     
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-group input-group-lg loginInput">
                                    <span class="input-group-addon">邮箱</span> <input id="email" type="email" class="form-control" placeholder="请输入注册账号" name="email" value="{{ old('email') }}" required>
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
                                    <span class="input-group-addon">密码</span> <input id="password" type="password" class="form-control"  placeholder="请输入密码"  name="password" required>
                            </div>
                            <div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-lg loginInput">
                                    <span class="input-group-addon">验证</span>  <input id="password-confirm" type="password" class="form-control"  placeholder="再次输入密码"   name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-3  col-xs-offset-2">
                                <span class="btn btn-info btn-lg leftBtn"><a href="{{ asset('login') }}" style="color:#fff">返回</a></span>                      
                            </div>
                            <div class="col-xs-3 col-xs-offset-1">                       
                                <button type="submit" class="btn btn-lg btn-primary">
                                    注册
                                </button>
                            </div>
                        </div>
                    </form>
           
        </div>
    </div>


@endsection