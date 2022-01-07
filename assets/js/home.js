// Poping an alert to user
	function popAlert(msg) {
		$("#msg").html("<i class='fas fa-exclamation-circle'></i> "+msg);
		$("#msg").fadeIn();
		setTimeout(function () {
			$("#msg").fadeOut();
		}, 1500);
	}

// Add step comment
function addComment(elm) {
	let step = $(elm).attr('step-id');
	let comment = $(elm).closest('.form-group').find('.comment').val();
	let data = JSON.stringify({ step_id:step, comment_val:comment });

	$.ajax({
		url: "assets/phpStuff/addStepAttachments.php",
		method: "POST",
		data: data,
		dataType: "json",
		success: function (data) {
			if (data.status == true) {
				popAlert(data.msg);
				$(elm).closest('.form-group').find('.comment').val("");
			}
		},
		error: function () {
			console.log("err wd comment req");
		}
	});
}
$(document).ready(()=>{

	// fetch steps for side nav
	function loadStepsNav() {
		let output = "";
		$.ajax({
			url: "assets/phpStuff/fetchStepsNav.php",
			method: "GET",
			dataType: "json",
			success:function (data) {
				let x = data;
				if (x.status == true) {
					count = 1;
					for (let i = 0; i < x.data.length; i++){
						output += `
							<li class='inactive nav-step-`+ count +`'><div>`+ count++ +`</div>`+ x.data[i].name +`</li>
						`;
					}
					$(".steps-nav-list").html(output);
				}
			},
			error: function () {
				console.log("Err wd fetch steps nav req");
			}
		});
	}
	loadStepsNav();

	// Validate Select
	$('.step-questions').on('blur', '.check-option', function () {
		if ($(this).val() == "") {
			popAlert("All Fields Are Required!");
			$(this).focus();
			$("#showNextStep").prop('disabled', true);
		}
		else {
			$("#showNextStep").prop('disabled', false);
		}
	});


	// Save Comment
	$(".addComment").click((e)=>{
		console.log("clicked");
	});
	$("#btnAdd").click((e)=>{
		console.log("aaa");
	})
	
	
	function addC(e) {
		e.preventDefault();
		console.log("Cliked");
	}


	// Loading step questions
	function loadStep(stepToShow) {

		// Changing steps nav state
		let data = JSON.stringify({ step:stepToShow });
		let output = "";
		$.ajax({
			url:"assets/phpStuff/fetchQuestions.php",
			method: "POST",
			data: data,
			dataType: "json",
			success: function (data) {
				// console.log(data);
				if (data.status == true) {

					if (stepToShow == data.total_steps) {
						$("#showNextStep").hide();
						$("#submitForm").show();
					}

					$("#step-name").text(" "+data.step_name);
					$("#step-detail").text(" "+data.step_detail);
					let x = data.data;
					let count = 1;
					if (data.count > 0) {
						for(let i = 0; i < x.length; i++){
							output += `
								<fieldset class="form-group step-field step-`+ stepToShow +`">
									<label>
										<b class='question-number'>`+ count++ +`.</b>
										`+ x[i].question + `
									</label>
									<select required class="form-control check-option" name=`+ x[i].q_id +`>
										<option value="5">5</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</fieldset>
							`;
						}

						let stepAttachment = `
							<fieldset class="form-group border p-2 d-flex flex-column">
								<legend class="w-auto">Step Attachments</legend>
								<div>
									<label>Comment</label>
									<textarea class="comment form-control" rows="3" placeholder="Add Comment text" maxlength="200"></textarea>
								</div>
								<div>
									<div step-id='`+ stepToShow +`' onclick="addComment(this)" class="btn btn-info mt-3"><i class="fas fa-plus"></i> Add Comment</div>
								<div>
							</fieldset>
						`;
						output = output + stepAttachment;
					}

					else {
						output = "No records found!";
					}
					// Change nav state after step completion
					setTimeout(function () {
						$(".nav-step-"+stepToShow).addClass('active-step');
						let a = $(".nav-step-"+(Number(stepToShow)-1).toString()).addClass('text-success');
					},500)
				}
				else {
					output = "Query Error!";
				}
				$('.step-questions').append("<div class='step-box step-"+ stepToShow +"'>"+output+"</div>");
				let prevStep = stepToShow - 1;
				$(".step-"+prevStep).hide();
			},
			error: function () {
				console.log("err wd fetchQuestions req");
			}
		});
	}
	// Calling first step by default
	loadStep(1);

	// Display next step on click
	$("#showNextStep").click((e)=>{
		e.preventDefault();
			$("#showPrevStep").prop('disabled', false);

			let currentStep = $("#current-step").text();
			let stepToHide = "step-" + currentStep;
			let stepToShow = "step-" + (Number(currentStep)+1);


			loadStep(Number(currentStep)+1);
			$("#current-step").text(stepToShow.replace("step-", ""));

	});


	// Display Previous step
	$("#showPrevStep").click((e)=>{
		e.preventDefault();

		let currentStep = $("#current-step").text();

		loadStep(Number(currentStep) - 1);
	})

	// Submit form
	$("#submitForm").click(()=>{
		$(".step-box").show();
		$(".question-number").hide();
		$(".step-field").css("display", 'flex');

		// $(".wrapper").css('height', '100%');
		// $(".side-bar").css('height', '100%');
	});

}); // Main