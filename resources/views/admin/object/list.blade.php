@extends('admin.layouts.app')
@section('content')

<div class="show-pagename"><h2>{{$page}}</h2></div>
<div>
    <a class="btn btn-primary" href="{{ asset('/sysadmin/object/list') }}?type=0">军事建筑</a>
    <a class="btn btn-primary" href="{{ asset('/sysadmin/object/list') }}?type=1">资源建筑</a>
    <a class="btn btn-primary" href="{{ asset('/sysadmin/object/list') }}?type=4">科技研究</a>
    <a class="btn btn-primary" href="{{ asset('/sysadmin/object/list') }}?type=3">其他</a>
</div>
<table class="table table-hover">
    <thead>
        <th>
            <td>名称</td>
            <td>标识</td>
            <td>描述</td>
            <td>类型</td>
            <td>最高等级</td>
            <td>数量限制</td>
            <td>阵营</td>
            <td>更新时间</td>
            <td>操作</td>
        </th>
    </thead>
    <tbody>
        @foreach($object as $item)
        <tr>
            <td>{{$item['id']}}</td>
            <td>{{$item['name']}}</td>
            <td>{{$item['name_type']}}</td>
            <td>{{$item['description']}}</td>
            <td>{{$item['type']}}</td>
            
            <td>{{$item['max_level']}}</td>
            <td>{{$item['max_number']==0?"不限制":$item['max_number']}}</td>
            <td>{{$item['camp']}}</td>
            <td>{{$item['updated_at']}}</td>
            <td><a href="{{ asset('/sysadmin/object/edit/'.$item['id']) }}">编辑</a></td>
        </tr>
        @endforeach
    </tbody>

</table>
  {{ $object->appends(['type' =>isset($_GET['type'])?$_GET['type']:'all'])->links() }}
@endsection