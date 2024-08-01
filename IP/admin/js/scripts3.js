document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault();

  const formData = new FormData(this);

  fetch('filter.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('filteredResults').innerHTML = data;
  });
});
// Function to display number of results
function displayNumResults(data) {
  // Display the number of results
  console.log('Number of Results:', data.num_rows);
}

// Function to generate table based on data
function generateTable(data) {
  // Generate table based on the data
  console.log('Generating table with data:', data);
}

document.getElementById('filterForm').addEventListener('submit', function(event) {
  event.preventDefault();

  // Get form data
  const formData = new FormData(this);

  // Fetch filtered data
  fetch('filter.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json()) // Assume response is JSON format
  .then(data => {
    // Display number of results
    displayNumResults(data);

    // Generate table
    generateTable(data);
  })
  .catch(error => console.error('Error fetching filtered data:', error));
});
