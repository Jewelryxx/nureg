document.addEventListener("DOMContentLoaded", function () {
    fetchTotalStudents();
    fetchStudentsByYear(); // ให้โหลดข้อมูลทั้งหมดเมื่อหน้าเว็บโหลด
    fetchTotalDepartments();
    fetchTotalMajors();
    loadAreaChart();
});

function fetchTotalStudents() {
    fetch("api.php?action=total_students")
        .then(response => response.json())
        .then(data => {
            document.getElementById("totalStudentsCount").innerText = data.total_students;
        });
}

function fetchStudentsByYear() {
    // Get the selected year from the dropdown
    var selectedYear = document.getElementById("yearFilter").value;

    // Fetch data for the selected year
    fetch(`api.php?action=students_by_year&year=${selectedYear}`)
        .then(response => response.json())
        .then(data => {
            const studentsByYearList = document.getElementById("studentsByYearList");
            studentsByYearList.innerHTML = "";

            // Filter and display data for the selected year(s)
            data.forEach(entry => {
                if (selectedYear === 'all' || entry.Stu_year_of_study === selectedYear) {
                    const listItem = document.createElement("li");
                    listItem.innerText = `Year ${entry.Stu_year_of_study}: ${entry.total_students} students`;
                    studentsByYearList.appendChild(listItem);
                }
            });

            // If no data found for selected year(s), display a message
            if (studentsByYearList.children.length === 0) {
                const listItem = document.createElement("li");
                listItem.innerText = selectedYear === 'all' ? 'No data available for any year' : `No data available for year ${selectedYear}`;
                studentsByYearList.appendChild(listItem);
            }
        });
}



function fetchTotalDepartments() {
    fetch("api.php?action=total_departments")
        .then(response => response.json())
        .then(data => {
            document.getElementById("totalDepartmentsCount").innerText = data.total_departments;
        });
}

function fetchTotalMajors() {
    fetch("api.php?action=total_majors")
        .then(response => response.json())
        .then(data => {
            document.getElementById("totalMajorsCount").innerText = data.total_majors;
        });
}

document.getElementById("yearFilter").addEventListener("change", function () {
    fetchStudentsByYear();
});
