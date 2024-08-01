<?php
// ตรวจสอบว่ามีการส่งค่ามาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // ดึงค่า Year และ Semester จากฟอร์ม
  $year = $_POST["year"] ? $_POST["year"] : "DEFAULT"; // ถ้าไม่กรอกให้ใช้ค่า DEFAULT
  $semester = $_POST["semester"] ? $_POST["semester"] : "DEFAULT"; // ถ้าไม่กรอกให้ใช้ค่า DEFAULT

  // นำค่า Year และ Semester มาใช้ในคำสั่ง SQL
  $sql = "INSERT INTO subjectenrollments (SubjectEnrollments_SubjectID, SubjectEnrollments_TeacherID, SubjectEnrollments_StudentID, SumSubject_point, SubjectEnrollments_grade, Date_added, Year, Semester) VALUES (/* Your values here */, '$year', '$semester')";

  // ทำการ execute คำสั่ง SQL
  // ...

  // Redirect หรือแสดงข้อความบนหน้าเว็บตามความเหมาะสม
}
?>
