@extends('layouts.header')


 @section('headercontent')

<div class="loginDiv">
    <form action="{{ asset('/beginSetting') }}" method="post" accept-charset="utf-8">
         {{ csrf_field() }}
    <div class="page-header">
        <h1 style="text-align: center;">
            <small>初始设置</small>
        </h1>
        </div>
        <div class="input-group input-group-lg loginInput">
            <span class="input-group-addon">统帅名称</span>
            <input type="text" class="form-control" name="user_name" placeholder="至少三个字符" value="" required="required">
        </div>
        <div class="input-group input-group-lg loginInput">
            <span class="input-group-addon">统帅番号</span> 
            <input type="text" class="form-control" name="user_flag" placeholder="仅限一个中文" value="" required="required">
        </div>
        <div class="input-group input-group-lg loginInput">
            <span class="input-group-addon">所在大陆</span> 
                <select class="form-control" name="dalu">
                      <option value="0">亚洲</option>
                      <option value="1">非洲</option>
                      <option value="2">欧洲</option>
                      <option value="3">北美洲</option>            
                      <option value="4">南美洲</option>
                      <option value="5">大洋洲</option>
                </select>
        </div>  
        <div class="input-group input-group-lg loginInput">
            <span class="input-group-addon">城市名称</span> 
            <input type="text" class="form-control" name="cityName" placeholder="10个字符以内" value="" required="required">
        </div>
        <div class="input-group input-group-lg loginInput">
            <span class="input-group-addon">所属阵营</span> 
            <div class="radios" >
               <label>
                <input type="radio" name="camp" id="optionsRadios1" value="1" checked="">
                     法西斯
              </label>
              <label>
                <input type="radio" name="camp" id="optionsRadios1" value="0" checked="">
                    盟军
              </label>           
            </div>
        </div>
        <div class="loginButton">
        <button class="btn btn-lg btn-info" style="width:100%" name="submit" value="register">进入游戏</button>
        </div>
        </form>
            </div>
 @endsection