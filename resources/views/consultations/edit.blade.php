@extends('body')

@section('contents')
<div class="pb-20 my-2">
    <div class="text-center">
        <h1 class="text-5xl">
            Update Consultations
        </h1>
    </div>
    <div>
        <div class="flex justify-center pt-4">
            {{ Form::model($consultations,['route' => ['consultation.update',$consultations->id],'method'=>'PUT']) }}
            <div class="block">
                <div>
                    <label for="date" class="text-lg">Date</label>
                    {{ Form::date('date',null,array('class'=>'block shadow-5xl p-2 my-2
                    w-full','id'=>'date')) }}
                    @if($errors->has('date'))
                    <p class="text-center text-red-500">{{ $errors->first('date') }}</p>
                    @endif
                </div>

                <div>
                    <label for="price" class="text-lg">Price</label>
                    {{ Form::text('price',null,array('class'=>'block shadow-5xl p-2 my-2 w-full','id'=>'price')) }}
                    @if($errors->has('price'))
                    <p class="text-center text-red-500">{{ $errors->first('price') }}</p>
                    @endif
                </div>

                <div>
                    <label for="comment" class="text-lg">Comment</label>
                    {{ Form::text('comment',null,array('class'=>'block shadow-5xl p-2 my-2 w-full','id'=>'comment')) }}
                    @if($errors->has('comment'))
                    <p class="text-center text-red-500">{{ $errors->first('comment') }}</p>
                    @endif
                </div>

                <div>
                    <label for="personnel_id" class="text-lg">Vet</label>
                    {!! Form::select('personnel_id',$personnels, $consultations->personnel_id ,['class' => 'block
                    shadow-5xl
                    p-2
                    my-2
                    w-full']) !!}
                    @if($errors->has('personnel_id'))
                    <p class="text-center text-red-500">{{ $errors->first('personnel_id ') }}</p>
                    @endif
                </div>

                <div>
                    <label for="disease_injury_id" class="text-lg">Vet</label>
                    {!! Form::select('disease_injury_id',$disease_injury, $consultations->disease_injury_id ,['class' =>
                    'block
                    shadow-5xl
                    p-2
                    my-2
                    w-full']) !!}
                    @if($errors->has('disease_injury_id'))
                    <p class="text-center text-red-500">{{ $errors->first('disease_injury_id ') }}</p>
                    @endif
                </div>

                <div>
                    <label for="animal_id" class="text-lg">Animal</label>
                    {!! Form::select('animal_id',$animals, $consultations->animal_id ,['class' => 'block
                    shadow-5xl
                    p-2
                    my-2
                    w-full']) !!}
                    @if($errors->has('animal_id'))
                    <p class="text-center text-red-500">{{ $errors->first('animal_id ') }}</p>
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