<!--Chrome Browser Notification-->
<div class="row" id="chromeNotification"></div>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" id="page-header">
           <!-- Dashboard <small>Statistics Overview</small>-->
          <?php 
            if($_SESSION['org_logo'] != ''){
              echo '<img src="' . $_SESSION['org_logo'] . '" />';
            } 
          ?>
          <small id="page_title_bar" style="color:white;margin-left:25px;"><i class="<?php echo $pageIcon; ?>"></i> <?php echo $pageName; ?></small>
        </h1>
        <!--<ol class="breadcrumb">
            <li class="active">
                <i class="<?php echo $pageIcon; ?>"></i> <?php echo $pageName; ?>
            </li>
        </ol>-->
    </div>
</div>