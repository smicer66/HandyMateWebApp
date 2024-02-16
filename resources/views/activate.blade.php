<div class="modal fade" id="activateAccountModal" tabindex="-1" role="dialog" aria-labelledby="activateAccountModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary" style="color: #fff">
				<h5 class="modal-title col-md-11" id="activateAccountModalLabel">Activate Account</h5>
				<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true" class="pull-right">&times;</span>
				</button>
			</div>
			<div class="modal-body col-md-12" style="display: inline-block;">
				<form action="/activate-account" method="post">
					<input type="hidden" name="mobile_activate" id="mobile_activate" value="">
					<div class="form-group" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Provide Your OTP</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-3" style="padding-left:5px !important; padding-right:5px !important;">
								<input type="text" name="otp[]" class="form-control pull-right" style="text-align:center" id="otp1" placeholder="">
							</div>
							<div class="col-md-3" style="padding-left:5px !important; padding-right:5px !important;">
								<input type="text" name="otp[]" class="form-control pull-right" style="text-align:center" id="otp2" placeholder="">
							</div>
							<div class="col-md-3" style="padding-left:5px !important; padding-right:5px !important;">
								<input type="text" name="otp[]" class="form-control pull-right" style="text-align:center" id="otp3" placeholder="">
							</div>
							<div class="col-md-3" style="padding-left:5px !important; padding-right:5px !important;">
								<input type="text" name="otp[]" class="form-control pull-right" style="text-align:center" id="otp4" placeholder="">
							</div>
						</div>
					</div>
					<div class="form-group" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Current Password</label>
						<input type="password" name="password" class="form-control col-md-12" id="password1" placeholder="">
					</div>
					<div class="form-group" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">New Password</label>
						<input type="password" name="new_password" class="form-control col-md-12" id="new_password" placeholder="">
					</div>
					<div class="form-group" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Repeat New Password</label>
						<input type="password" name="confirm_password" class="form-control col-md-12" id="confirm_password" placeholder="">
					</div>
					<input type="submit" class="btn btn-success pull-right btn col-md-12" style="margin-bottom:5px !important;" value="Activate My Account">
					<hr>
				</form>
			</div>
			<div class="modal-footer" style="clear: both !important">
				
			</div>
		</div>
	</div>
</div>
