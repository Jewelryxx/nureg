document.addEventListener('DOMContentLoaded', function() {
    // Get all delete buttons
    var deleteButtons = document.querySelectorAll('.deleteBtn');
  
    // Add event listener to each delete button
    deleteButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        var itemToRemove = this.getAttribute('data-item');
  
        // Perform AJAX request to deleteFromCart.php with the item to remove
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Display a success message or perform additional actions if needed
            alert('ลบวิชาที่เลือกเรียบร้อย');
            // Reload the page to reflect changes
            location.reload();
          }
        };
        xhr.open('GET', 'viewCart.php?item=' + itemToRemove, true)
        xhr.send() 
      });
    });
  });
  