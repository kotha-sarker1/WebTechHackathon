function toggleStatus(id){

    var xhttp = new XMLHttpRequest();

    xhttp.open("POST", "../controllers/ToggleJobStatus.php", true);

    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.send("id=" + id);

    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){

            var button = document.getElementById("statusBtn" + id);

            button.innerHTML = this.responseText;

            if(this.responseText == "active"){

                button.style.backgroundColor = "green";

            }else{

                button.style.backgroundColor = "red";

            }

        }

    }

}