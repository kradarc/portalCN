@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editando noticia "{{ $news->title }}"</div>
                <ul class="nav nav-pills nav-gallery">
                    <li class="{{ empty($tab['name']) || $tab['name'] == 'info' ? 'active' : '' }}"><a data-toggle="pill" href="#info">Información de noticia</a></li>
                    <li class="{{ empty($tab['name']) || $tab['name'] == 'gallery' ? 'active' : '' }}"><a data-toggle="pill" href="#gallery">Galeria de imagenes</a></li>
                </ul>
                
                <div class="tab-content">
                    <div id="info" class="tab-pane fade {{ empty($tab['name']) || $tab['name'] == 'info' ? 'in active' : '' }}">
                            <div class="panel-body">
                                <?php if ($news->cover_page): ?>
                                        <img src="{{url('/uploads/news')}}/{{ $news->cover_page }}" style="width:100%; max-height:150px ">
                                <?php endif ?>
                                 <br>  <br>   
                                <form class="form-horizontal" method="POST" action="{{ route('posts.update', ['id' => $news->id] ) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <div class="form-group{{ $errors->has('cover_page') ? ' has-error' : '' }}">
                                        <label for="cover_page" class="col-md-4 control-label">Portada</label>

                                        <div class="col-md-6">
                                            <input type="file" name="cover_page" accept=".png, .jpg, .jpeg">


                                            @if ($errors->has('cover_page'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('cover_page') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>  
                                    <div class="col-md-12">
                                        <label for="cover_page" class="col-md-4 control-label">Visible</label>
                                        <label class="switch">
                                          <input type="checkbox" name="status" id="status" value="1" 
                                          @if ($news->status == 1) checked="checked" @endif>
                                          <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="title" class="col-md-4 control-label"> Título </label>

                                        <div class="col-md-6">
                                            <input id="title" type="text" class="form-control" name="title" value="{{ $news->title }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('subtitle') ? ' has-error' : '' }}">
                                        <label for="subtitle" class="col-md-4 control-label"> Subtítulo </label>

                                        <div class="col-md-6">
                                            <input id="subtitle" type="text" class="form-control" name="subtitle" value="{{ $news->subtitle  }}" required autofocus>

                                            @if ($errors->has('subtitle'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('subtitle') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                        <label for="url" class="col-md-4 control-label"> Url </label>

                                        <div class="col-md-6">
                                            <input id="url" type="text" class="form-control" name="url" value="{{ $news->url  }}" onkeyup="validate();" placeholder="no debe contener ningun caracter raro" required autofocus>

                                            @if ($errors->has('url'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('url') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="blog_category_id" class="col-md-4 control-label">Categoría</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="category_id">
                                                @foreach($categories as $category)
                                                    @if ($news->category_id  == $category->id)
                                                        <option value="{{$category->id}}" selected>{{$category->name}}</option>

                                                        @else
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endif
                                                        
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="blog_category_id" class="col-md-4 control-label">Tags</label>
                                        <div class="col-md-6">
                                            <select class="form-control js-multiple" name="tags[]" multiple="multiple" required>
                                                @foreach($tags as $tag)
                                                    @if (array_search($tag['id'], array_column($tagsInPost, 'id')) !== false ){
                                                       <option value="{{$tag->id}}" selected>{{$tag->name}}</option>
                                                       @else
                                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-md-12 col-offset-md-1">
                                        <textarea name="content" id="content" value="" rows="10" cols="80">
                                            {{ $news->content  }}
                                        </textarea> 
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Actualizar
                                            </button>
                                            <a href="{{ URL::to('posts') }}" class="btn btn-danger">Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>



                    </div>
                    <div id="gallery" class="tab-pane fade {{ empty($tab['name']) || $tab['name'] == 'gallery' ? 'in active' : '' }}">
                            <div class="panel-body">
                                <h2 class="title-gral">Sube imagenes para la noticia</h2>
                                <form class="form-horizontal" method="POST" action="{{ route('galleries.store' ) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="post_id" value="{{$news->id}}">
                                    <input type="hidden" name="from" value="news">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">Imagen(es)</label>

                                        <div class="col-md-6">
                                            <input name="filesToUpload[]" id="filesToUpload" type="file" multiple="" accept=".png, .jpg, .jpeg" required/>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">Nombre de la imagen</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Crear
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <hr>
                                <br>
                                <div class="list-file-galleries">
                                    <h2>Imagenes de la noticia</h2>
                                    <ul class="galleries">


                                        @if (!$gallery)
                                            <li class="col-md-4 box-content-action-gallery">
                                                <p>no hay imagenes</p>
                                            </li>
                                            @else
                                            @foreach($gallery as $file)
                                                <li class="col-md-4 box-content-action-gallery">
                                                    <img src="{{url('/uploads/gallery')}}/{{ $file->url }}" style="width:100%; max-height:150px ">
                                                    <form method="POST" action="{{ route('galleries.destroy', ['id' => $file->id] ) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <input type="hidden" name="from" value="news">
                                                        <button type="submit" class="btn btn-danger delete-user" value="Delete user" onclick="return confirm('Estas seguro?')" data-toggle="tooltip" title="Eliminar"> <span class="glyphicon glyphicon-trash"></span>  </button>
                                                    </form>
                                                </li>
                                            @endforeach    
                                        @endif
                                        
                                    </ul>

                                </div>
                            </div>
                    </div>
                    
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
    $('#content').ckeditor();
    function validate() {
      var element = document.getElementById('url');
      element.value = element.value.replace(/[^a-zA-Z0-9@]+/, '');
    };
</script>
@stop
@endsection
