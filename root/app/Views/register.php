<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register | Reseller Solutions</title>
    <?php include 'global/sections/head.php'; ?>
</head>

<body>
	<!-- Preloader -->
	<?php //include 'global/sections/preloader.php'; ?>
	<!-- /Preloader -->
    <div class="wrapper theme-4-active pimary-color-red">

	<!--Login-->

		<div class="wrapper pa-0">
				<!--<div class="form-group mb-0 pull-right">
					<span class="inline-block pr-10">Having Issues?</span>
					<a class="inline-block btn btn-info btn-rounded btn-outline" href="mailto:support@ignition-innovations.com?subject=Customer%20Portal%20Issue%20Report&body=I%20am%20having%20an%20issue%20with%20the%20following:">Contact Support</a>
				</div>
				<div class="clearfix"></div>-->
			
			<!-- Main Content -->
			<div class="page-wrapper pa-0 ma-0 auth-page" style="min-height: 322px;">
				<div class="container-fluid">
					<!-- Row -->
					<div class="table-struct full-width full-height" style="height: 322px;">
						<div class="table-cell vertical-align-middle auth-form-wrap">
							<div class="auth-form  ml-auto mr-auto no-float">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<div class="mb-30">
											<h3 class="text-center txt-dark mb-10">
                        <img src="global/imgs/reseller-logo.png">
                      </h3>
											<h6 class="text-center nonecase-font txt-grey">Register below</h6>
										</div>	
										<div class="form-wrap">
											<form action="/" method="post">
                        <?php if(isset($login_validation)): ?>
                          <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                              <?= $login_validation->listErrors() ?>
                            </div>  
                          </div>
                        <?php endif; ?>
                        <input type="hidden" name="user_mode" id="user_mode" value="register" />
                        <div class="form-group">
													<label class="control-label mb-10" for="fname">First Name &nbsp;&nbsp; <span id="error_message" style="color:red;"><?= $error ?></span></label>
													<input type="text" class="form-control" required="" id="fname" name="fname" placeholder="First Name">
												</div>
                        <div class="form-group">
													<label class="control-label mb-10" for="lname">Last Name &nbsp;&nbsp; <span id="error_message" style="color:red;"><?= $error ?></span></label>
													<input type="text" class="form-control" required="" id="lname" name="lname" placeholder="Last Name">
												</div>
												<div class="form-group">
													<label class="control-label mb-10" for="username">Username &nbsp;&nbsp; <span id="error_message" style="color:red;"><?= $error ?></span></label>
													<input type="text" class="form-control" required="" id="username" name="username" placeholder="Enter Username">
												</div>
												<div class="form-group">
													<label class="pull-left control-label mb-10" for="password">Password</label>
													<!--<a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="forgot-password.html">forgot password ?</a>-->
													<div class="clearfix"></div>
													<input type="password" class="form-control" required="" id="password" name="password" placeholder="Enter Password">
												</div>
                        <div class="form-group">
													<label class="pull-left control-label mb-10" for="password_confirm">Confirm Password</label>
													<!--<a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="forgot-password.html">forgot password ?</a>-->
													<div class="clearfix"></div>
													<input type="password" class="form-control" required="" id="password_confirm" name="password_confirm" placeholder="Confirm Password">
												</div>
												
												<div class="form-group">
													<div class="checkbox checkbox-primary pr-10 pull-left">
														<input id="cb" name="cb" type="checkbox">
														<label for="cb"> Keep me logged in</label>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="form-group text-center">
													<button type="submit" class="btn btn-info btn-rounded">sign in</button>
												</div>
											</form>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->	
				</div>
				
			</div>
			<!-- /Login -->

				
	
			
			</div>
			
			
			<!-- Footer -->
			<?php include 'global/sections/footer.php'; ?>
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
	
	<!--Footer-->
	<?php include 'global/sections/includes.php'; ?>
  <script src="login/js/credentials.js"></script>
</body>

</html>