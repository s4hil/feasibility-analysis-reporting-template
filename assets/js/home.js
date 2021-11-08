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
					let x = data.data;
					let count = 1;
					if (data.count > 0) {
						for(let i = 0; i < x.length; i++){
							output += `
								<fieldset class="form-group step-`+ stepToShow +`">
									<label>
										<b>`+ count++ +`.</b>
										`+ x[i].question + `
									</label>
									<select onblur="checkInput(e)" class="form-control" name=`+ x[i].q_id +`>
										<option value="">Select</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</fieldset>
							`;
						}

					}
					else {
						output = "No records found!";
					}
					// Change nav state after step completion
					setTimeout(function () {
						$(".nav-step-"+stepToShow).addClass('active-step');
						let a = $(".nav-step-"+(Number(stepToShow)-1).toString()).addClass('text-success');
						console.log(a);
					},500)
				}
				else {
					output = "Query Error!";
				}
				$('.step-questions').append("<div class='step-"+ stepToShow +"'>"+output+"</div>");
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
			
		$("#showPrevStep").attr("disabled", false);

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

}); // Main