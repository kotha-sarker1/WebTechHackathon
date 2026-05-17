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
    const keyword = document.getElementById('search_keyword').value;
    const xhttp   = new XMLHttpRequest();

    xhttp.open('post', '../controllers/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('action=searchJobs&keyword=' + encodeURIComponent(keyword));

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const jobs = JSON.parse(this.responseText);
            renderJobCards(jobs);
        }
    }

    
}

function filterJobs(){
    const category_id    = document.getElementById('filter_category').value;
    const job_type       = document.getElementById('filter_type').value;
    const location       = document.getElementById('filter_location').value;
    const salary_keyword = document.getElementById('filter_salary').value;
    const xhttp          = new XMLHttpRequest();

    xhttp.open('post', '../controllers/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('action=filterJobs&category_id=' + encodeURIComponent(category_id) + '&job_type=' + encodeURIComponent(job_type) + '&location=' + encodeURIComponent(location) + '&salary_keyword=' + encodeURIComponent(salary_keyword));
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const jobs = JSON.parse(this.responseText);
            renderJobCards(jobs);
        }
    }

    
}

function renderJobCards(jobs){
    const container = document.getElementById('jobs_container');

    if(jobs.length == 0){
        container.innerHTML = "<p>No jobs found.</p>";
        return;
    }

    let html = "";

    jobs.forEach(function(job){
        const is_saved    = job.is_saved == "yes";
        const heart_color = is_saved ? "red" : "#aaa";
        const heart_icon  = is_saved ? "&#9829;" : "&#9825;";

        html += "<div class='job-card'>";
        html += "<div class='job-card-top'>";
        html += "<div class='job-card-info'>";
        html += "<h3>" + escapeHtml(job.title) + "</h3>";
        html += "<div class='company'>" + escapeHtml(job.company_name) + "</div>";
        html += "<div class='meta'>" + escapeHtml(job.category_name) + " &nbsp;|&nbsp; " + escapeHtml(job.location) + " &nbsp;|&nbsp; " + escapeHtml(job.job_type) + "<br>Salary: " + escapeHtml(job.salary_range) + " &nbsp;|&nbsp; Deadline: " + escapeHtml(job.deadline) + "</div>";
        html += "</div>";
        html += "<button class='heart-btn' id='heart_btn_" + job.id + "' onclick='toggleSaveJob(" + job.id + ")' style='color:" + heart_color + ";'>" + heart_icon + "</button>";
        html += "</div>";
        html += "<div class='job-card-footer'>";
        html += "<a class='btn-view' href='job_detail.php?id=" + job.id + "'>View Details</a>";
        html += "</div></div>";
    });

    container.innerHTML = html;
}

function toggleSaveJob(job_id){
    const heart = document.getElementById('heart_btn_' + job_id);
    const xhttp = new XMLHttpRequest();

    xhttp.open('post', '../controllers/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('action=toggleSaveJob&job_id=' + job_id);
    
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

    xhttp.send('action=toggleSaveJob&job_id=' + job_id);
}
