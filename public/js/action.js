
$('#dob').datepicker({
	format: 'yyyy-mm-dd',
	endDate: '-0y'
	
});

$('#startDate').datepicker({
	format: 'yyyy-mm-dd',
	startDate: '+0d'
	
});

$('#endDate').datepicker({
	format: 'yyyy-mm-dd',
	startDate: '+0d'
	
});


function displayRegisterAccount()
{
	$('.domals').modal('hide');
	$('#registerModal').modal('show');
}


function displayLogin()
{
	$('.domals').modal('hide');
	$('#loginModal').modal('show');
	
}

function displayRecoverPassword()
{
	$('.domals').modal('hide');
	$('#recoverPasswordModal').modal('show');
}

function handleRegister()
{
	var roletype = $('#roletype').val();
	var prefix = $('#prefix').val();
	var username = $('#username').val();
	var password = $('#password').val();
	var confirmpassword = $('#confirmpassword').val();
	console.log(roletype);
	console.log(prefix);
	console.log(username);
	console.log(password);
	console.log(confirmpassword);
	
	
	if(password.length==0 || (password.length>0 && confirmpassword!=password))
	{
		toastr.error('Provide a valid password. Your confirmation password must match the password provided too');
	}
	if(roletype!=null && prefix!=null && username!=null && username.length>0 && (username.length==9))
	{
		
		var formData = new FormData();
		//{roleType:null, prefix:null, username:null, password:null, confirmpassword:null };
		formData.append('roleType', roletype);
		formData.append('prefix', prefix);
		formData.append('username',  username);
		formData.append('password',  password);
		formData.append('confirmpassword', confirmpassword);
		
		$.ajax({
			type: "POST",
			url: "/create-customer-account",
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			success: function (data1) {
				console.log(data1);
				if(data1.status==0)
				{
					$('.domals').modal('hide');
					//$('#registerStepOneModal').modal('show');
					window.location = '/?update-profile';
				}
				else
				{
					toastr.error(data1.message);
				}
			},
			error: function (e) {
				toastr.error(data1.message);
			}
		});
		
	}
	else
	{
		toastr.error('You must provide all required information');
	}
}

function handleRegisterStepOne()
{
	
	$('.domals').modal('hide');
	console.log($('#roletype').val());
	if($('#roletype').val()=='Artisan')
	{
		$('#registerStepTwoModal').modal('show');
	}
	else if($('#roletype').val()=='Private Client' || $('#roletype').val()=='Corporate Client')
	{
		$('#registerStepThreeModalLabel').html('<i class="fa fa-user"></i> Update Your Profile - Step Two');
		$('#registerStepThreeModal').modal('show');
	}
}

function handleRegisterStepTwo()
{
	$('.domals').modal('hide');
	$('#registerStepThreeModalLabel').html('<i class="fa fa-user"></i> Sign Up - Step Four');
	$('#registerStepThreeModal').modal('show');
}


function handleRegisterStepOneBack()
{
	$('.domals').modal('hide');
	$('#registerModal').modal('show');
}

function handleRegisterStepTwoBack()
{
	$('.domals').modal('hide');
	$('#registerStepOneModal').modal('show');
}

function handleRegisterStepThreeBack()
{
	$('.domals').modal('hide');
	$('#registerStepTwoModal').modal('show');
}

$(function () {

	$('.dates').datepicker({
		format: 'yyyy-mm-dd',
		startDate: '0d'
	});
	$('#employment_date').datepicker({format: 'yyyy-mm-dd'});
});


$('#country_id').on('change', function()
{
	$.ajax({
		type: "GET",
		url: "/get_state_by_country/" + $('#country_id').val(),
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data1) {
			console.log(data1);
			$('#lga_id').empty();
			$('#state_id').empty();
			$.each(data1.data, function(key, value) {
				console.log(value);
				console.log(key);
				$('#state_id').append($('<option>', { 
					value: key.length>0 ? key : value,
					text : value
				}));
				
			});
		},
		error: function (e) {
			toastr.error(data1.message);
		}
	});
});



$('#state_id').on('change', function(){
	//alert($('#state_id').val());
	$.ajax({
		type: "GET",
		url: "/get_lga_by_state/" + $('#state_id').val(),
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data1) {
			console.log(data1);
			
			$('#lga_id').empty();
			$.each(data1.data, function(key, value) {
				console.log(value);
				console.log(key);
				$('#lga_id').append($('<option>', { 
					value: key.length>0 ? key : null,
					text : value
				}));
				
			});
		},
		error: function (e) {
			toastr.error(data1.message);
		}
	});
});




$('#guarantor_country').on('change', function()
{
	$.ajax({
		type: "GET",
		url: "/get_state_by_country/" + $('#guarantor_country').val().split('|||')[0],
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data1) {
			console.log(data1);
			$('#guarantor_lga_id').empty();
			$('#guarantor_state_id').empty();
			$.each(data1.data, function(key, value) {
				console.log(value);
				console.log(key);
				$('#guarantor_state_id').append($('<option>', { 
					value: key.length>0 ? key : value,
					text : value
				}));
				
			});
		},
		error: function (e) {
			toastr.error(data1.message);
		}
	});
});



