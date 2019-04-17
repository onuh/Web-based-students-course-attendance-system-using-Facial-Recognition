	<div id="Edit_course<?php echo $course_id; ?>" class="modal hide fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >

		<div class="modal-body">
			<div class="alert alert-info"><strong>Edit Course</strong></div>
	<form class="form-horizontal" method="post" action="Adhome.php">
			<div class="control-group">
				<label class="control-label" for="course_title">Course Title</label>
				<div class="controls">
				<input type="hidden" id="" name="course_id" value="<?php echo $row2['course_id']; ?>" required>
				<input type="text" id="" name="course_title" value="<?php echo $row2['course_title']; ?>" required>
			</div><br/>
			<div class="control-group">
				<label class="control-label" for="inputCourseCode">Course Code</label>
				<div class="controls">
				<input type="text" name="course_code" id="" value="<?php echo $row2['course_code']; ?>" required>
				</div>
			</div>
				
				
			<div class="control-group">
				<div class="controls">
				<button name="editCourse" type="submit" class="btn btn-success"><i class="icon-save icon-large"></i>&nbsp;Update</button>
				</div>
			</div>
    </form>
		</div>
    </div>
	
	
	<style type="text/css">

		
	</style>

	