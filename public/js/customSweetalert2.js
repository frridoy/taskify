function deleteData(id) {
	Swal.fire({
	  title: 'Are you sure?',
	  text: "You won't be able to revert this!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
		console.log(id);
	  if (result.isConfirmed) {
	  	document.getElementById('delete-form-'+id).submit();  //custom edit.
	  	Swal.fire(
	      'Deleted!',
	      'Your file has been deleted.',
	      'success'
	    )
	  }
	});
}
