@extends('layouts.app')

@section('sidebarforms')
    <div class="sidebar-body">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Uren registreren
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        @if (count($customers) == 0 || count($projects) == 0)
                            <p>Voordat je uren kan boeken, moeten er een klant toevoegd wordenen een project aangekoppeld worden.</p>
                            <p>Dit kan je hieronder doen door de klikken op "Klant toevoegen" & "Project toevoegen".</p>
                        @else
                            @if (isset($editRegistration))
                                <form method="POST" action="/registrations/{{$editRegistration->id}}">
                                    {{ method_field('PUT') }}
                            @else
                                <form method="POST" action="/registrations">
                            @endif
                                <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                <div class="form-group">
                                    <label for="customer_id">Klant</label>
                                    <select id="customer_id" class="form-control" onchange="filterProjects(this)" name="customer_id">
                                        <option value="">Selecteer een Klant</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{$customer->id}}"{{(isset($editRegistration) && $editRegistration->customer_id == $customer->id) ? ' selected' : '' }}>{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <select id="project_id" class="form-control" name="project_id">
                                        <option value="">Selecteer een project</option>
                                        @foreach ($projects as $project)
                                            <option class="belongs-to belongs-to-{{$project->customer->id}}" value="{{$project->id}}"{{(isset($editRegistration) && $editRegistration->project_id == $project->id) ? ' selected' : '' }}>{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="workday">Gemaakt op</label>
                                    <input type="date" id="workday" class="form-control" name="workday" value="{{(isset($editRegistration)) ? $editRegistration->workday : '' }}" />
                                </div>
                                <div class="form-group">
                                    <label for="amount">Aantal uren</label>
                                    <input type="text" id="amount" class="form-control" name="amount" value="{{(isset($editRegistration)) ? $editRegistration->amount : '' }}" />
                                </div>
                                <div class="form-group">
                                    <label for="description">Omschrijving</label>
                                    <input type="text" id="description" class="form-control" name="description" value="{{(isset($editRegistration)) ? $editRegistration->description : '' }}" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Toevoegen</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Project toevoegen
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <form method="POST" action="/projects">
                            <input type="hidden" value="{{csrf_token()}}" name="_token" />
                            <div class="form-group">
                                <label for="name">Naam</label>
                                <input type="text" id="name" class="form-control" name="name" />
                            </div>
                            <div class="form-group">
                                <label for="customer_id">Klant</label>
                                <select id="customer_id" class="form-control" name="customer_id">
                                    <option value="">Selecteer een Klant</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Toevoegen</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            Klant toevoegen
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <form method="POST" action="/customers">
                            <input type="hidden" value="{{csrf_token()}}" name="_token" />
                            <div class="form-group">
                                <label for="name">Naam</label>
                                <input type="text" id="name" class="form-control" name="name" />
                            </div>
                            <div class="form-group">
                                <label for="contact">Contactpersoon</label>
                                <input type="text" id="contact" class="form-control" name="contact" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email contactpersoon</label>
                                <input type="email" id="email" class="form-control" name="email" />
                            </div>
                            <div class="form-group">
                                <label for="phone">Telefoon contactpersoon</label>
                                <input type="text" id="phone" class="form-control" name="phone" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Toevoegen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (count($customers) == 0 || count($projects) == 0)
            <p>Voordat je uren kan boeken, moeten er een klant toevoegd wordenen een project aangekoppeld worden.</p>
            <p>Dit kan je hieronder doen door de klikken op "Klant toevoegen" & "Project toevoegen".</p>
        @endif
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Dashboard :: Uren van {{$currentMonth}} {{$subYear}}</h3>
                    <div style="float: right; margin-top: -30px;">
                        <a href="{{url('home', ['currentMonth' => ($subMonth - 1) == 0 ? 12 : ($subMonth - 1), 'currentYear' => ($subMonth - 1) == 0 ? $subYear - 1 : $subYear])}}"><span class="glyphicon glyphicon-chevron-left"></span></a>
                        <a href="{{url('home', ['currentMonth' => ($subMonth + 1) == 13 ? 1 : ($subMonth + 1), 'currentYear' => ($subMonth + 1) == 13 ? $subYear + 1 : $subYear])}}"><span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                </div>

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
                            <th><span class="glyphicon glyphicon-edit"></span></th>
                            <th><span class="glyphicon glyphicon-trash"></span></th>
                        </tr>
                    @forelse($registrations as $registration)
                            <tr>
                                <td>{{$registration->workday}}</td>
                                <td>{{$registration->customer->name}} - {{$registration->project->name}}</td>
                                <td>{{$registration->amount}}</td>
                                <td>{{$registration->description}}</td>
                                <td>
                                    <a href="{{ action('RegistrationController@edit', ['id' => $registration->id]) }}"><span class="glyphicon glyphicon-edit"></span></a>
                                </td>
                                <td>
                                    <form action="{{ action('RegistrationController@destroy', ['id' => $registration->id]) }}" method="POST">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button><span class="glyphicon glyphicon-trash"></span></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p>Nog geen uren geboekt voor deze maand, boek hieronder uw uren!</p>
                                </td>
                            </tr>
                        @endforelse
                    </table>
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <i class="glyphicon glyphicon-align-left"></i>
                        Toggle Sidebar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
