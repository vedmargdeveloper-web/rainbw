@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
<div class="main-container">	
				<?php
					 	$user_permissions = [];
					 	//	dd($user);
				        if( $user && $user->permissions ) {
				            $json = json_decode( $user->permissions);
				            if( $json ) {
				                foreach ($json as $key => $value) {
				                    
				                    $user_permissions[] = $value->route . ',' . $value->label;
				                }
				                // var_dump($user_permissions);
				            }
				        }
				       // dd($user_permissions);
			      ?>
				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								
						<div class="card-header">
                            <h5>Permissions</h5>
                        </div>

                        <?php
                            $permissions = [
                            					'item' =>
                            					[
                            						'item.index' => 'View Item',
		                                        	'item.create' => 'Create Item',
		                                        	'item.delete' => 'Create delete'
		                                        ],
		                                        'customers' =>
                            					[
                            						'customers.index' => 'View customers',
		                                        	'customers.create' => 'Create customer',
		                                        	'customers.delete' => 'Create delete'
		                                        ],
		                                        'users' =>
                            					[
                            						'users.index' => 'View User',
		                                        	'users.create' => 'Create User',
		                                        	'users.delete' => 'Create delete'
		                                        ],

	                            			];
                        ?>
									
								@error('permissions')
                                    <span class="text-warning">{{ $message }}</span>
                                @enderror
                                @error('uid')
                                    <span class="text-warning">{{ $message }}</span>
                                @enderror
                                <form action="{{ route('user.permissions.store') }}" method="post" >
                                	<input type="hidden" name="uid" value="{{ $id }}">
                                <div class="row">
                                	
                                		@csrf
	                                	<?php
	                                		$count = 0;
	                                	?>
	                                    @foreach( $permissions as $key => $permission )
	                                    	<div class="col-md-3">
	                                    		<h2>{{ $key }}</h2>
	                                    		<ul>
		                                    		@foreach($permission as $skey => $perm)
		                                    			<li>
		                                    			<?php $v = $skey . ',' . $perm. ',' .$key; ?>
		                                    			<?php $vs = $skey . ',' . $perm ?>
		                                    			 <input {{ in_array($vs, $user_permissions) ? 'checked' : '' }} id="{{ Str::slug($perm, '-').'-'.$key }}" name="permissions[]" value="{{ $v }}" type="checkbox">
	                                                    <label for="{{ Str::slug($perm, '-').'-'.$key }} ">
	                                                        {{ $perm }}
	                                                    </label>
	                                                	</li>
		                                    		@endforeach
	                                    		</ul>
	                                    	</div>
	                                        <?php //$v = $key . ',' . $permission; $count++ ?>
	                                    @endforeach
                                </div>
                                 <button class="btn btn-primary td-submit">SAVE</button>
                                	</form>
							</div>
						</div>
					</div>
			</div>

		
		
		
@endsection