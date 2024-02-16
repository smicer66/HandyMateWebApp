<div class="modal fade domals" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="width: 400px !important">
		<div class="modal-content">
			<div class="modal-header bg-primary" style="color: #fff">
				<h5 class="modal-title col-md-11" id="loginModalLabel"><i class="fa fa-lock"></i> Login</h5>
				<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true" class="pull-right">&times;</span>
				</button>
			</div>
			<div class="modal-body col-md-12" style="display: inline-block;">
				<form action="/auth/login" method="post">
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Mobile Number</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-3" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<select class="form-control pull-left" name="prefix" style="border-radius: 4px 0 0 4px !important; border-right: 0px !important;" id="prefixlogin">
									@foreach($countries as $country)
									<option value="{{$country->call_prefix}}">+{{$country->call_prefix}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-9" style="padding-left:0px !important; padding-right:0px !important;">
								<input class="form-control" autocomplete="off" type="tel" name="username" placeholder="example 967300000" class="form-control pull-right" style="border-radius: 0 4px 4px 0 !important; border-left: 0px !important;" id="usernamelogin" placeholder="">
							</div>
						</div>
					</div>
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Password</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<input type="password" autocomplete="off" name="password" class="form-control col-md-12" id="passwordlogin" placeholder="Provide your secure password">
						</div>
					</div>
					<div class="col-md-12" style=" padding-top:0px !important; padding-bottom:0px !important;">
							<input type="submit" class="btn btn-success pull-left btn col-md-5" style="margin-bottom:5px !important;" value="Login">
							<a onclick="displayRecoverPassword()"   class="col-md-5 pull-right fontsize13" style="cursor: pointer !important; margin-bottom:5px !important; padding-top: 5px !important; text-align: right">Forgot Password</a>
						
					</div>
					<hr>
				</form>
			</div>
			<div class="col col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
				<div class="col col-md-3" style="padding-left: 0px !important; padding-top: 10px !important;">
					<div class="col col-md-12" style="padding:0px !important; border-top: 1px solid #e5e5e5;">
					&nbsp;
					</div>
				</div>
				<div class="col col-md-6" style="text-align: center !important">Or Register & Start Working</div>
				
				<div class="col col-md-3" style="padding-right: 0px !important; padding-top: 10px !important;">
					<div class="col col-md-12" style="padding:0px !important; border-top: 1px solid #e5e5e5;">
					&nbsp;
					</div>
				</div>
			</div>
			<div class="modal-footer" style="clear: both !important; border-top: 0px solid #e5e5e5;">
				<div class="col-md-12" style="padding-top:0px !important; padding-bottom:0px !important;">
					<a onclick="displayRegisterAccount()"  class="btn btn col-md-12 btn-primary pull-left" style="margin-bottom:5px !important; cursor: pointer !important;">New Account</a>
				</div>
			</div>
		</div>
	</div>
</div>















