// JavaScript file: search_customer.js

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("searchForm").addEventListener("submit", function(event) {
        event.preventDefault(); // ไม่ให้แบบฟอร์มส่งข้อมูลแบบธรรมดา
        
        var cusPort = document.getElementById("cus_port").value;
        
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "search_customer.php?cus_port=" + cusPort, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("customerResult").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });
});
