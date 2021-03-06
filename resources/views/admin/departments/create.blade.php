@extends('admin.index')

@section('style_css')
    <link rel="stylesheet" href="{{ asset('design/admin/css/upload_style.css')}}">
@endsection

@section('content')
@if(session()->has('success'))
    <p class="alert alert-success ">{{session('success')}}</p>
@endif
    <form class="col-lg-6 col-lg-offset-2" method="post" action="{{route('departments.store')}}" enctype="multipart/form-data" >
        {{ csrf_field() }}

        <div class="form-group">
            <label>{{__('admin.dep_name_ar')}}</label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                </div>
                <input type="text"  class="form-control" name="dep_name_ar" value="{{old('dep_name_ar')}}" placeholder="">
                <input type=hidden name="parent" class="parent_id" value="{{old('parent')}}">
            </div>
            @if($errors->has('dep_name_ar'))
                <p class="alert alert-danger error"><i class="fa fa-warning "></i>  {{$errors->first('dep_name_ar')}}</p>
            @endif
        </div>

        <div class="form-group">
            <label>{{__('admin.dep_name_en')}}</label>
            <div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </div>
                <input type="text" required class="form-control " name="dep_name_en" value="{{old('dep_name_en')}}">
            </div>
            @if($errors->has('dep_name_en'))
                <p class="alert alert-danger error"><i class="fa fa-warning "></i> {{$errors->first('dep_name_en')}}</p>
           @endif
        </div>
        <div id="jstree"></div>


        <div class="form-group">
             <label>{{__('admin.description')}}</label>
             <textarea name="description" class="form-control">{{old('description')}}</textarea>
        </div>

        <div class="form-group"/>
        <label>{{__('admin.keyword')}}</label>
        <textarea name="keyword" class="form-control">{{old('keyword')}}</textarea>
        </div>

        <div class="form-group">
            <div class="file-upload btn btn-primary">
                <span> <label>{{__('admin.icon')}}</label></span>
                <input type="file" name="icon" id="FileAttachment" class="upload" />
            </div>
            @if(Storage::disk('public')->exists(@$item->icon))
                <a target="_blank"  href="{{asset('storage/'.$item->icon)}}">Icon</a>
            @endif
            @if($errors->has('icon'))
                <p class="alert alert-danger error"><i class="fa fa-warning "></i>  {{$errors->first('icon')}}</p>
            @endif
        </div>






            <button type="submit" class="btn btn-primary">{{__('admin.submit')}}</button>
        <a href="{{url(adminUrl('departments'))}}" class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> {{__('admin.back')}}</a>

    </form>

@endsection


@push('js')

    <script>

        $(document).ready(function () {

            $('#jstree').jstree({
                "core" : {
                    "themes" : {
                        "variant" : "large"
                    },
                    'data' :{!! load_department(old('parent')) !!}
                },
                "checkbox" : {
                    "keep_selected_style" : false
                },
                "plugins" : [ "wholerow", "radio" ]
            });


        });


        $('#jstree').on('changed.jstree',function (e,data) {
                 var i,j,arr=[];
                 for(i=0,j=data.selected.length;i<j;i++){
                    arr.push(data.instance.get_node(data.selected[i]).id)
                 }
                //  $('.parent_id').val(arr.join(', '));
                $('.parent_id').val(data.instance.get_node(data.selected).id);

        });


    </script>
@endpush