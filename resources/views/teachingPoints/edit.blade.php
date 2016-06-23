@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            TeachingPoints
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($teachingPoints, ['route' => ['teachingPoints.update', $teachingPoints->id], 'method' => 'patch']) !!}

                        @include('teachingPoints.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection