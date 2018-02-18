@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
    	
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-lg-8 col-lg-offset-2 col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="material-icons">perm_identity</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">API Keys-
                        <small class="category">Keep this information in a secure place</small>
                    </h4> 
					<passport-personal-access-tokens></passport-personal-access-tokens>
				</div>	
			</div>	
		</div>	
	</div>	
</div>
@endsection