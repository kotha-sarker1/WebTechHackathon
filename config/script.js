function filterJobs(){
    const category_id    = document.getElementById('filterCategory').value;
    const job_type       = document.getElementById('filterType').value;
    const location       = document.getElementById('filterLocation').value;
    const salary_keyword = document.getElementById('filterSalary').value;
    const xhttp          = new XMLHttpRequest();

    xhttp.open('post', '../Controller/jobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const jobs = JSON.parse(this.responseText);
            renderJobCards(jobs);
        }
    }

    xhttp.send('action=filterJobs&category_id=' + category_id + '&job_type=' + job_type + '&location=' + location + '&salary_keyword=' + salary_keyword);
}