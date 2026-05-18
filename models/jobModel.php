<?php

    require_once('db.php');

    function getAllActiveJobs(){
        $con  = getConnection();
        $jobs = [];

        if(!$con){
            return $jobs;
        }

        $sql    = "select j.*, c.name as category_name, ep.company_name
                   from jobs j
                   left join categories c on j.category_id = c.id
                   left join employer_profiles ep on j.employer_id = ep.user_id
                   where j.status = 'active' and j.deadline >= curdate()
                   order by j.created_at desc";
        $result = mysqli_query($con, $sql);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($jobs, $row);
            }
        }

        mysqli_close($con);
        return $jobs;
    }

    function getJobById($id){
        $con = getConnection();
        $job = [];

        if(!$con){
            return $job;
        }

        $sql    = "select j.*, c.name as category_name, ep.company_name, ep.industry, ep.description as company_desc, ep.website
                   from jobs j
                   left join categories c on j.category_id = c.id
                   left join employer_profiles ep on j.employer_id = ep.user_id
                   where j.id = {$id}";
        $result = mysqli_query($con, $sql);

        if($result && mysqli_num_rows($result) == 1){
            $job = mysqli_fetch_assoc($result);
        }

        mysqli_close($con);
        return $job;
    }

    function searchJobs($keyword){
        $con  = getConnection();
        $jobs = [];

        if(!$con){
            return $jobs;
        }

        $sql    = "select j.*, c.name as category_name, ep.company_name
                   from jobs j
                   left join categories c on j.category_id = c.id
                   left join employer_profiles ep on j.employer_id = ep.user_id
                   where j.status = 'active' and j.deadline >= curdate()
                   and (j.title like '%{$keyword}%' or j.description like '%{$keyword}%' or ep.company_name like '%{$keyword}%')
                   order by j.created_at desc";
        $result = mysqli_query($con, $sql);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($jobs, $row);
            }
        }

        mysqli_close($con);
        return $jobs;
    }

    function filterJobs($category_id, $job_type, $location, $salary_keyword = ""){
        $con  = getConnection();
        $jobs = [];

        if(!$con){
            return $jobs;
        }

        $sql = "select j.*, c.name as category_name, ep.company_name
                from jobs j
                left join categories c on j.category_id = c.id
                left join employer_profiles ep on j.employer_id = ep.user_id
                where j.status = 'active' and j.deadline >= curdate()";

        if($category_id    != ""){ $sql .= " and j.category_id = '{$category_id}'"; }
        if($job_type       != ""){ $sql .= " and j.job_type = '{$job_type}'"; }
        if($location       != ""){ $sql .= " and j.location like '%{$location}%'"; }
        if($salary_keyword != ""){
            $salary_num = (int) preg_replace("/[^0-9]/", "", $salary_keyword);
            if($salary_num > 0){
                $sql .= " AND (CAST(REPLACE(SUBSTRING_INDEX(j.salary_range, '-', 1), ',', '') AS UNSIGNED) <= {$salary_num} AND CAST(REPLACE(REGEXP_REPLACE(SUBSTRING_INDEX(j.salary_range, '-', -1), '[^0-9,]', ''), ',', '') AS UNSIGNED) >= {$salary_num})";
            }
        }


        $sql   .= " order by j.created_at desc";
        $result = mysqli_query($con, $sql);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($jobs, $row);
            }
        }

        mysqli_close($con);
        return $jobs;
    }

    function getAllCategories(){
        $con        = getConnection();
        $categories = [];

        if(!$con){
            return $categories;
        }

        $sql    = "select * from categories order by name asc";
        $result = mysqli_query($con, $sql);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($categories, $row);
            }
        }

        mysqli_close($con);
        return $categories;
    }

    function checkSavedJob($user_id, $job_id){
        $con = getConnection();

        if(!$con){
            return false;
        }

        $sql = "select * from saved_jobs where user_id = '{$user_id}' and job_id = '{$job_id}'";
        $result = mysqli_query($con, $sql);

        mysqli_close($con);
        return ($result && mysqli_num_rows($result) > 0);
    }

    function saveJob($user_id, $job_id){
        $con = getConnection();

        if(!$con){
            return false;
        }

        $sql    = "insert into saved_jobs (user_id, job_id) values('{$user_id}', '{$job_id}')";
        $result = mysqli_query($con, $sql);

        mysqli_close($con);
        return $result;
    }

    function unsaveJob($user_id, $job_id){
        $con = getConnection();

        if(!$con){
            return false;
        }

        $sql    = "delete from saved_jobs where user_id = '{$user_id}' and job_id = '{$job_id}'";
        $result = mysqli_query($con, $sql);

        mysqli_close($con);
        return $result;
    }

    function getSavedJobs($user_id){
        $con  = getConnection();
        $jobs = [];

        if(!$con){
            return $jobs;
        }

        $sql    = "select sj.*, j.title, j.location, j.job_type, j.deadline, ep.company_name
                   from saved_jobs sj
                   left join jobs j on sj.job_id = j.id
                   left join employer_profiles ep on j.employer_id = ep.user_id
                   where sj.user_id = '{$user_id}' and j.status = 'active'
                   order by sj.created_at desc";
        $result = mysqli_query($con, $sql);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($jobs, $row);
            }
        }

        mysqli_close($con);
        return $jobs;
    }

    function checkExistingApplication($job_id, $seeker_id){
        $con = getConnection();

        if(!$con){
            return false;
        }

        $sql    = "select * from applications where job_id = '{$job_id}' and seeker_id = '{$seeker_id}'";
        $result = mysqli_query($con, $sql);

        mysqli_close($con);
        return ($result && mysqli_num_rows($result) > 0);
    }

    function createApplication($job_id, $seeker_id, $cover_letter, $resume_path){
        $con = getConnection();

        if(!$con){
            return false;
        }

        $sql    = "insert into applications (job_id, seeker_id, cover_letter, resume_path, status)
                   values('{$job_id}', '{$seeker_id}', '{$cover_letter}', '{$resume_path}', 'Submitted')";
        $result = mysqli_query($con, $sql);

        mysqli_close($con);
        return $result;
    }

    function getApplicationsBySeeker($seeker_id){
        $con          = getConnection();
        $applications = [];

        if(!$con){
            return $applications;
        }

        $sql    = "select a.*, j.title as job_title, ep.company_name
                   from applications a
                   left join jobs j on a.job_id = j.id
                   left join employer_profiles ep on j.employer_id = ep.user_id
                   where a.seeker_id = '{$seeker_id}'
                   order by a.created_at desc";
        $result = mysqli_query($con, $sql);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($applications, $row);
            }
        }

        mysqli_close($con);
        return $applications;
    }

?>
