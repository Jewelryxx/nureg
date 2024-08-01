<?php
session_start();

// ตรวจสอบว่ามีการส่งข้อมูล itemId มาหรือไม่
if(isset($_POST['itemId'])) {
    // รับค่า itemId จาก POST data
    $itemId = $_POST['itemId'];

    // ถ้าตะกร้ายังไม่ถูกสร้างใน Session ให้สร้างตะกร้าใน Session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // เพิ่ม itemId เข้าไปในตะกร้าใน Session
    $_SESSION['cart'][] = $itemId;

    // ดึงข้อมูลตะกร้าจาก Session
    $cartContents = $_SESSION['cart'];

    // แสดงข้อมูลตะกร้า
    echo '<h1>Shopping Cart</h1>';
    echo '<ul>';
    foreach ($cartContents as $item) {
        echo '<li>Item ID: ' . $item . '</li>';
    }
    echo '</ul>';
}
if(isset($_GET['course'])) {

    $removeCourseCode = $_GET['course'];

    // ตรวจสอบว่าตะกร้าถูกสร้างและไม่ว่าง
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $indexToRemove = array_search($removeCourseCode, $_SESSION['cart']);

        // ถ้าพบ $removeCourseCode ในตะกร้า
        if ($indexToRemove !== false) {
            // ลบ $removeCourseCode ออกจากตะกร้า
            unset($_SESSION['cart'][$indexToRemove]);
            echo 'Course removed from cart';
        } else {
            echo 'Course not found in the cart.';
        }
    } else {
        echo 'The cart is empty.';
    }
}
?>
