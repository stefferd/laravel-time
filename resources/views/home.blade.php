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

                    @foreach($registrations as $registration)
                        <div>
                            {{$registration->workday}} - {{$registration->amount}} / <strong>{{$registration->customer->name}} - {{$registration->project->name}}</strong><br />{{$registration->description}}<br />
                            <form action="{{ action('RegistrationController@destroy', ['id' => $registration->id]) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button>Verwijderen</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Uren registreren</div>
                <div class="panel-body">
                    <form method="POST" action="/registrations">
                        <input type="hidden" value="{{csrf_token()}}" name="_token" />
                        <div class="form-group col-md-6">
                            <label for="customer_id">Klant</label>
                            <select id="customer_id" class="form-control" onchange="filterProjects(this)" name="customer_id">
                                <option value="">Selecteer een Klant</option>
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="project_id">Project</label>
                            <select id="project_id" class="form-control" name="project_id">
                                <option value="">Selecteer een project</option>
                                @foreach ($projects as $project)
                                    <option class="belongs-to belongs-to-{{$project->customer->id}}" value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="workday">Gemaakt op</label>
                            <input type="date" id="workday" class="form-control" name="workday" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amount">Aantal uren</label>
                            <input type="text" id="amount" class="form-control" name="amount" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Omschrijving</label>
                            <input type="text" id="description" class="form-control" name="description" />
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
