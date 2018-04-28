@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        Create Product
      </div>
      <div class="panel-body">
        <div class="form-group col-xs-12 col-md-12">
          {!! Form::open(['action' => ['ProductController@api__store'], 'method' => 'POST', 'id' => 'product-form']) !!}
            <div class="col-xs-12">
              {!! Form::label('name', 'Product Name', ['class' => 'control-label']) !!}
              {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('stock', 'Quantity In Stock', ['class' => 'control-label']) !!}
              {!! Form::number('stock', 0, ['class' => 'form-control', 'step' => '1']) !!}
            </div>
            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('price', 'Price Per Item', ['class' => 'control-label']) !!}
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                {!! Form::number('price', 0.00, ['class' => 'form-control', 'step' => '0.01']) !!}
              </div>
            </div>
            <div class="form-group col-xs-12 col-md-6 col-md-offset-3">
              <button type="submit" class="btn m-light-green btn-block">
                Submit
              </button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    
    {{-- Panel with old items --}}
    <div class="panel panel-default">
      <div class="panel-heading">
        Items Previously Submitted
      </div>
      <div class="panel-body">
        <div class="col-xs-12" id="product-holder">
            <div class="col-xs-3">
              <b>Product</b>
            </div>
            <div class="col-xs-2">
              <b>Stock</b>
            </div>
            <div class="col-xs-2">
              <b>Price Per Item</b> 
            </div>
            <div class="col-xs-3">
              <b>Submit Date </b>
            </div>
            <div class="col-xs-2">
              <b>Total </b>
            </div>
        @if(isset($previouslySubmittedProducts) && count($previouslySubmittedProducts) > 0)
          @foreach($previouslySubmittedProducts as $psp)
            <div id="product-{{$psp->id}}">
                <div class="col-xs-3 editable" data-id="{{$psp->id}}" data-parent="#product-{{$psp->id}}">
                  {{ $psp->name }}
                </div>
                <div class="col-xs-2 editable" data-id="{{$psp->id}}" data-parent="#product-{{$psp->id}}">
                  {{ $psp->stock }}
                </div>
                <div class="col-xs-2 editable" data-id="{{$psp->id}}" data-parent="#product-{{$psp->id}}">
                  ${{ $psp->stock }}
                </div>
                <div class="col-xs-3 editable" data-id="{{$psp->id}}" data-parent="#product-{{$psp->id}}">
                  {{ $psp->created_at }}
                </div>
                <div class="col-xs-2">
                  $<span class="total editable" data-id="{{$psp->id}}" data-parent="#product-{{$psp->id}}">{{ $psp->stock * $psp->price}}</span>
                </div>
            </div>
          @endforeach
        @endif
        <div id="template" class="hidden">
            <div class="col-xs-3">
              <span class="name editable"></span>
            </div>
            <div class="col-xs-2">
              <span class="stock editable"></span>
            </div>
            <div class="col-xs-2">
              <span class="price editable"></span>
            </div>
            <div class="col-xs-3">
                <span class="timestamp editable"></span>
            </div>
            <div class="col-xs-2">
                $<span class="total editable"></span>
            </div>
        </div>
      </div>
      <div class="col-xs-12">
        <div class="col-xs-2 pull-right">
          <b>Total Value</b>
        </div>
      </div>
      <div class="col-xs-12">
        <div class="col-xs-2 pull-right">
          @php
            $currentTotal = 0;
            if(isset($previouslySubmittedProducts) && count($previouslySubmittedProducts) > 0) {
              foreach($previouslySubmittedProducts as $psp) {
                $currentTotal += floatval($psp->price * $psp->stock);
              }
            }
          @endphp
          $<span id="total-price">{{ $currentTotal }}</span>
        </div>
      </div>
      </div>
    </div>
  </div>
@endsection