@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))

@section('form')
    <div class="mt-8">
        <form id="secret-key-form" method="POST" onsubmit="updateFormAction()">
            <label for="secret-key" class="block text-gray-700 text-sm font-bold mb-2">Clé Secrète :</label>
            <input type="text" id="secret-key" name="secret_key" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Entrez votre clé secrète">
            <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Soumettre
            </button>
        </form>
    </div>
@endsection
