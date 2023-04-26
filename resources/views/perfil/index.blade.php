@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{ auth()->user()->username }}
@endsection


@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form method="POST" class="mt-10 md:mt-0" action="{{ route('perfil.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label class="mb-2 block uppercase text-gray-500 font-bold" for="username">UserName</label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username"
                        placeholder="Tu nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"  
                        value="{{auth()->user()->username}}"
                        />
                        @error('username')
                            <p class="bg-red-500 text-white my-2 rounded-lg 
                            text-sm p-2 text-center">{{ $message }}</p>
                        @enderror
                </div>

                <div class="mb-5">
                    <label class="mb-2 block uppercase text-gray-500 font-bold" for="username">Actual Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="border p-3 w-full rounded-lg "
                        />
                </div>

                <div class="mb-5">
                    <label class="mb-2 block uppercase text-gray-500 font-bold" for="username">New Password</label>
                    <input 
                        type="password" 
                        name="new-password" 
                        id="new-password"
                        class="border p-3 w-full rounded-lg "
                        />
                </div>

                <div class="mb-5">
                    <label class="mb-2 block uppercase text-gray-500 font-bold" for="imagen">Imagen de Perfil</label>
                    <input 
                        type="file" 
                        name="imagen" 
                        id="imagen"
                        class="border p-3 w-full rounded-lg "
                        value=""
                        accept=".jpg, .jpeg, .png"
                        />
                    <input type="submit" value="Guardar Cambios" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
                    uppercase font-bold w-full p-3 text-white rounded-lg">
                </div>
            </form>

            @if (session('mensaje'))
                <div class="alert alert-success">
                    {{ session('mensaje') }}
                </div>
            @endif

        </div>
    </div>
@endsection