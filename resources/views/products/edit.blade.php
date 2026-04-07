@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Editar producto
                    </div>
                    <div class="card-body">
                        <form action={{ route('products.update', $product->id) }} method="POST">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <label for="">Descripcion</label>
                                <input type="text" class="form-control" name="description" value="{{ $product->description }}">
                            </div>
                            <div class="form-group">
                                <label for="">Precio</label>
                                <input type="number" class="form-control" name="price" step="0.01" value="{{ $product->price }}">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Actualizar</button>           
                            <a href="/products" class="btn btn-danger">Cancelar</a>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>  
@endsection   