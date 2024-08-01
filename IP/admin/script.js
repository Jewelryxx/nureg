document.addEventListener("DOMContentLoaded", function () {
    // เรียกใช้ฟังก์ชัน getData เมื่อหน้า HTML โหลดเสร็จ
    getData();
});

// ฟังก์ชันสำหรับเรียก API เพื่อดึงข้อมูล
function getData(selectedSubjectClass = "") {
    var apiUrl = "http://localhost/ip/admin/data.php/" + selectedSubjectClass;

    // Fetch data from API
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Process data and create chart
            createChart(data);
        })
        .catch(error => console.error('Error fetching data:', error));
}
function updateData() {
    // Get selected subject class from dropdown
    var selectedSubjectClass = document.getElementById('subjectClassDropdown').value;

    // Call getData with the selected subject class as a parameter
    getData(selectedSubjectClass);
}

  let ctx = document.getElementById('enrollmentsChart').getContext('2d');
  let enrollmentsChart;
  
  function createChart(data) {
      // Clear existing chart if it exists
      if (enrollmentsChart) {
          enrollmentsChart.destroy();
      }
  
      // Create a new chart
      enrollmentsChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: data.map(entry => entry.SubjectEnrollments_SubjectID),
              datasets: [{
                  label: 'Enrollment Count',
                  data: data.map(entry => entry.enrollment_count),
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
  }