@extends('body')

@section('contents')
<div class="pb-20 my-2">
    <div class="text-center">
        <h1 class="text-5xl">
            Add type
        </h1>
    </div>
    <div>

        <div class="flex justify-center pt-3">
            <form action="/type" method="POST">
                @csrf
                <div class="block">
                    <div>
                        <label for="type" class="text-lg">Type</label>
                        <input type="text" class="block shadow-5xl p-2 my-2 w-full" id="type" name="type"
                            placeholder="Type" value="{{old('type')}}">
                        @if($errors->has('type'))
                        <p class="text-center text-red-500">{{ $errors->first('type') }}</p>
                        @endif
                    </div>



                    <div class="grid grid-cols-2 gap-2 w-full">
                        <button type="submit" class="bg-green-800 text-white font-bold p-2 mt-5">
                            Submit
                        </button>
                        <a href="{{url()->previous()}}" class="bg-gray-800 text-white font-bold p-2 mt-5 text-center"
                            role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        @endsection