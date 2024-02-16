<div class="modal fade domals" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="width: 500px !important">
		<div class="modal-content">
			<div class="modal-header bg-primary" style="color: #fff">
				<h5 class="modal-title col-md-11" id="registerModalLabel"><i class="fa fa-user"></i> Sign Up - Step One</h5>
				<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true" class="pull-right">&times;</span>
				</button>
			</div>
			<div class="modal-body col-md-12" style="display: inline-block;">
				<form action="/auth/register" method="post" id="registerform">
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Are You An Artisan or A Client<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<select class="form-control pull-left" required name="roletype" id="roletype" style="border-radius: 4px 0 0 4px !important;" id="roletyperecover">
									<option value="ARTISAN">I Am An Artisan</option>
									<option value="CLIENT">I Am A Client</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Mobile Number<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-3" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<select class="form-control pull-left" name="prefix" required style="border-radius: 4px 0 0 4px !important; border-right: 0px !important;" id="prefix">
									@foreach($countries as $country)
									<option value="{{$country->call_prefix}}">+{{$country->call_prefix}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-9" style="padding-left:0px !important; padding-right:0px !important;">
								<input id="username"  class="form-control" autocomplete="off" type="tel" name="username" placeholder="example 967300000" class="form-control pull-right" style="border-radius: 0 4px 4px 0 !important; border-left: 0px !important;"placeholder="">
							</div>
						</div>
					</div>
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Password<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<input type="password" autocomplete="off" required name="password" class="form-control col-md-12" id="password" placeholder="Provide your secure password">
						</div>
					</div>
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Re-type Password<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<input type="password" autocomplete="off" required name="confirmpassword" class="form-control col-md-12" id="confirmpassword" placeholder="Repeat your secure password">
						</div>
					</div>
					<div class="col-md-12" style=" padding-top:0px !important; padding-bottom:0px !important;">
						<a onclick="handleRegister()" class="btn btn-success pull-left btn col-md-12" style="margin-bottom:5px !important;">Next</a>
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
				<div class="col col-md-6" style="text-align: center !important">Or Login To Start Working</div>
				
				<div class="col col-md-3" style="padding-right: 0px !important; padding-top: 10px !important;">
					<div class="col col-md-12" style="padding:0px !important; border-top: 1px solid #e5e5e5;">
					&nbsp;
					</div>
				</div>
			</div>
			<div class="modal-footer" style="clear: both !important; border-top: 0px solid #e5e5e5;">
				<div class="col-md-12" style="padding-top:0px !important; padding-bottom:0px !important;">
					<a  onclick="displayLogin()" class="btn btn col-md-12 btn-primary pull-left" style="margin-bottom:5px !important; cursor: pointer !important;">Login</a>
				</div>
			</div>
		</div>
	</div>
</div>
















