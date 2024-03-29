@extends('layouts.app')

@section('content')

<div class="pt-8 pb-4 px-8">
  <a href="customer/create" class="p-3 border-none italic text-white bg-black text-lg">
    Add a new customer &rarr;
  </a>
</div>

<div class="py-3">
  <table class="table-auto text-center">
    <tr class="text-white">
      <th class="w-screen text-3xl">Id</th>
      <th class="w-screen text-3xl">First Name</th>
      <th class="w-screen text-3xl">Last Name</th>
      <th class="w-screen text-3xl">Phone Number</th>
      <th class="w-screen text-3xl">Customer Pic</th>
      <th class="w-screen text-3xl">Animal</th>
      <th class="w-screen text-3xl">Update</th>
      <th class="w-screen text-3xl">Delete</th>
      <th class="w-screen text-3xl">Restore</th>
      <th class="w-screen text-3xl">Destroy</th>
    </tr>

    @forelse ($customers as $customer)

    <tr>
      @if($customer->deleted_at)
      <td class="text-center text-3xl">
        <a href="#">{{$customer->id}}</a>
      </td>
      @else
      <td class="text-center text-3xl">
        <a href="{{route('customer.show',$customer->id)}}">{{$customer->id}}</a>
      </td>
      @endif
      </td>
      <td class="text-center text-3xl">
        {{ $customer->first_name }}
      </td>
      <td class="text-center text-3xl">
        {{ $customer->last_name }}
      </td>
      <td class="text-center text-3xl">
        {{ $customer->phone_number }}
      </td>
      <td class="pl-12">
        <img src="{{ asset('uploads/customers/'.$customer->images)}}" alt="I am A Pic" width="75" height="75">
      </td>
      <td class=" text-center text-3xl">
        {{ $customer->animal_name }}
      </td>

      @if($customer->deleted_at)
      <td class=" text-center">
        <a href="#">
          <p class="text-center text-2xl bg-green-600 p-2">
            Update &rarr;
          </p>
        </a>
      </td>
      @else
      <td>
        <a href="customer/{{ $customer->id }}/edit" class="text-center text-2xl bg-green-600 p-2">
          Update &rarr;
        </a>
      </td>
      @endif

      <td class=" text-center">
        {!! Form::open(array('route' => array('customer.destroy', $customer->id),'method'=>'DELETE')) !!}
        <button type="submit" class="text-center text-2xl bg-red-600 p-2 my-2">
          Delete &rarr;
        </button>
        {!! Form::close() !!}
      </td>

      @if($customer->deleted_at)
      <td>
        <a href="{{ route('customer.restore', $customer->id) }}">
          <p class="text-center text-red-700 text-2xl bg-purple-500 p-2 my-2">
            Restore &rarr;
          </p>
        </a>
      </td>
      @else
      <td>
        <a href="#">
          <p class="text-center text-2xl bg-purple-500 p-2 my-2">
            Restore &rarr;
          </p>
        </a>
      </td>
      @endif

      <td>
        <a href="{{ route('customer.forceDelete', $customer->id) }}">
          <p class="text-center text-2xl bg-warning p-2 ml-3 mr-4 my-2"
            onclick="return confirm('Do you want to delete this data permanently?')">
            Destroy &rarr;
          </p>
        </a>
      </td>
    </tr>
    @empty
    <p>No Customer Data in the Database</p>
    @endforelse
  </table>

  <div class="pt-6 px-4">{{ $customers->links( )}}</div>

  <span class="flex justify-center pt-6">
    <form action="{{ url('result') }}" type="GET">
      <input type="result" name="result" id="result" class="text-center pb-1 px-2 w-full">
      <div class="grid w-full">
        <button class="bg-green-800 text-white font-bold p-2 mt-3">Search</button>
      </div>
  </span>
</div>
</div>
@endsection