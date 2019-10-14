@extends('layouts.app')

@section('title', $village->siteTree->title)

@section('content')
    <div class="container pt-6 pb-8">
        <h1 class="display-4 text-center">Detail obce</h1>
        <div class="card flex-lg-row shadow border-top mt-6">
            <div class="card-body col-lg order-lg-1 d-flex flex-column align-items-center justify-content-center text-center p-sm-5 p-md-7 p-lg-8">
                <h2 class="card-title h1 mb-0 order-1 text-info">{{ $village->siteTree->title }}</h2>
                @if ($filename = $village->file->filename)
                    <img src="{{ asset($filename) }}" alt="{{ $village->name }}" class="mb-4">
                @endif
            </div>
            <div class="card-body col-lg bg-light d-flex align-items-center p-sm-5 p-md-7 p-lg-8">
                <div class="table-responsive">
                    <table class="c-safe-table table table-borderless table-sm mb-0">
                        @if ($village->mayor_name)
                            <tr>
                                <th>Meno starostu:</th>
                                <td>{{ $village->mayor_name }}</td>
                            </tr>
                        @endif
                        @if ($village->municipal_office_address)
                            <tr>
                                <th>Adresa obecného úradu:</th>
                                <td>{{ $village->municipal_office_address }}</td>
                            </tr>
                        @endif
                        @if ($village->phone)
                            <tr>
                                <th>Telefón:</th>
                                <td>{{ $village->phone }}</td>
                            </tr>
                        @endif
                        @if ($village->fax)
                            <tr>
                                <th>Fax:</th>
                                <td>{{ $village->fax }}</td>
                            </tr>
                        @endif
                        @if ($village->email)
                            <tr>
                                <th>Email:</th>
                                <td>{{ $village->email }}</td>
                            </tr>
                        @endif
                        @if ($village->web)
                            <tr>
                                <th>Web:</th>
                                <td>{{ $village->web }}</td>
                            </tr>
                        @endif
                        @if ($village->geographical_coordinates)
                            <tr>
                                <th>Zemepisné súradnice:</th>
                                <td>{{ $village->geographical_coordinates }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
