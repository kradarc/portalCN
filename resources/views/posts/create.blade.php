@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Nueva Noticia</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('posts.store' ) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('cover_page') ? ' has-error' : '' }}">
                            <label for="cover_page" class="col-md-4 control-label">Portada</label>

                            <div class="col-md-6">
                                <input type="file" name="cover_page" accept=".png, .jpg, .jpeg" required>


                                @if ($errors->has('cover_page'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cover_page') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label"> Título </label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label"> Url </label>

                            <div class="col-md-6">
                                <input id="url" type="text" class="form-control" name="url" value="{{ old('url') }}" required autofocus>

                                @if ($errors->has('url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('subtitle') ? ' has-error' : '' }}">
                            <label for="subtitle" class="col-md-4 control-label"> Subtítulo </label>

                            <div class="col-md-6">
                                <input id="subtitle" type="text" class="form-control" name="subtitle" value="{{ old('subtitle') }}" required autofocus>

                                @if ($errors->has('subtitle'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subtitle') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="blog_category_id" class="col-md-4 control-label">Categoría</label>
                            <div class="col-md-6">
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">Tipo</label>
                            <div class="col-md-6">
                                <select class="form-control" name="type">
                                    @foreach($types as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="blog_category_id" class="col-md-4 control-label">Tags</label>
                            <div class="col-md-6">
                                <select class="form-control js-multiple" name="tags[]" multiple="multiple" required>
                                  
                                    @foreach($tags as $tag)
                                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-6">
                            @if ($errors->has('urlTag'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('urlTag') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <textarea name="content" id="content" rows="10" cols="80">
                                    Contenido
                                </textarea> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear
                                </button>
                             
                                <a href="{{ URL::to('posts') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('select2')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(".js-multiple").select2({
            placeholder: "Selecciona los tags",
            tags: true,
        })
    </script>
@stop
@section('ckeditor')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>
    CKEDITOR.replace( 'content', {
        filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
        filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
        filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
        filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}',
        toolbar :
        [
        ['ajaxsave'],
        ['Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', 'oembed' ],
        ['Cut','Copy','Paste','PasteText'],
        ['Undo','Redo','-','RemoveFormat'],
        ['TextColor','BGColor'],
        ['Maximize', 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'MediaEmbed' ]
        ],
       
    
    } );
</script>
@stop

@endsection

