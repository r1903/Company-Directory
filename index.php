<!doctype html>

<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Company Directory</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="PHP curd operation">	
        <link rel='icon' href='favicon.ico' type='image/x-icon'>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">        <link rel="stylesheet" href="libs/css/index.css" >
    </head>

	<body>
        <div id="preloader"></div>
		<div id="container">
			<header class="d-flex justify-content-between">
					<h1 class="title">Company Directory</h1>
                    <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
					    Add Employee
				    </button>								
			</header>
			<main class="main">
                <div class="d-flex justify-content-between flex-column flex-md-row formdiv">
                    <h4 class="d-none d-md-block">Employees List</h4>
                    <form class="d-flex flex-row">
                            <div class="mr-2">
                                <select name="locationOption" class="mb-2 btn" id="locationOption">
                            
                                </select>
                            </div>
                            <div class="mr-2">
                                <select name="departmentOption" class="mb-2 btn " id="departmentOption" placeholder="Department">
                                    
                                </select>
                            </div>
                        <div>
                            <button type="button" class="btn mb-2 search" onclick="searchList()">Search</button>
                        </div>
                    </form> 
                </div>
				<div id="employees">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th class="text-center">NAME</th>
                                <th class="d-none d-md-table-cell text-center">EMAIL ID</th>
                                <th class="d-none d-md-table-cell text-center">LOCATION</th>
                                <th class="d-none d-md-table-cell text-center">DEPARTMENT</th>
                                <th class="text-center">ACTIONS</th>
                            </tr> 
                        <thead>
                    <tbody id="tbody">          
                </div>
				
				<!-- Add Employee Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Add New Employee</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset()">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body" id="addError">
                            <form id="addform">
                                <div class="form_group">
                                    <label>First Name:</label>
                                    <input type="text" id="firstName" class="form-control" placeholder="First Name"></input>
                                </div>
                                <div class="firstNameError mb-3 text-danger" id="firstNameError"></div>
                                <div class="form_group">
                                    <label>Last Name:</label>
                                    <input type="text" id="lastName" class="form-control" placeholder="Last Name"></input>
                                </div>
                                <div class="lastNameError mb-3 text-danger" id="lastNameError"></div>
                                <div class="form_group">
                                    <label>Email:</label>
                                    <input type="email" id="email" class="form-control" placeholder="Email"></input>
                                </div>
                                <div class="emailError mb-3 text-danger" id="emailError"></div>
                                <div class="form_group">
                                    <label>Location:</label>
                                    <select name="location" class="form-control mb-2 mr-3" id="location" onchange="addOption(this.value)">
                                    </select>   
                                </div>
                                <div class="locationError mb-3 text-danger" id="locationError"></div>
                                <div class="form_group">
                                    <label>Department:</label>
                                    <select name="department" class="form-control mb-2 mr-3" id="department">
                                    </select>
                                </div>
                                <div class="mb-3 text-danger" id="serverError"></div>
                            </form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn" onclick="addEmployee()">Save</button>
                                <button type="button" class="btn" data-dismiss="modal" onclick="reset()">Back</button>
							</div>
						</div>
					</div>
				</div>

				<!-- update Modal -->
               
				<div class="modal hide fade" id="updateModal" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Update Employee Details</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetUpdateForm()">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body" id="editModel">
                                <div class="form_group mb-3">
                                    <label for="updateFirstName">First Name:</label>
                                    <input type="text" id="updateFirstName" class="form-control" placeholde="First Name"></input>
                                </div>
                                <div class="mb-3 text-danger" id="updateFnameError"></div>
                                <div class="form_group mb-3">
                                    <label for="updateLastName">Last Name:</label>
                                    <input type="text" id="updateLastName" class="form-control" placeholde="Last Name"></input>
                                </div>
                                <div class="updateLnameError mb-3 text-danger" id="updateLnameError"></div>
                                <div class="form_group mb-3">
                                    <label for="updateEmail">Email:</label>
                                    <input type="email" id="updateEmail" class="form-control" placeholde="Email"></input>
                                </div>
                                <div class="updateLnameError mb-3 text-danger" id="updateEmailError"></div>
                                <div class="form_group mb-3">
                                    <label for="updateLocation">Location:</label>
                                    <select name="updateLocation" class="form-control mb-2" id="updateLocation"  onchange="updateOption(this.value)">
                                    </select>
                                </div>
                                <div class="updateLnameError mb-3 text-danger"></div>
                                <div class="form_group">
                                    <label for="updateDepartment" >Department:</label>
                                    <select name="updatedepartment" class="form-control mb-2" id="updateDepartment">
                                    </select>
                                </div>
                                <div class="mb-3 text-danger" id="updateServerError"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn" onclick="editEmployeeDetails()">Update</button>
                                <button type="button" class="btn" data-dismiss="modal" onclick="resetUpdateForm()">Back</button>
                                <input type="hidden" id="hidden">
							</div>
						</div>
					</div>
				</div>
				
                <!----Model to show employee details--->

                <div class="modal hide fade" id="showModal" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Employee Details</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body" id="showDetails">
                                <p id="showName"></p>
                                <p id="showEmail"></p>
                                <p id="showLocation"></p>
                                <p id="showDepartment"></p>
							
							</div>
							<div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
							</div>
						</div>
					</div>
				</div>
				
			</main>
		</div>
	<script type="application/javascript" src="libs/js/jquery-2.2.3.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>    
    <script type="application/javascript" src="libs/js/script.js"></script>
	</body>

</html>