@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Nueva Categoría de taller</div>

                <div class="panel-body">
                    <?php if ($category->image): ?>
                            <img src="{{url('/uploads/workshopCategories')}}/{{ $category->image }}" style="width:100%; max-height:150px ">
                    <?php endif ?>
                     <br>  <br>   
                    <form class="form-horizontal" method="POST" action="{{ route('workshopCategories.update', ['id' => $category->id] ) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-md-4 control-label">Portada</label>

                            <div class="col-md-6">
                                <input type="file" name="image" accept=".png, .jpg, .jpeg">


                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                   
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nombre</label>

                                <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $category->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                @if ($errors->has('url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">Estado</label>
                            <div class="col-md-6">
                                <select class="form-control" name="status">
                                   @foreach($statuses as $status)
                                        @if ($category->status  == $status['id'])
                                            <option value="{{$status['id']}}" selected>{{ $status['name'] }}</option>

                                            @else
                                            <option value="{{$status['id']}}">{{$status['name']}}</option>
                                        @endif
                                            
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar
                                </button>
                                <a href="{{ URL::to('workshopCategories') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
