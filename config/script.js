function escapeHtml(str){
    if(str == null || str == undefined) return "";
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


function filterJobs(){
    const category_id    = document.getElementById('filterCategory').value;
    const job_type       = document.getElementById('filterType').value;
    const location       = document.getElementById('filterLocation').value;
    const salary_keyword = document.getElementById('filterSalary').value;
    const xhttp          = new XMLHttpRequest();

    xhttp.open('post', '../Controller/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('action=filterJobs&category_id=' + category_id + '&job_type=' + job_type + '&location=' + location + '&salary_keyword=' + salary_keyword);
}

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const jobs = JSON.parse(this.responseText);
            renderJobCards(jobs);
        }
    }

function searchJobs(){
    const keyword = document.getElementById('searchKeyword').value;
    const xhttp   = new XMLHttpRequest();

    xhttp.open('post', '../Controller/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('action=searchJobs&keyword=' + keyword);

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const jobs = JSON.parse(this.responseText);
            renderJobCards(jobs);
        }
    }

    
}  

function renderJobCards(jobs){
    const container = document.getElementById('jobsContainer');

    if(jobs.length == 0){
        container.innerHTML = "<p>No jobs found.</p>";
        return;
    }

    let html = "";

    jobs.forEach(function(job){
        const isSaved    = job.is_saved == "yes";
        const heartColor = isSaved ? "red" : "#aaa";
        const heartIcon  = isSaved ? "&#9829;" : "&#9825;";

        html += "<div class='job-card'>";
        html += "<div class='job-card-top'>";
        html += "<div class='job-card-info'>";
        html += "<h3>" + escapeHtml(job.title) + "</h3>";
        html += "<div class='company'>" + escapeHtml(job.company_name) + "</div>";
        html += "<div class='meta'>" + escapeHtml(job.category_name) + " &nbsp;|&nbsp; " + escapeHtml(job.location) + " &nbsp;|&nbsp; " + escapeHtml(job.job_type) + "<br>Salary: " + escapeHtml(job.salary_range) + " &nbsp;|&nbsp; Deadline: " + escapeHtml(job.deadline) + "</div>";
        html += "</div>";
        html += "<button class='heart-btn' id='heartBtn_" + job.id + "' onclick='toggleSaveJob(" + job.id + ")' style='color:" + heartColor + ";'>" + heartIcon + "</button>";
        html += "</div>";
        html += "<div class='job-card-footer'>";
        html += "<a class='btn-view' href='job_detail.php?id=" + job.id + "'>View Details</a>";
        html += "</div></div>";
    });
    container.innerHTML = html;
}
function toggleSaveJob(jobId){
    const heart = document.getElementById('heartBtn_' + jobId);
    const xhttp = new XMLHttpRequest();


    xhttp.open('post', '../Controller/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('action=toggleSaveJob&job_id=' + jobId);

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

    
}