<table class="table table-bordered table-hover table-striped">
  <thead class="bg-primary">
    <tr class="info">
      <th>Report Name</th>
      <th>Report Description</th>
      <th>View</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td><b>Item Cross-Check Report</b></td>
      <td>This report displays any items that indicate they are not syncronized correctly.</td>
      <td>
        <button type="button" class="btn btn-primary btn-sm" onclick="window.open('reports/reports/item-cross-check-report.php','_blank');">
          <i class="fa fa-eye"> View</i>
        </button>
      </td>
    </tr>
    
    <?php
      if($_SESSION['admin'] == 'Yes'){
        echo '<tr>
                <td><b>User Productivity Report</b></td>
                <td>This report displays all activities broken down by user.</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" onclick="window.open(\'reports/reports/user-productivity-report.php\',\'_blank\');">
                    <i class="fa fa-eye"> View</i>
                  </button>
                </td>
              </tr>';
      }
    ?>
  </tbody>
</table>