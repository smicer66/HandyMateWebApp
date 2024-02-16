<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="index-2.html">
                <img src="/img/clients/{{\Auth::user()->default_image!=null ? \Auth::user()->default_image->file_name : 'default.png'}}" style="height:50px" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}</span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">{{\Auth::user()->role_type}}<b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a onclick="handleWithdrawCash()">Withdraw Cash</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>


                <div id="sparkline1" class="small-chart m-t-sm"></div>
				@if(isset($wallets) && $wallets!=null)
                <div>
                    <h4 class="font-extra-bold m-b-xs">
						<small>
                        @foreach($wallets as $wallet)
							{{$wallet->currency}}{{number_format($wallet->current_balance, 2, '.', ',')}}<br>
						@endforeach
						</small>
                    </h4>
                    <small class="text-muted">Current Balance</small>
                </div>
				@else
					@if(isset($clientProjectsSupreme) && $clientProjectsSupreme!=null)
					<div>
						<h4 class="font-extra-bold m-b-xs">
							<small>
							@foreach($clientProjectsSupreme as $curr => $cps)
								{{$curr}}{{number_format($cps, 2, '.', ',')}}<br>
							@endforeach
							</small>
						</h4>
						<small class="text-muted">Total Budgeted</small>
					</div>	
					@endif
				@endif
				
            </div>
        </div>

        <ul class="nav" id="side-menu">
            <li class="active">
                <a href="/admin/dashboard"> <span class="nav-label">My Dashboard</span> </a>
            </li>
			@if(in_array(\Auth::user()->role_type, ['Private Client']))
            <li>
                <a href="/admin/projects"> <span class="nav-label">My Projects</span> </a>
            </li>
			@endif
			@if(in_array(\Auth::user()->role_type, ['Artisan']))
            <li>
                <a href="/admin/bids"> <span class="nav-label">My Bids</span> </a>
            </li>
			@endif
			@if(in_array(\Auth::user()->role_type, ['Administrator']))
            <li>
                <a href="/admin/all-projects"> <span class="nav-label">All Projects</span> </a>
            </li>
			@endif
			@if(in_array(\Auth::user()->role_type, ['Private Client']))
            <li>
                <a href="/admin/transactions"> <span class="nav-label">My Transactions</span> </a>
            </li>
			@endif
			@if(in_array(\Auth::user()->role_type, ['Artisan']))
            <li>
                <a href="/admin/wallet-transactions"> <span class="nav-label">My Wallet Transactions</span> </a>
            </li>
			@endif
			@if(in_array(\Auth::user()->role_type, ['Administrator']))
            <li>
                <a href="/admin/all-transactions"> <span class="nav-label">All Transactions</span> </a>
            </li>
            <li>
                <a href="/admin/all-wallets"> <span class="nav-label">All Wallets</span> </a>
            </li>
            <li>
                <a href="/admin/all-wallet-transactions"> <span class="nav-label">All Wallet Transactions</span> </a>
            </li>
            <li>
                <a href="#"><span class="nav-label">Skills</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="/admin/new-skill">New Skill</a></li>
                    <li><a href="/admin/all-skills">All Skills</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><span class="nav-label">Users</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="/admin/new-admin-user">New Admin User</a></li>
                    <li><a href="/admin/all-users">All Users</a></li>
                </ul>
            </li>
			@endif
            <li>
                <a href="#"><span class="nav-label">Messages</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
					@if(in_array(\Auth::user()->role_type, ['Artisan', 'Private Client']))
                    <li><a href="/admin/messages">My Messages</a></li>
					@endif
					@if(in_array(\Auth::user()->role_type, ['Administrator']))
                    <li><a href="/admin/all-messages">All Messages</a></li>
					@endif
                </ul>
            </li>
			@if(in_array(\Auth::user()->role_type, ['Administrator']))
            <li>
                <a href="/admin/support-tickets"> <span class="nav-label">Support Tickets</span> </a>
            </li>
			@endif
        </ul>
    </div>
</aside>



@if(in_array(\Auth::user()->role_type, ['Artisan', 'Private Client']))
<div class="modal fade" id="withdrawCashModal" tabindex="-1" role="dialog" aria-labelledby="withdrawCashModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary" style="background-color: #000 !important; color: #fff !important; color: #fff; padding: 10px 10px !important;">
				<h5 class="modal-title col-md-11" id="withdrawCashModalLabel" style="color: #fff !important; font-size: 20px !Important; font-weight: bold">Request For Cash Withdrawal</h5>
				<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true" class="pull-right">&times;</span>
				</button>
			</div>
			<form action="/admin/wallet-manage/request-wallet-debit" method="post">
				<div class="modal-body col-md-12" style="padding-bottom: 0px !important; display: inline-block; padding-left: 0px !important; padding-right: 0px !important; ">
					<div class="row col-md-12" style="margin-left: 0px; padding-bottom: 15px !Important; padding-right: 0px !important; padding-left: 0px !important">
						<div class="col-md-12" style="">
							<div class="form-group">
								When you make a request for a cash withdrawal, your wallet gets debited the amount. The amount requested will be paid into your specified bank account. <br>Our payout days are <strong>Mondays and Fridays</strong>
							</div>
						</div>

						<div class="col-md-12" style="padding: 0px !important;" id="all_support_messages">
							
								
							<div class="form-group col-md-12" style="padding-bottom: 10px !important; background-color: #f4f4f4 !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important; border-bottom: 1px #000 solid">
								
								
								<div class="col col-md-12" style="padding-top: 10px !important">
									<label>Select Your Wallet:</label><br>
									<select name="wallet" id="wallet" class="form-control col col-md-12">
										@foreach($wallets as $wallet)
										<option value="{{$wallet->wallet_number}}">{{$wallet->wallet_number}} - Current Balance ({{$wallet->currency}}{{number_format($wallet->current_balance, 2, '.', ',')}})</option>
										@endforeach
									</select>
								</div>
								<div class="col col-md-6" style="padding-top: 10px !important">
									<label>Select Bank:</label><br>
									<select name="bank" id="bank" class="form-control col col-md-12">
										@foreach($banks as $bank)
										<option value="{{$bank->id}}">{{$bank->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="col col-md-6" style="padding-top: 10px !important">
									<label>Bank Account Name:</label><br>
									<input type="text" name="accountname" class="form-control col col-md-12">
								</div>
								<div class="col col-md-6" style="padding-top: 10px !important">
									<label>Bank Account Number:</label><br>
									<input type="number" name="accountnumber" class="form-control col col-md-12">
								</div>
								<div class="col col-md-6" style="padding-top: 10px !important">
									<label>Withdraw Amount:</label><br>
									<input type="number" name="amount" class="form-control col col-md-12" step="0.1">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col col-md-12 composemessages" id="compose" style="">
						<button type="submit" class="btn btn-primary pull-right">Send Response</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endif

<script>
function handleWithdrawCash()
{
	$('#withdrawCashModal').modal('toggle');
}
</script>