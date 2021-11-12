$(document).ready(()=>{
	// Manage navbar
		let navVisible = false;
		function manageNavbar() {
			if (navVisible == false) {
				$(".side-bar").addClass('show-nav');
				$("#navBtn").html("<i class='fas fa-times'></i>");
				navVisible = true;
			}
			else {
				$(".side-bar").removeClass('show-nav');
				$("#navBtn").html("<i class='fas fa-bars'></i>");
				navVisible = false;
			}
		}
		$("#navBtn").click(()=>{
			manageNavbar();
		});

		// Poping alert box
		function popAlert(msg) {
			$("#msg").html("<i class='fas fa-info-circle'></i> " + msg + "");
			$("#msg").fadeIn();
			setTimeout(function () {
				$("#msg").fadeOut();
			}, 3000)
		}

		// Load questions
		function loadQuestionsTable() {
			let output = "";
			$.ajax({
				url: "../assets/phpStuff/fetchAllQuestions.php",
				method: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == true) {
						let x = data.data;
						let count = 1;
						for(let i = 0; i < x.length; i++){
							output += `<tr>
									<td>`+ count++ +`</td>
									<td>`+ x[i].question.substr(0,50)+"..."+ `</td>
									<td>`+ x[i].step_id +`</td>
									<td>
										<button class='btn-sm btn btn-danger del-btn' q-id='`+ x[i].q_id +`''> 
											<i class='fas fa-trash-alt'></i> Delete
										</button>
									</td>
								</tr>`;
						}
						$("#questions-table-body").html(output);
					}
					else {
						console.log(data.msg);
					}
				},
				error: function () {
					console.log("err wd fetch questions req");
				}
			});
		}
		loadQuestionsTable();

		// Loading steps for select input
		function loadOptions() {
			let output = "<option value='none'>Select</option>";
			$.ajax({
				url: "../assets/phpStuff/fetchStepsNav.php",
				method: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == true) {
						x = data.data;
						for (let i = 0; i < x.length; i++){
							output += `
									<option value='`+ x[i].step_id +`'>`+ x[i].name+` (`+ x[i].step_id +`)` +`</option>
								`; 
						}
						$("#stepsField").html(output);
					}

				},
				error: function () {
					console.log("Err wd fetch options req!");
				}
			});
		}
		loadOptions();

		// Saving question
		$("#addQuestion").click((e)=>{
			e.preventDefault();

			let question = $("#question-text").val();
			let step = $("#stepsField").val();

			const data = JSON.stringify({ question:question, step_id:step });

			$.ajax({
				url: "../assets/phpStuff/addQuestion.php",
				method: "POST",
				data: data,
				dataType: "json",
				success: function (data) {
					if (data.status == true) {
						loadQuestionsTable();
						$(".form")[0].reset();
						popAlert(data.msg);
					}
				},
				error: function () {
					console.log("err wd add question req");
				}

			});
		});

		// Delete question on click
		$("#questions-table-body").on('click', '.del-btn', function () {
			let id = $(this).attr("q-id");
			let myThis = this;
			if (confirm("Are You Sure?")) {
				const data = JSON.stringify({q_id:id});
				$.ajax({
					url: "../assets/phpStuff/deleteQuestion.php",
					method: "POST",
					data: data,
					dataType: "json",
					success: function (data) {
						if (data.status == true) {
							$(myThis).closest('tr').fadeOut();
							popAlert(data.msg);
						}
					},
					error: function () {
						console.log("err wd del question req");
					}

				});
			}
		});

		// Manage tabs
		$(".nav-list").on('click', '.tab-btn', function () {

			$('.tab').css('display', 'none');
			
			let name = $(this).attr('tab-target');
			$('section[tab-name="' + name + '"]').fadeIn();
		});

		// Fetch submissions
		function loadSubmissions() {
			let output = "";
			let count = 1;
			$.ajax({
				url: "../assets/phpStuff/fetchUsers.php",
				method: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == true) {
						x = data.data;
						for (let i = 0; i < x.length; i++){
							output += `<tr>
									<td>`+ count++ +`</td>
									<td>`+ x[i].name +`</td>
									<td class='mobile-hidden'>`+ x[i].email +`</td>
									<td>
										<button class='btn btn-info view-btn' user-id='`+ x[i].user_id +`'>View</button>
										<button class='btn btn-danger del-btn' user-id='`+ x[i].user_id +`'>Delete</button>
									</td>
								</tr>`;
						}
						$("#submissions-table").html(output);
					}

				},
				error: function () {
					console.log("Err wd fetch submissions req!");
				}
			});
		}
		loadSubmissions();

		// Display Submission Modal
		$("#submissions-table").on('click', '.view-btn', function () {
			let id = $(this).attr('user-id');
			const data = JSON.stringify({ user_id:id });
			let output = "";
			$.ajax({
				url: "../assets/phpStuff/fetchSubmission.php",
				method: "POST",
				data: data,
				dataType: "json",
				success: function (data) {
					console.log(data);
					if (data.status == true) {
						$("#submission-by").text(data.userName);
						x = data.data;
						for(let i = 0; i < x.length; i++){
							output += `
								<li>
									Id: <b>`+ x[i].q_id +`</b><br>
									`+ x[i].question +`<br>
									<span class='badge badge-success'>Ans:</span> <b>`+ x[i].answer +`</b>

								</li>
								<hr>
							`;
						}
						output = "<ul class='questions-list'>"+ output +"</ul>";
						$("#submission-info").html(output);
						$("#submission-modal").modal('show');
					}
				},
				error: function () {
					console.log("err wd fetch submission req");
				}

			});
		});

		// Display Submission Modal
		$("#submissions-table").on('click', '.del-btn', function () {
			if (confirm("Are you sure?")) {
				let id = $(this).attr('user-id');
				const data = JSON.stringify({ user_id:id });
				let output = "";
				let myThis = this;
				$.ajax({
					url: "../assets/phpStuff/deleteSubmission.php",
					method: "POST",
					data: data,
					dataType: "json",
					success: function (data) {
						if (data.status == true) {
							$(myThis).closest('tr').fadeOut();
							popAlert(data.msg);
						}
					},
					error: function () {
						console.log("err wd del submission req");
					}

				});
			}
		});
			
});// main