$('#guarantor_state_id').on('change', function(){
	$.ajax({
		type: "GET",
		url: "/get_lga_by_state/" + $('#guarantor_state_id').val(),
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data1) {
			console.log(data1);
			
			$('#guarantor_lga_id').empty();
			$.each(data1.data, function(key, value) {
				console.log(value);
				console.log(key);
				$('#guarantor_lga_id').append($('<option>', { 
					value: key.length>0 ? key : null,
					text : value
				}));
				
			});
		},
		error: function (e) {
			toastr.error(data1.message);
		}
	});
});

function handleRegisterStepThree()
{
	var continueYes = true;
	var roletype = $('#roletype').val();
	var firstname = $('#firstname').val();
	var othername = $('#othername').val();
	var lastname = $('#lastname').val();
	var homeaddress = $('#homeaddress').val();
	var city = $('#city').val();
	var country = $('#country_id').val();
	var state_id = $('#state_id').val();
	var lga_id = $('#lga_id').val();
	var gender = $('#gender').val();
	var nationalid = $('#nationalid').val();
	var dob = $('#dob').val();
	var skills = $('.skills');
	var skills_ = [];
	for( var i1=0; i1<skills.length; i1++)
	{
		var skill = skills[i1];
		if(skill.checked)
		{
			skills_.push(skill.value);
		}
	}
	skills = skills_;
	var profile = $('#profile').val();
	var guarantorfirstname = $('#guarantorfirstname').val();
	var guarantorlastname = $('#guarantorlastname').val();
	var guarantorothername = $('#guarantorothername').val();
	var guarantorhomeaddress = $('#guarantorhomeaddress').val();
	var guarantorcity = $('#guarantorcity').val();
	var guarantor_country = $('#guarantor_country').val();
	var guarantorprefix = $('#guarantorprefix').val();
	var guarantormobilenumber = $('#guarantormobilenumber').val();
	var guarantor_state_id = $('#guarantor_state_id').val();
	var guarantor_lga_id = $('#guarantor_lga_id').val();
	
	console.log(firstname);
	console.log(othername);
	console.log(lastname);
	console.log(homeaddress);
	console.log(city);
	console.log(country);
	console.log(state_id);
	console.log(lga_id);
	console.log(gender);
	console.log(nationalid);
	console.log(dob);
	console.log(skills);
	console.log(profile);
	console.log(guarantorfirstname);
	console.log(guarantorlastname);
	console.log(guarantorothername);
	console.log(guarantorhomeaddress);
	console.log(guarantorcity);
	console.log(guarantor_country);
	console.log(guarantorprefix);
	console.log(guarantormobilenumber);
	console.log(guarantor_state_id);
	console.log(guarantor_lga_id);
	
	
	if(firstname.length>0 && lastname.length>0 && homeaddress.length>0 && city.length>0 && country.length>0 && state_id.length>0
		&& lga_id.length>0 && gender.length>0 && nationalid.length>0 && dob.length>0 && guarantorfirstname.length>0 
		&& guarantorlastname.length>0 && guarantorhomeaddress.length>0 && guarantorcity.length>0 && guarantor_country.length>0 
		&& (guarantormobilenumber.length==9) && guarantor_state_id.length>0 && guarantor_lga_id.length>0)
	{
		continueYes = true;
	}
	else
	{
		toastr.error('Provide all required information. Required information have a red asterisk');
	}
	
	if(roletype=='Artisan')
	{
		if(skills.length==0 || skills.length>12)
		{
			continueYes = false;
			toastr.error('Ensure you specify between 1 and 12 skills');
		}
	}
	
	if(continueYes===true)
	{
		
		var formData = new FormData();
		//{roleType:null, prefix:null, username:null, password:null, confirmpassword:null };
		formData.append('firstname', firstname);
		formData.append('othername', othername);
		formData.append('lastname', lastname);
		formData.append('homeaddress', homeaddress);
		formData.append('city', city);
		formData.append('country', country);
		formData.append('state_id', state_id);
		formData.append('lga_id', lga_id);
		formData.append('gender', gender);
		formData.append('nationalid', nationalid);
		formData.append('dob', dob);
		formData.append('profile', profile);
		formData.append('guarantorfirstname', guarantorfirstname);
		formData.append('guarantorlastname', guarantorlastname);
		formData.append('guarantorothername', guarantorothername);
		formData.append('guarantorhomeaddress', guarantorhomeaddress);
		formData.append('guarantorcity', guarantorcity);
		formData.append('guarantor_country', guarantor_country);
		formData.append('guarantorprefix', guarantorprefix);
		formData.append('guarantormobilenumber', guarantormobilenumber);
		formData.append('guarantor_state_id', guarantor_state_id);
		formData.append('guarantor_lga_id', guarantor_lga_id);
		if(roletype=='Artisan')
		{
			formData.append('skills', skills);
		}
		
		$.ajax({
			type: "POST",
			url: "/update-customer-profile",
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			success: function (data1) {
				console.log(data1);
				if(data1.status==0)
				{
					var user = data1.user;
					if(user.role_type=='Private Client' || user.role_type=='Corporate Client')
						window.location = '/new-project-step-one';
					else if(user.role_type=='Artisan')
						window.location = '/all-projects';
					
					
					
				}
				else
				{
					toastr.error(data1.message);
				}
			},
			error: function (e) {
				toastr.error(data1.message);
			}
		});
		
	}
}