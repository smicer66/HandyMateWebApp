<div class="modal fade domals" id="registerStepThreeModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="width: 500px !important">
		<div class="modal-content">
			<div class="modal-header bg-primary" style="color: #fff">
				<h5 class="modal-title col-md-11" id="registerStepThreeModalLabel"><i class="fa fa-user"></i> Update Your Profile - Step Three</h5>
				<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true" class="pull-right">&times;</span>
				</button>
			</div>
			<div class="modal-body col-md-12" style="display: inline-block;">
				<form action="/auth/register" method="post" id="registersteptwoform">
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">About You</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<textarea class="form-control" name="profile" id="profile" placeholder="Provide Your profile" rows="4">{!!\Auth::user() && \Auth::user()->profile!=null ? \Auth::user()->profile : ''!!}</textarea>
							</div>
						</div>
					</div>
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Guarantors First Name</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->first_name!=null ? \Auth::user()->guarantor[0]->first_name : ''}}" class="form-control" autocomplete="off" type="text" name="guarantorfirstname" placeholder="example Plot 100 Crimson Avenue" class="form-control pull-right" style="" id="guarantorfirstname">
							</div>
						</div>
					</div>
					
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Guarantors Other Name</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->other_name!=null ? \Auth::user()->guarantor[0]->other_name : ''}}" class="form-control" autocomplete="off" type="text" name="guarantorothername" placeholder="example Plot 100 Crimson Avenue" class="form-control pull-right" style="" id="guarantorothername">
							</div>
						</div>
					</div>
					
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Guarantors Last Name</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->last_name!=null ? \Auth::user()->guarantor[0]->last_name : ''}}" class="form-control" autocomplete="off" type="text" name="guarantorlastname" placeholder="example Plot 100 Crimson Avenue" class="form-control pull-right" style="" id="guarantorlastname">
							</div>
						</div>
					</div>
					
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Guarantors Home Address</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->address!=null ? \Auth::user()->guarantor[0]->address : ''}}" class="form-control" autocomplete="off" type="text" name="guarantorhomeaddress" placeholder="example Plot 100 Crimson Avenue" class="form-control pull-right" style="" id="guarantorhomeaddress">
							</div>
						</div>
					</div>
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Guarantors Mobile Number<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-3" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<select class="form-control pull-left" name="guarantorprefix" required style="border-radius: 4px 0 0 4px !important; border-right: 0px !important;" id="guarantorprefix">
									
									@foreach($countries as $country)
									<option value="{{$country->call_prefix}}" {{\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->mobile_number!=null && \Auth::user()->guarantor[0]->mobile_number!=null && substr(\Auth::user()->guarantor[0]->mobile_number, 0, 3)==$country->call_prefix ? 'selected' : ''}}>+{{$country->call_prefix}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-9" style="padding-left:0px !important; padding-right:0px !important;">
								<input value="{{\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->mobile_number!=null && \Auth::user()->guarantor[0]->mobile_number!=null ? substr(\Auth::user()->guarantor[0]->mobile_number, 3) : ''}}" id="guarantormobilenumber"  class="form-control" autocomplete="off" type="tel" name="guarantormobilenumber" placeholder="example 967300000" class="form-control pull-right" style="border-radius: 0 4px 4px 0 !important; border-left: 0px !important;"placeholder="">
							</div>
						</div>
					</div>
					
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">City</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<input value="{{\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->city!=null ? \Auth::user()->guarantor[0]->city : ''}}" class="form-control" autocomplete="off" type="text" name="guarantorcity" placeholder="example Plot 100 Crimson Avenue" class="form-control pull-right" style="" id="guarantorcity">
							</div>
						</div>
					</div>
					
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Guarantor Is Located In<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<select class="form-control pull-left" name="guarantor_country" style="border-radius: 4px 0 0 4px !important; border-right: 0px !important;" id="guarantor_country">
									<option>-Select One-</option>
									@foreach($countries as $country)
									<option {{\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->country_id!=null && \Auth::user()->guarantor[0]->country_id==$country->id ? 'selected' : ''}} value="{{$country->id}}|||{{$country->name}}">{{$country->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
					
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Guarantor Lives At Which Province & District<span style="color: red">*</span></label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-5 pull-left" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<select class="form-control pull-left" required name="guarantor_province" style="border-radius: 4px 0 0 4px !important;" id="guarantor_state_id">
									@if(\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->state_id!=null)
										<option value="{{\Auth::user()->guarantor[0]->state_id}}">{{\Auth::user()->guarantor[0]->province->name}}</option>
									@endif
								</select>
							</div>
							
							<div class="col-md-5 pull-right" style="padding-left:0px !important; padding-right:0px !important;">
								<select class="form-control pull-left" name="guarantor_district" style="border-radius: 4px 0 0 4px !important;" id="guarantor_lga_id" required >
									@if(\Auth::user() && \Auth::user()->guarantor!=null && sizeof(\Auth::user()->guarantor)>0 && \Auth::user()->guarantor[0]->district_id!=null)
										<option value="{{\Auth::user()->guarantor[0]->district_id}}">{{\Auth::user()->guarantor[0]->district->lga_name}}</option>
									@endif
								</select>
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
					<a onclick="handleRegisterStepThreeBack()" class="btn btn-danger pull-left btn col-md-5" style="margin-bottom:5px !important;">Back</a>
					<a onclick="handleRegisterStepThree()" class="btn btn-success btn col-md-5 pull-right" style="margin-bottom:5px !important;">Save My Profile</a>
				</div>
			</div>
		</div>
	</div>
</div>
















