<?php

class DatabaseConnection {

    function openConnection() {

        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "job_portal_db";

        $connection = new mysqli($db_host,$db_username,$db_password,$db_name);

        if($connection->connect_error){

            die("Database Connection Failed".$connection->connect_error);

        }

        return $connection;

    }

    function createCategory($connection, $tableName, $category_name){

        $sql = "INSERT INTO $tableName (name) VALUES('$category_name')";

        $result = $connection->query($sql);

        return $result;

    }

    function getAllCategories($connection, $tableName){

        $sql = "SELECT * FROM $tableName";

        $result = $connection->query($sql);

        return $result;

    }

    function deleteCategory($connection, $tableName, $id ){

        $sql = "DELETE FROM $tableName WHERE id = $id";

        $result = $connection->query($sql);

        return $result;

    }

    function checkCategoryHasJobs($connection, $tableName, $id){

        $sql = "SELECT * FROM jobs WHERE category_id = $id";

        $result = $connection->query($sql);

        return $result;

    }

    function createJob($connection, $tableName, $employer_id, $category_id, $title, $description, $requirements, $salary_range, $location, $job_type, $deadline){

        $sql = "INSERT INTO $tableName
        (employer_id, category_id, title, description, requirements, salary_range, location, job_type, deadline, status)

        VALUES

        ('$employer_id','$category_id','$title','$description','$requirements','$salary_range','$location','$job_type','$deadline','active')";

        $result = $connection->query($sql);

        return $result;

    }

    function getEmployerJobs($connection, $tableName, $employer_id){

        $sql = "SELECT jobs.*, categories.name as category_name

        FROM jobs

        JOIN categories

        ON jobs.category_id = categories.id

        WHERE employer_id = $employer_id";

        $result = $connection->query($sql);

        return $result;

    }

    function deleteJob($connection, $tableName, $id){

        $sql = "DELETE FROM $tableName WHERE id = $id";

        $result = $connection->query($sql);

        return $result;

    }

    function getEmployerJobsWithApplicationCount($connection, $employer_id){

    $sql = "SELECT jobs.*,
    
    categories.name as category_name,

    COUNT(applications.id) as total_applications

    FROM jobs

    JOIN categories

    ON jobs.category_id = categories.id

    LEFT JOIN applications

    ON jobs.id = applications.job_id

    WHERE jobs.employer_id = $employer_id

    GROUP BY jobs.id";

    $result = $connection->query($sql);

    return $result;
    }

    function toggleJobStatus($connection, $id){

    $checkSql = "SELECT status FROM jobs WHERE id = $id";

    $checkResult = $connection->query($checkSql);

    $row = $checkResult->fetch_assoc();

    $currentStatus = $row["status"];

    if($currentStatus == "active"){

        $newStatus = "closed";

    }else{

        $newStatus = "active";

    }

    $sql = "UPDATE jobs SET status = '$newStatus' WHERE id = $id";

    $result = $connection->query($sql);

    return $newStatus;
    }

    function getCategoryById($connection, $tableName, $id){

    $sql = "SELECT * FROM $tableName WHERE id = $id";

    $result = $connection->query($sql);

    return $result;

    }

    function updateCategory($connection, $tableName, $id, $name){

    $sql = "UPDATE $tableName
    SET name = '$name'
    WHERE id = $id";

    $result = $connection->query($sql);

    return $result;

    }

    function getJobById($connection, $tableName, $id){

    $sql = "SELECT * FROM $tableName WHERE id = $id";

    $result = $connection->query($sql);

    return $result;

    }

    function updateJob($connection, $tableName, $id, $category_id, $title, $description, $requirements, $salary_range, $location, $job_type, $deadline){

    $sql = "UPDATE $tableName

    SET

    category_id = '$category_id',
    title = '$title',
    description = '$description',
    requirements = '$requirements',
    salary_range = '$salary_range',
    location = '$location',
    job_type = '$job_type',
    deadline = '$deadline'

    WHERE id = $id";

    $result = $connection->query($sql);

    return $result;

    }

        $connection = new mysqli("localhost", "root", "", "job_portal_db");

        if ($connection->connect_error) {
            die("Database Connection Failed: " . $connection->connect_error);
        }

        return $connection;
    }

    function RegisterUser($connection, $name, $email, $passHash, $role, $path) {

        $sql = "INSERT INTO users (name, email, password_hash, role, file_path)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("sssss", $name, $email, $passHash, $role, $path);

        return $stmt->execute();
    }

    function GetUserByEmail($connection, $email) {

        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        return $stmt->get_result();
    }

    function CheckEmailExists($connection, $email) {

        $sql = "SELECT id FROM users WHERE email = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    function checkProfileIncomplete($connection, $user_id, $role) {

        $table = ($role == 'employer') ? 'employer_profiles' : 'seeker_profiles';

        $sql = "SELECT id FROM $table WHERE user_id = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result()->num_rows == 0;
    }

    function saveEmployerProfile($connection, $id, $company, $industry, $desc, $website) {

        $sql = "INSERT INTO employer_profiles (user_id, company_name, industry, description, website)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("issss", $id, $company, $industry, $desc, $website);

        return $stmt->execute();
    }

    function saveSeekerProfile($connection, $id, $headline, $skills, $exp) {

        $sql = "INSERT INTO seeker_profiles (user_id, headline, skills, years_experience)
                VALUES (?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("issi", $id, $headline, $skills, $exp);

        return $stmt->execute();
    }

    function getProfileData($connection, $user_id, $role) {

        $table = ($role == 'employer') ? 'employer_profiles' : 'seeker_profiles';

        $sql = "SELECT * FROM $table WHERE user_id = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    function updateEmployerProfile($connection, $id, $company, $industry, $desc, $website) {

        $sql = "UPDATE employer_profiles SET company_name=?, industry=?, description=?, website=?
                WHERE user_id=?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("ssssi", $company, $industry, $desc, $website, $id);

        return $stmt->execute();
    }

    function updateSeekerProfile($connection, $id, $headline, $skills, $exp) {

        $sql = "UPDATE seeker_profiles SET headline=?, skills=?, years_experience=?
                WHERE user_id=?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("ssii", $headline, $skills, $exp, $id);

        return $stmt->execute();
    }
}

?>