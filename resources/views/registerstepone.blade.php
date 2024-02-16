<div class="modal fade domals" id="registerStepOneModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="width: 500px !important">
		<div class="modal-content">
			<div class="modal-header bg-primary" style="color: #fff">
				<h5 class="modal-title col-md-11" id="registerStepOneModalLabel"><i class="fa fa-user"></i> Update Your Profile - Step One</h5>
				<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true" class="pull-right">&times;</span>
				</button>
			</div>
			<div class="modal-body col-md-12" style="display: inline-block;">
				<form action="/auth/register" method="post" id="registersteponeform" autocomplete="off">
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">First Name<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() ? \Auth::user()->first_name : ''}}" class="form-control" autocomplete="off" type="text" required name="firstname" placeholder="example John" class="form-control pull-right" style="" id="firstname">
							</div>
						</div>
					</div>
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1" class="pull-left">Other Name</label>
						<label for="exampleFormControlInput1" class="pull-right">Last Name<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-5 pull-left mr-1" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() ? \Auth::user()->other_name : ''}}" class="form-control" autocomplete="off" type="text" name="othername" placeholder="example Peter" class="form-control pull-right" style="" id="othername">
							</div>
							<div class="col-md-5 pull-right ml-1" style="padding-left:0px !important; padding-right:0px !important;">
								<input value="{{\Auth::user() ? \Auth::user()->last_name : ''}}" class="form-control" autocomplete="off" type="text" required name="lastname" placeholder="example Doe" class="form-control pull-right" style="" id="lastname">
							</div>
						</div>
					</div>
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Home Address<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() ? \Auth::user()->home_address : ''}}" class="form-control" autocomplete="off" required type="text" name="homeaddress" placeholder="example Plot 100 Crimson Avenue" class="form-control pull-right" style="" id="homeaddress">
							</div>
						</div>
					</div>
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1" class="pull-left">City<span style="color: red">*</span></label>
						<label for="exampleFormControlInput1" class="pull-right">I Reside In<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-5 pull-left" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() ? \Auth::user()->city : ''}}" class="form-control" autocomplete="off" required type="text" name="city" placeholder="example Northmeads" class="form-control pull-right" style="" id="city">
							</div>
							
							<div class="col-md-5 pull-right" style="padding-left:0px !important; padding-right:0px !important;">
								<select class="form-control pull-left" required name="country" style="border-radius: 4px 0 0 4px !important;" id="country_id">
									<option value>--Select One--</option>
									@foreach($countries as $country)
									<option value="{{$country->id}}|||{{$country->name}}" {{\Auth::user() && \Auth::user()->country_id==$country->id ? 'selected' : ''}}>{{$country->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Province & District You Live At<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-5 pull-left" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<select class="form-control pull-left" required name="province" style="border-radius: 4px 0 0 4px !important;" id="state_id">
									@if(\Auth::user() && \Auth::user()->district_id!=null)
										@if(\Auth::user()->district!=null)
										<option value="{{\Auth::user()->district->state_id}}">{{\Auth::user()->district->state->name}}</option>
										@endif
									@endif
								</select>
							</div>
							
							<div class="col-md-5 pull-right" style="padding-left:0px !important; padding-right:0px !important;">
								<select class="form-control pull-left" name="district" style="border-radius: 4px 0 0 4px !important;" id="lga_id" required >
									@if(\Auth::user() && \Auth::user()->district_id!=null)
										@if(\Auth::user()->district!=null)
										<option value="{{\Auth::user()->district_id}}">{{\Auth::user()->district->lga_name}}</option>
										@endif
									@endif
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label class="pull-left" for="exampleFormControlInput1">Gender<span style="color: red">*</span></label>
						<label class="pull-right" for="exampleFormControlInput1">National Id No<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-5 pull-left" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<select class="form-control pull-left" required name="gender" style="border-radius: 4px 0 0 4px !important;" id="gender">
									<option value="Female" {{\Auth::user() && \Auth::user()->gender!=null && \Auth::user()->gender=='Female' ? 'selected' : ''}}>Female</option>
									<option value="Male" {{\Auth::user() && \Auth::user()->gender!=null && \Auth::user()->gender=='Male' ? 'selected' : ''}}>Male</option>
								</select>
							</div>
							
							<div class="col-md-5 pull-right" style="padding-left:0px !important; padding-right:0px !important;">
								<input value="{{\Auth::user() ? \Auth::user()->national_id : ''}}" class="form-control" autocomplete="off" type="text" required name="nationalid" placeholder="" class="form-control pull-right" style="" id="nationalid">
							</div>
						</div>
					</div>
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label class="pull-left" for="exampleFormControlInput1">Date of Birth</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-5 pull-left" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() ? \Auth::user()->date_of_birth : ''}}" class="form-control" autocomplete="off" type="text" name="dateofbirth" placeholder="" class="form-control pull-right" readonly style="" id="dob">
							</div>
						</div>
					</div>
					
					<hr>
				</form>
			</div>
			<div class="col col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
			</div>
			<div class="modal-footer" style="clear: both !important; border-top: 0px solid #e5e5e5;">
				<div class="col-md-12" style="padding-top:0px !important; padding-bottom:0px !important;">
					<a onclick="handleRegisterStepOneBack()" class="btn btn-danger pull-left btn col-md-5" style="margin-bottom:5px !important;">Back</a>
					<a onclick="handleRegisterStepOne()" class="btn btn-success btn col-md-5 pull-right" style="margin-bottom:5px !important;">Next</a>
				</div>
			</div>
		</div>
	</div>
</div>
















