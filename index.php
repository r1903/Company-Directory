<!doctype html>

<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Gazetteer</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="map to display searched country">	
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">        <link rel="stylesheet" href="libs/css/index.css" >
    </head>

	<body>
		<div id="container">
			<header class="d-flex justify-content-between">
					<h1 class="title">Company Directory</h1>
                    <button type="button" class="btn bg-white" data-toggle="modal" data-target="#exampleModal">
					    New Employee
				    </button>								
			</header>
			<main class="main">
            <form class="row mb-4">
                <div class="col">
                    <select name="locationOption" class="form-control mb-2 mr-3" id="locationOption">
                
                    </select>
                </div>
                <div class="col">
                    <select name="departmentOption" class="form-control mb-2 mr-3" id="departmentOption" placeholder="Department">
                        
                    </select>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-primary form-control mb-2 mr-3">Search</button>
                </div>
            </form> 
				<div id="employees">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="d-none d-lg-table-cell d-xl-table-cell text-center">Manager</th>
                                <th class="text-center">Actions</th>
                            </tr> 
                        <thead>
                        <tbody id="tbody">          
                </div>
				
				<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
                                <div class="form_group">
                                    <label>First Name:</label>
                                    <input type="text" id="firstName" class="form-control" placeholder="First Name"></input>
                                </div>
                                <div class="form_group">
                                    <label>Last Name:</label>
                                    <input type="text" id="lastName" class="form-control" placeholder="Last Name"></input>
                                </div>
                                <div class="form_group">
                                    <label>Email:</label>
                                    <input type="email" id="email" class="form-control" placeholder="Email"></input>
                                </div>
                                <div class="form_group">
                                    <label>Manager:</label>
                                    <input type="text" id="manager" class="form-control" placeholder="Reporting Manager"></input>
                                </div>
                                <div class="form_group">
                                    <label>Location:</label>
                                    <select name="location" class="form-control mb-2 mr-3" id="location" onchange="addOption(this.value)">
                
                                    </select>
                                    
                                </div>
                                <div class="form_group">
                                    <label>Department:</label>
                                    <select name="department" class="form-control mb-2 mr-3" id="department">
                
                                    </select>
                                </div>
							
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-warning" data-dismiss="modal" onclick="addEmployee()">Save</button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

				<!-- update Modal -->
               
				<div class="modal hide fade" id="updateModal" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
                                <div class="form_group">
                                    <label for="updateFirstName">First Name:</label>
                                    <input type="text" id="updateFirstName" class="form-control" placeholde="First Name"></input>
                                </div>
                                <div class="form_group">
                                    <label for="updateLastName">Last Name:</label>
                                    <input type="text" id="updateLastName" class="form-control" placeholde="Last Name"></input>
                                </div>
                                <div class="form_group">
                                    <label for="updateEmail">Email:</label>
                                    <input type="email" id="updateEmail" class="form-control" placeholde="Email"></input>
                                </div>
                                <div class="form_group">
                                    <label for="updateManager">Manager:</label>
                                    <input type="text" id="updateManager" class="form-control" placeholde="Reporting Manager"></input>
                                </div>
                                <div class="form_group">
                                    <label for="updateLocation">Location:</label>
                                    <select name="updateLocation" class="form-control mb-2" id="updateLocation"  onchange="updateOption(this.value)">
                
                                    </select>
                                    
                                </div>
                                <div class="form_group">
                                    <label for="updateDepartment" >Department:</label>
                                    <select name="updatedepartment" class="form-control mb-2" id="updateDepartment">
                
                                    </select>
                                    
                                </div>
							
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-warning" data-dismiss="modal" onclick="updateEmployee()">Update</button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                <input type="hidden" id="hidden">
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