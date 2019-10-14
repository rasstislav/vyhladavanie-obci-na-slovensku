@extends('layouts.app')

@section('title', 'Domov')

@section('content')
    <div class="c-main-search jumbotron jumbotron-fluid flex-grow-1 d-flex align-items-center mb-0">
        <div class="container">
            <h1 class="display-3 text-center">Vyhľadať v databáze obcí</h1>
            <div class="c-main-search__search-field mx-auto mt-5">
                <app-village-select></app-village-select>
            </div>
        </div>
    </div>
@endsection
