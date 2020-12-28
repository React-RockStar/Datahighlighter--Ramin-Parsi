@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome to the Dashboard
                </div>
            </div>
        </div>
    </div>
    <div>
    <div class="list_license_box">

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User Name</th>
                    <!-- <th>Invoice Title</th> -->
                    <th>License Key</th>
                    <th>Trello Boards</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach( $subscriptions as $subscription )

                <tr class="list_invoice_index">
                    <input type="hidden" value='{{ $subscription->id }}'>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ Auth::user()->name }} </td>
                    <td> {{ $subscription->license_key }} </td>
                    <td class="editable_boards w-50" > {{ $subscription->trello_board }} </td>
                    <td>
                        <button class="btn-sm btn btn-success btn_edit" >Edit</button>
                        <button class="btn-sm btn btn-success btn_save d-none" >Save</button>
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>

        </div>

    </div>
</div>
@endsection
