@extends("layouts.app")

@section('subheader_title')
    Accounts
@endsection

@section('subheader_subtitle')
    #permission_update
@endsection

@section("content")
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Update permissions to "{{ $user->fname }}"
            </h3>
        </div>
        <form class="form" action="{{ \Illuminate\Support\Facades\URL::signedRoute('accounts-create-roles-update', [$user]) }}" id="frmUpdatePrivilege" method="POST">
            @csrf
            <div class="card-body">
                @foreach($configs as $config)
                    <div class="form-group row align-items-center">
                        <label class="col-lg-3 col-form-label  text-right">{{ ucfirst($config["name"]) }}:</label>
                        <div class="col-lg-6">
                            <div class="checkbox-inline">
                                @foreach($config["access"] as $access)
                                    <label class="checkbox">
                                        <input type="checkbox" name="{{ $config["name"] }}[]" value="{{ $access }}" checked/>
                                        <span></span>
                                        {{ ucfirst($access) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Update</button>
            </div>
        </form>
    </div>
@endsection
