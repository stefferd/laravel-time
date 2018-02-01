@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <tr>
                            <th>Datum</th>
                            <th>Project</th>
                            <th>Uren</th>
                            <th>Omschrijving</th>
                        </tr>
                    @foreach($registrations as $registration)
                        <tr>
                            <td>{{$registration->workday}}</td>
                            <td>{{$registration->customer->name}} - {{$registration->project->name}}</td>
                            <td>{{$registration->amount}}</td>
                            <td>{{$registration->description}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <a href="{{ action('RegistrationController@edit', ['id' => $registration->id]) }}">Bewerken</a>&nbsp;&nbsp;&nbsp;
                                <form action="{{ action('RegistrationController@destroy', ['id' => $registration->id]) }}" method="POST">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button>Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Uren registreren</div>
                <div class="panel-body">
                    @if (isset($editRegistration))
                        <form method="POST" action="/registrations/{{$editRegistration->id}}">
                            {{ method_field('PUT') }}
                    @else
                        <form method="POST" action="/registrations">
                    @endif
                        <input type="hidden" value="{{csrf_token()}}" name="_token" />
                        <div class="form-group col-md-6">
                            <label for="customer_id">Klant</label>
                            <select id="customer_id" class="form-control" onchange="filterProjects(this)" name="customer_id">
                                <option value="">Selecteer een Klant</option>
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}"{{(isset($editRegistration) && $editRegistration->customer_id == $customer->id) ? ' selected' : '' }}>{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="project_id">Project</label>
                            <select id="project_id" class="form-control" name="project_id">
                                <option value="">Selecteer een project</option>
                                @foreach ($projects as $project)
                                    <option class="belongs-to belongs-to-{{$project->customer->id}}" value="{{$project->id}}"{{(isset($editRegistration) && $editRegistration->project_id == $project->id) ? ' selected' : '' }}>{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="workday">Gemaakt op</label>
                            <input type="date" id="workday" class="form-control" name="workday" value="{{(isset($editRegistration)) ? $editRegistration->workday : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amount">Aantal uren</label>
                            <input type="text" id="amount" class="form-control" name="amount" value="{{(isset($editRegistration)) ? $editRegistration->amount : '' }}" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Omschrijving</label>
                            <input type="text" id="description" class="form-control" name="description" value="{{(isset($editRegistration)) ? $editRegistration->description : '' }}" />
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Toevoegen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Project toevoegen</div>
                <div class="panel-body">
                    <form method="POST" action="/projects">
                        <input type="hidden" value="{{csrf_token()}}" name="_token" />
                        <div class="form-group col-md-6">
                            <label for="name">Naam</label>
                            <input type="text" id="name" class="form-control" name="name" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="customer_id">Klant</label>
                            <select id="customer_id" class="form-control" name="customer_id">
                                <option value="">Selecteer een Klant</option>
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Toevoegen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Klant toevoegen</div>
                <div class="panel-body">
                    <form method="POST" action="/customers">
                        <input type="hidden" value="{{csrf_token()}}" name="_token" />
                        <div class="form-group col-md-6">
                            <label for="name">Naam</label>
                            <input type="text" id="name" class="form-control" name="name" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact">Contactpersoon</label>
                            <input type="text" id="contact" class="form-control" name="contact" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email contactpersoon</label>
                            <input type="email" id="email" class="form-control" name="email" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Telefoon contactpersoon</label>
                            <input type="text" id="phone" class="form-control" name="phone" />
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Toevoegen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
