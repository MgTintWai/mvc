<?php require APPROOT . '/views/inc/header.php';?>

<div class="wrapper d-flex align-items-stretch">

	   <?php include(APPROOT.'/views/inc/sidebar.php'); ?>

      <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

      <?php include(APPROOT.'/views/inc/navbar.php'); ?>

      <h2 class="mb-4">income</h2>

      <?php include(APPROOT.'/views/components/auth_message.php'); ?>

        <table class="table table-light text-center" id="myTable">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Assigned By</th>
                    <th>Date </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
        </table>
        <a href="<?php echo URLROOT ?>/incomeApi/create" class="btn btn-primary float-right mt-5">Add New</a>
      </div>
		</div>

  <!-- Delete Modal HTML -->
 		 <!-- <div id="deleteEmployeeModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<form>
						<div class="modal-header">						
							<h4 class="modal-title">Delete Employee</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>

						<div class="modal-body">					
							<p>Are you sure you want to delete these Records?</p>
							<p class="text-warning"><small>This action cannot be undone.</small></p>
						</div>

						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-danger" value="Delete">
						</div>
            
					</form>
				</div>
			</div>
		</div> -->

<?php require APPROOT . '/views/inc/footer.php';?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#myTable').DataTable({
      "ajax" : "<?php echo URLROOT ?>/incomeApi/incomeData",
      "columns" : [
        { "data" : "id" },
        { "data" : "category_name" },
        { "data" : "amount" },
        { "data" : "user_name" },
        { "data" : "date" },
        {
          mRender : function(data, type, full) {
            // console.log(full);
            return '<a href="<?php echo URLROOT;?>/incomeApi/edit/'+ full.id +'" type="submit"  class = "btn btn-primary ">Edit</a>';
          }
        },
        {
					mRender : function (data, type, full) {
						// console.log(full);
						return '<button type="submit" value="' + full.id + '" class="btn btn-danger delete">Delete</button>'
					}
				}
			]
		});

		$(document).on('click', '.delete', function () {
			var url_id = $(this).val();
			// alert(url_id);

			var form_url = '<?php echo URLROOT; ?>/incomeApi/destroy/'+ url_id;
			// alert(form_url);

			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plx!",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
				$.ajax({
					url: form_url,
					type: 'DELETE',
					error: function() {
						alert('Something is wrong');
					},
					success: function(data) {
						$("#"+url_id).remove();
						// swal("Deleted!", "Your imaginary file has been deleted.", "success");
						window.location.reload();
					}
				});
				} else {
				swal("Cancelled", "Your imaginary file is safe 🙂", "error");
				}
			});
		});

   

	});


  

</script>