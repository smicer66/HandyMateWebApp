<div class="modal fade domals" id="registerStepTwoModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="width: 500px !important">
		<div class="modal-content">
			<div class="modal-header bg-primary" style="color: #fff">
				<h5 class="modal-title col-md-11" id="registerStepTwoModalLabel"><i class="fa fa-user"></i> Update Your Profile - Step Two</h5>
				<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true" class="pull-right">&times;</span>
				</button>
			</div>
			<div class="modal-body col-md-12" style="display: inline-block;">
				<form action="/auth/register" method="post" id="registersteptwoform">
					<div class="form-group col-md-12" style="padding-bottom:5px !important; display: inline-block">
						<label for="exampleFormControlInput1">Select a Maximum of 12 Skills</label>
						<div class="col-md-12" style=" padding:0px !important;">
							<div class="col-md-12" style="padding-left:0px !important; padding-right:0px !important; clear:both !important">
								<?php $i=0; ?>
								@foreach($skills as $skill)
									<div class="form-group col-md-5 {{$i%2==0 ? 'pull-left' : 'pull-right'}}" style="{{$i%2==0 ? 'clear: both; ' : ''}}padding-left: 0px !important; padding-right: 0px !important;">
										<input type="checkbox" class="skills" name="skills[]" value="{{$skill->id}}"> &nbsp;&nbsp;{{ucwords($skill->skill_name)}}
									</div>
								<?php
								$i++;
								?>
								@endforeach
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
					<a onclick="handleRegisterStepTwoBack()" class="btn btn-danger pull-left btn col-md-5" style="margin-bottom:5px !important;">Back</a>
					<a onclick="handleRegisterStepTwo()" class="btn btn-success btn col-md-5 pull-right" style="margin-bottom:5px !important;">Next</a>
				</div>
			</div>
		</div>
	</div>
</div>
















