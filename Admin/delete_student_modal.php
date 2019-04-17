<div id="Remove_student<?php echo $id1; ?>" name="<?php echo $id1; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body">
			<div class="alert alert-danger">Are you Sure you want to remove <em><b><?php echo $row1['First_Name']." ".$row1['Surname']; ?></b></em> from this System? Deleting  will Erase all data including attendance information for <em><b><?php echo $row1['First_Name']." ".$row1['Surname']; ?></b></em>, Continue? </div>

		</div>
		<form method="POST" action="Action.php"></form>
		<div class="modal-footer">
			
		<a class="btn btn-success" href="Action.php<?php echo '?type='.$id1; ?>" ><i class="icon-check"></i>&nbsp;Yes</a>
			
		<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Cancel</button>
		</div>
    </div>

