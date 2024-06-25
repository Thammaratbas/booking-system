// สร้างฟังก์ชันเพื่อตรวจสอบข้อความใหม่
function checkForNewMessages() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var newMessages = parseInt(this.responseText);
            if (newMessages > 0) {
                // เล่นเสียงเตือน
                var notificationSound = document.getElementById("notificationSound");
                notificationSound.play();
            }
        }
    };
    xhttp.open("GET", "get_new_messages_user.php", true);
    xhttp.send();
}

// เรียกใช้งานฟังก์ชันเพื่อตรวจสอบข้อความใหม่ทุกๆ 1 นาที
setInterval(checkForNewMessages, 1000); // ตรวจสอบทุก 1 นาที
