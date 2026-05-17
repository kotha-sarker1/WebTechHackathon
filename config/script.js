console.log("connected");

function escapeHtml(str){
    if(str == null || str == undefined) return "";
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function searchJobs(){
    const keyword = document.getElementById('searchKeyword').value;
    const xhttp   = new XMLHttpRequest();

    xhttp.open('post', '../controllers/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const jobs = JSON.parse(this.responseText);
            renderJobCards(jobs);
        }
    }

    xhttp.send('action=searchJobs&keyword=' + keyword);
}

function filterJobs(){
    const category_id    = document.getElementById('filterCategory').value;
    const job_type       = document.getElementById('filterType').value;
    const location       = document.getElementById('filterLocation').value;
    const salary_keyword = document.getElementById('filterSalary').value;
    const xhttp          = new XMLHttpRequest();

    xhttp.open('post', '../controllers/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const jobs = JSON.parse(this.responseText);
            renderJobCards(jobs);
        }
    }

    xhttp.send('action=filterJobs&category_id=' + category_id + '&job_type=' + job_type + '&location=' + location + '&salary_keyword=' + salary_keyword);
}

function renderJobCards(jobs){
    const container = document.getElementById('listWrap');

    if(jobs.length == 0){
        container.innerHTML = "<p>No jobs found.</p>";
        return;
    }

    let html = "";

    jobs.forEach(function(job){
        const isSaved    = job.is_saved == "yes";
        const heartColor = isSaved ? "red" : "#aaa";
        const heartIcon  = isSaved ? "&#9829;" : "&#9825;";

        html += "<div class='jcard'>";
        html += "<div class='jcard-head'>";
        html += "<div class='jcard-body'>";
        html += "<h3>" + escapeHtml(job.title) + "</h3>";
        html += "<div class='cname'>" + escapeHtml(job.cname_name) + "</div>";
        html += "<div class='jmeta'>" + escapeHtml(job.category_name) + " &nbsp;|&nbsp; " + escapeHtml(job.location) + " &nbsp;|&nbsp; " + escapeHtml(job.job_type) + "<br>Salary: " + escapeHtml(job.salary_range) + " &nbsp;|&nbsp; Deadline: " + escapeHtml(job.deadline) + "</div>";
        html += "</div>";
        html += "<button class='savebtn' id='sbtn_" + job.id + "' onclick='toggleSaveJob(" + job.id + ")' style='color:" + heartColor + ";'>" + heartIcon + "</button>";
        html += "</div>";
        html += "<div class='jcard-foot'>";
        html += "<a class='viewlink' href='job_detail.php?id=" + job.id + "'>View Details</a>";
        html += "</div></div>";
    });

    container.innerHTML = html;
}

function toggleSaveJob(jobId){
    const heart = document.getElementById('sbtn_' + jobId);
    const xhttp = new XMLHttpRequest();

    xhttp.open('post', '../controllers/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const response = JSON.parse(this.responseText);

            if(response.success){
                if(response.saved){
                    heart.innerHTML   = "&#9829;";
                    heart.style.color = "red";
                }else{
                    heart.innerHTML   = "&#9825;";
                    heart.style.color = "#aaa";
                }
            }
        }
    }

    xhttp.send('action=toggleSaveJob&job_id=' + jobId);
}
