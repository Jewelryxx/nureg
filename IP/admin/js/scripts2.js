document.addEventListener('DOMContentLoaded', function () {
    // Fetch data from your server using AJAX
    const fetchData = async () => {
      try {
        const response = await fetch('getData.php');
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error fetching data:', error);
        return null;
      }
    };
  
    // Once data is fetched, create the chart
    fetchData().then(majorData => {
      if (majorData !== null) {
        const majorLabels = majorData.map(major => major.Major_name);
        const studentCount = majorData.map(major => major.StudentCount);
        const minStudentCount = Math.min(...studentCount);
        const maxStudentCount = Math.max(...studentCount);
  
        // Create a bar chart
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: majorLabels,
            datasets: [
              {
                label: 'Number of Students',
                data: studentCount,
                backgroundColor: [
                  'rgba(75, 192, 192, 0.7)',
                  'rgba(255, 99, 132, 0.7)',
                  'rgba(255, 205, 86, 0.7)',
                  'rgba(54, 162, 235, 0.7)',
                  'rgba(255, 159, 64, 0.7)',
                  'rgba(153, 102, 255, 0.7)',
                  'rgba(255, 0, 0, 0.7)',
                  'rgba(0, 255, 0, 0.7)',
                  'rgba(255, 255, 0, 0.7)',
                  'rgba(0, 0, 255, 0.7)'
                ],
                borderColor: [
                  'rgba(75, 192, 192, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(255, 205, 86, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 0, 0, 1)',
                  'rgba(0, 255, 0, 1)',
                  'rgba(255, 255, 0, 1)',
                  'rgba(0, 0, 255, 1)'
                ],
                borderWidth: 2
              }
            ]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1, // Set the step size to 1 for integer values
                  // Add this line to ensure the y-axis starts at 1 if the minimum value is 1
                  min: minStudentCount === 1 ? 1 : 0
                }
              }
            }
          }
        });
      }
    });
  });