@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Data Point</h3>
        </div>
        <div class="card body">
            <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Description</th>
                    <th>Coordinates</th>
                    <th>Image</th>
                    <th>Created at</th>
                </tr>
            </thead>

            <tbody>
                @php $no = 1 @endphp
                @foreach ($points as $p )

                <tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->description }}</td>
                        <td>{{ $p-> geom }}</td>
                        <td><img src="{{asset('storage/images/'.$p->image) }}" alt="" width="200"></td>
                    <td>{{ $p->created_at}} </td>
                </tr>

                @endforeach
            </tbody>
        </div>
    </div>
</div>



@endsection
